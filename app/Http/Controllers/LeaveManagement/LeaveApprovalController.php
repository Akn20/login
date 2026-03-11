<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaveApprovals;
use App\Models\LeaveRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaveApprovalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | WEB FUNCTIONS (Blade Views)
    |--------------------------------------------------------------------------
    */

    /**
     * Display leave requests filtered by Role and Level
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = LeaveRequests::query()->with(['staff', 'leaveType']);

        // 1. Filter visibility by Role and Level
        if ($user->hasRole('manager')) {
            $query->where('current_approval_level', 1)
                ->whereHas('staff', function ($q) use ($user) {
                    $q->where('level1_supervisor_id', $user->staff->id);
                });
        } elseif ($user->hasRole('hr')) {
            $query->where('current_approval_level', 2);
        } elseif ($user->hasRole('hod')) {
            $query->where('current_approval_level', 3);
        }

        // 2. Search & Filter
        if ($request->search) {
            $query->where('employee_id', $request->search);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        $leaveRequests = $query->latest()->paginate(10);

        return view('admin.Leave_Management.leave_request_approval.index', compact('leaveRequests'));
    }

    /**
     * Show leave details with sorted approval history
     */
    public function show($id)
    {
        $leave = LeaveRequests::with(['staff', 'leaveType', 'approvals.user'])->findOrFail($id);

        // Sort history by level to show the path taken
        $leave->approvals = $leave->approvals->sortBy('level');

        return view('admin.Leave_Management.leave_request_approval.show', compact('leave'));
    }

    /**
     * Handle Web Approvals (Sequential)
     */
    public function approve(Request $request, $id)
    {
        $leave = LeaveRequests::findOrFail($id);
        $user = auth()->user();

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This request is already processed.');
        }

        // Sequential Logic
        if ($user->hasRole('manager') && $leave->current_approval_level == 1) {
            $leave->update(['current_approval_level' => 2]);
            $this->logApproval($leave->id, $user->id, 1, 'Approved by Manager');
        } elseif ($user->hasRole('hr') && $leave->current_approval_level == 2) {
            $leave->update(['current_approval_level' => 3]);
            $this->logApproval($leave->id, $user->id, 2, 'Approved by HR');
        } elseif ($user->hasRole('hod') && $leave->current_approval_level == 3) {
            $leave->update(['status' => 'approved', 'current_approval_level' => 4]);
            $this->logApproval($leave->id, $user->id, 3, 'Final Approval by HOD');
        } else {
            return back()->with('error', 'You do not have permission for this stage.');
        }

        return redirect()->route('hr.leave-approvals.index')->with('success', 'Leave status updated.');
    }

    /**
     * Reject leave request
     */
    public function reject(Request $request, $id)
    {
        $leave = LeaveRequests::findOrFail($id);
        $user = auth()->user();

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This request is already processed.');
        }

        $leave->update(['status' => 'rejected']);
        $this->logApproval($leave->id, $user->id, $leave->current_approval_level, 'Rejected: '.$request->remarks);

        return redirect()->route('hr.leave-approvals.index')->with('success', 'Leave request rejected.');
    }

    /*
    |--------------------------------------------------------------------------
    | API FUNCTIONS (JSON for React Native)
    |--------------------------------------------------------------------------
    */

    public function apiIndex(Request $request)
    {
        $user = auth()->user();
        $query = LeaveRequests::query()->with(['staff', 'leaveType']);

        if ($user->hasRole('manager')) {
            $query->where('current_approval_level', 1)
                ->whereHas('staff', function ($q) use ($user) {
                    $q->where('level1_supervisor_id', $user->staff->id);
                });
        } elseif ($user->hasRole('hr')) {
            $query->where('current_approval_level', 2);
        } elseif ($user->hasRole('hod')) {
            $query->where('current_approval_level', 3);
        }

        $status = $request->status ?? 'pending';
        $query->where('status', $status);

        if ($request->search) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('employee_id', $request->search);
            });
        }

        $leaves = $query->latest()->simplePaginate(10);

        return response()->json(['success' => true, 'data' => $leaves]);
    }

    public function apiApprove(Request $request, $id)
    {
        $leave = LeaveRequests::findOrFail($id);
        $user = auth()->user();

        if ($leave->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Already processed.'], 400);
        }

        if ($user->hasRole('manager') && $leave->current_approval_level == 1) {
            $leave->update(['current_approval_level' => 2]);
            $this->logApproval($leave->id, $user->id, 1, 'Approved via Mobile (Manager)');

            return response()->json(['success' => true, 'message' => 'Manager approved. Sent to HR.']);
        }

        if ($user->hasRole('hr') && $leave->current_approval_level == 2) {
            $leave->update(['current_approval_level' => 3]);
            $this->logApproval($leave->id, $user->id, 2, 'Approved via Mobile (HR)');

            return response()->json(['success' => true, 'message' => 'HR approved. Sent to HOD.']);
        }

        if ($user->hasRole('hod') && $leave->current_approval_level == 3) {
            $leave->update(['status' => 'approved', 'current_approval_level' => 4]);
            $this->logApproval($leave->id, $user->id, 3, 'Final Mobile Approval (HOD)');

            return response()->json(['success' => true, 'message' => 'HOD approved. Finalized.']);
        }

        return response()->json(['success' => false, 'message' => 'Unauthorized stage access.'], 403);
    }

    /**
     * Private helper to log the approval history
     */
    private function logApproval($leaveId, $userId, $level, $remarks)
    {
        LeaveApprovals::create([
            'leave_request_id' => $leaveId,
            'user_id' => $userId,
            'level' => $level,
            'status' => 'approved',
            'remarks' => $remarks,
        ]);
    }
}

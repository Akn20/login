<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaveAdjustment;
use App\Models\LeaveApplication;
use App\Models\LeaveRequestApprovals;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Log;

class LeaveApprovalController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = LeaveApplication::query()->with(['staff', 'leaveType']);
        $query = $this->applyHierarchyFilter($query, $user);

        if ($request->search) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('staff_id', 'like', "%{$request->search}%")
                    ->orWhere('name', 'like', "%{$request->search}%");
            });
        }

        $status = $request->status ?? 'pending';
        $leaveRequests = $query->where('status', $status)->latest()->paginate(10);
        Log::info($leaveRequests);
        return view('admin.Leave_Management.leave_request_approval.index', compact('leaveRequests'));
    }

    public function show($id)
    {
        $leave = LeaveApplication::with(['staff', 'leaveType', 'approvals.user'])->findOrFail($id);

        // Pass sorted approvals separately to avoid the "readonly" error
        $approvals = $leave->approvals->sortBy('level');

        return view('admin.Leave_Management.leave_request_approval.show', compact('leave', 'approvals'));
    }

    public function approve(Request $request, $id)
    {
        $leave = LeaveApplication::with(['staff', 'leaveType'])->findOrFail($id);
        $user = auth()->user();
        $staff = $leave->staff;
        $action = $request->action; // 'approve' or 'reject'
        $remarks = $request->remarks ?? 'No remarks provided.';

        if ($leave->status !== 'pending') {
            return $this->errorResponse($request, 'Request already processed.');
        }

        // --- HANDLE REJECTION ---
        if ($action === 'reject') {
            $leave->update(['status' => 'rejected', 'current_approval_level' => 4]);
            $this->logApproval($id, $user->id, $leave->current_approval_level, $remarks, 'rejected');

            return $this->successResponse($request, 'Leave request rejected.');
        }

        // --- AUTO-APPROVE if approval not required ---
        if (!$leave->leaveType->approval_required) {
            $this->logApproval($leave->id, $user->id, 1, $remarks);
            $leave->update(['status' => 'approved', 'current_approval_level' => 4]);
            LeaveAdjustment::where('staff_id', $staff->id)
                ->where('leave_type_id', $leave->leaveType->id)
                ->increment('debit', $leave->leave_days);
            return $this->successResponse($request, 'Leave approved (no approval required).');
        }

        // --- SINGLE LEVEL APPROVAL ---
        if ($leave->leaveType->approval_level === 'Single') {
            $this->logApproval($leave->id, $user->id, 1, $remarks);
            $leave->update(['status' => 'approved', 'current_approval_level' => 4]);
            LeaveAdjustment::where('staff_id', $staff->id)
                ->where('leave_type_id', $leave->leaveType->id)
                ->increment('debit', $leave->leave_days);
            return $this->successResponse($request, 'Leave approved (Single level).');
        }

        // --- HANDLE SEQUENTIAL (MULTI) APPROVAL ---
        $level = (int) $leave->current_approval_level;

        if ($user->hasRole('manager') && $level == 1) {
            $this->logApproval($id, $user->id, 1, $remarks);
            $this->moveToNextLevel($leave, $staff);
        } elseif ($user->hasRole('hr') && $level == 2) {
            $this->logApproval($id, $user->id, 2, $remarks);
            $this->moveToNextLevel($leave, $staff);
        } elseif ($user->hasRole('hod') && $level == 3) {
            $this->logApproval($id, $user->id, 3, $remarks);
            $leave->update(['status' => 'approved', 'current_approval_level' => 4]);
            LeaveAdjustment::where('staff_id', $staff->id)
                ->where('leave_type_id', $leave->leaveType->id)
                ->increment('debit', $leave->leave_days);
        } else {
            return $this->errorResponse($request, 'Unauthorized for this stage.');
        }
        return $this->successResponse($request, 'Leave status updated.');
    }

    /**
     * Helper: Logic to determine if we go to Level 2, Level 3, or Final Approval
     */
    private function moveToNextLevel($leave, $staff)
    {
        if ($leave->current_approval_level == 1 && $staff->level2_supervisor_id) {
            $leave->update(['current_approval_level' => 2]);
        } elseif ($staff->level3_supervisor_id) {
            $leave->update(['current_approval_level' => 3]);
        } else {
            $leave->update(['status' => 'approved', 'current_approval_level' => 4]);
        }
    }

    private function applyHierarchyFilter($query, $user)
    {
        $userId = $user->id;

        if ($user->hasRole('manager')) {
            return $query->where('current_approval_level', 1)
                ->whereHas('staff', fn ($q) => $q->where('level1_supervisor_id', $userId));
        }

        if ($user->hasRole('hr')) {
            return $query->where('current_approval_level', 2)
                ->whereHas('staff', fn ($q) => $q->where('level2_supervisor_id', $userId));
        }

        if ($user->hasRole('hod')) {
            return $query->where('current_approval_level', 3)
                ->whereHas('staff', fn ($q) => $q->where('level3_supervisor_id', $userId));
        }

        return $query->whereRaw('1 = 0');
    }

    private function logApproval($leaveId, $userId, $level, $remarks, $status = 'approved')
    {
        LeaveRequestApprovals::create([
            'leave_request_id' => $leaveId,
            'approver_id' => $userId,
            'level' => $level,
            'status' => $status,
            'remarks' => $remarks,
        ]);
    }

    private function successResponse($request, $msg)
    {
        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => $msg])
            : redirect()->route('hr.leave-approvals.index')->with('success', $msg);
    }

    private function errorResponse($request, $msg)
    {
        return $request->expectsJson()
            ? response()->json(['success' => false, 'message' => $msg], 403)
            : back()->with('error', $msg);
    }

    public function approvedIndex(Request $request)
    {
        try
            {
            $user = auth()->user();
            $userId = $user->id;
            
            // Catch the status from the filter, default to 'approved'
            $status = $request->status ?? 'approved';
            
            $query = LeaveApplication::query()
            ->with(['staff', 'leaveType','approvals'])
            ->where('status', $status); // Uses the dynamic status (approved or rejected)
            
            $query->whereHas('staff', function ($q) use ($userId) {
                $q->where('level1_supervisor_id', $userId)
                ->orWhere('level2_supervisor_id', $userId)
                ->orWhere('level3_supervisor_id', $userId);
            });
            // Log::info($query );
            
            if ($request->search) {
                $query->whereHas('staff', function ($q) use ($request) {
                    $q->where('employee_id', 'like', "%{$request->search}%")
                        ->orWhere('name', 'like', "%{$request->search}%");
                });
            }

            $approvedLeaves = $query->latest()->paginate(10);
            return view('admin.Leave_Management.leave_request_approval.approved', compact('approvedLeaves'));
        } 
        catch (ModelNotFoundException $e) 
        {
            return back()->with('error', $e->getMessage());
        }
    }

    public function apiIndex(Request $request)
    {
        $user = auth()->user();
        $query = LeaveApplication::query()->with(['staff', 'leaveType']);
        $query = $this->applyHierarchyFilter($query, $user);

        if ($request->search) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('staff_id', 'like', "%{$request->search}%")
                    ->orWhere('name', 'like', "%{$request->search}%");
            });
        }

        $status = $request->status ?? 'pending';
        $leaveRequests = $query->where('status', $status)->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $leaveRequests
        ]);
    }

    public function apiShow($id)
    {
        $leave = LeaveApplication::with(['staff', 'leaveType', 'approvals.user'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $leave
        ]);
    }

    public function apiApprove(Request $request, $id)
    {
        // Reuse existing logic by passing JSON expectation
        $request->merge(['action' => 'approve']);
        return $this->approve($request, $id);
    }

    public function apiReject(Request $request, $id)
    {
        // Reuse existing logic by passing JSON expectation
        $request->merge(['action' => 'reject']);
        return $this->approve($request, $id);
    }

    public function apiApprovedIndex(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;

        $status = $request->status ?? 'approved';

        $query = LeaveApplication::query()
            ->with(['staff', 'leaveType', 'approvals'])
            ->where('status', $status);

        $query->whereHas('staff', function ($q) use ($userId) {
            $q->where('level1_supervisor_id', $userId)
                ->orWhere('level2_supervisor_id', $userId)
                ->orWhere('level3_supervisor_id', $userId);
        });

        if ($request->search) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('employee_id', 'like', "%{$request->search}%")
                    ->orWhere('name', 'like', "%{$request->search}%");
            });
        }

        $leaves = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $leaves
        ]);
    }
}

<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequests;
use Illuminate\Http\Request;

class LeaveApprovalController extends Controller
{
    /**
     * Display leave requests
     */
    public function index(Request $request)
    {
        $query = LeaveRequests::query()->with(['staff', 'leaveType']);
        // search employee id
        if ($request->search) {
            $query->where('employee_id', $request->search);
        }

        // filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->latest()->paginate(10);

        return view('admin.Leave_Management.leave_request_approval.index', compact('leaveRequests'));
    }

    /**
     * Show leave request details
     */
    public function show($id)
    {
        $leave = LeaveRequests::with(['staff', 'leaveType'])->findOrFail($id);

        return view('admin.Leave_Management.leave_request_approval.show', compact('leave'));
    }

    /**
     * Approve leave request
     */
    public function approve(Request $request, $id)
    {
        $leave = LeaveRequests::findOrFail($id);
        $user = auth()->user();

        if ($user->hasRole('manager')) {
            $leave->update([
                'current_approval_level' => $leave->current_approval_level + 1,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Approved by Manager. Forwarded to HR for final approval.',
            ]);
        }

        if ($user->hasRole('hr')) {
            $leave->update([
                'current_approval_level' => $leave->current_approval_level + 1,
            ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Approved by HR. Forwarded to HOD for final approval.',
                ]);
        }

        if ($user->hasRole('hod')) {
            $leave->update([
                'current_approval_level' => $leave->current_approval_level + 1,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Approved by HOD. Final Approval Done.',
            ]);
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This request is already processed.');
        }

        $leave->update([
            'status' => 'approved',
            'current_approval_level' => $leave->current_approval_level + 1,
        ]);

        return redirect()
            ->route('hr.leave-approvals.index')
            ->with('success', 'Leave request approved successfully.');
    }

    /**
     * Reject leave request
     */
    public function reject(Request $request, $id)
    {
        $leave = LeaveRequests::findOrFail($id);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This request is already processed.');
        }

        $leave->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('hr.leave-approvals.index')
            ->with('success', 'Leave request rejected.');
    }

    /*
     *  API Endpoints
     */

    public function apiIndex(Request $request)
    {
        $query = LeaveRequests::query()->with(['staff', 'leaveType']);

        // Default to pending for the approval screen
        $status = $request->status ?? 'pending';
        $query->where('status', $status);

        if ($request->search) {
            $query->whereHas('staff', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('employee_id', $request->search);
            });
        }

        $leaves = $query->latest()->simplePaginate(10);

        return response()->json([
            'success' => true,
            'data' => $leaves,
        ]);
    }

    public function apiShow($id)
    {
        $leave = LeaveRequests::with(['staff', 'leaveType'])->findOrFail($id);

        if (!$leave) {
            return response()->json([
                'success' => false,
                'message' => 'Leave request not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $leave,
        ]);
    }

    public function apiApprove(Request $request, $id)
    {
        $leave = LeaveRequests::findOrFail($id);

        if (!$leave || $leave->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Leave request not found or already processed.',
            ], 404);
        }

        $leave->update([
            'status' => 'approved',
            'current_approval_level' => $leave->current_approval_level + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Leave request approved successfully.',
        ]);
    }

    public function apiReject(Request $request, $id)
    {
        $leave = LeaveRequests::findOrFail($id);

        if (!$leave || $leave->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Leave request not found or already processed.',
            ], 404);
        }

        $leave->update([
            'status' => 'rejected',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Leave request rejected.',
        ]);
    }
}
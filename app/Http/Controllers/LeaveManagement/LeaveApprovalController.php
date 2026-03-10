<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequests;
use Log;

class LeaveApprovalController extends Controller
{

    /**
     * Display leave requests
     */
    public function index(Request $request)
    {
        $query = LeaveRequests::query()->with(['staff','leaveType']);

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
        $leave = LeaveRequests::with(['staff','leaveType'])->findOrFail($id);
      
        return view('admin.Leave_Management.leave_request_approval.show', compact('leave'));
    }


    /**
     * Approve leave request
     */
    public function approve(Request $request, $id)
    {
        $leave = LeaveRequests::findOrFail($id);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This request is already processed.');
        }

        $leave->update([
            'status' => 'approved',
            'current_approval_level' => $leave->current_approval_level + 1
        ]);

        return redirect()
            ->route('admin.leave_approvals.index')
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
            'status' => 'rejected'
        ]);

        return redirect()
            ->route('admin.leave_approvals.index')
            ->with('success', 'Leave request rejected.');
    }

}
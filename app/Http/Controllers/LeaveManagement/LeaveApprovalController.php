<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\Leave_Request_Approval;
use App\Models\LeaveAdjustment;
use DB;
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
        $query = LeaveRequests::query()->with(['staff', 'leaveType']);

        // search employee id
        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('staff', function ($q) use ($search) {

                $q->where('employee_id', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');

            });
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
        
        $leave = LeaveRequests::with(['staff', 'leaveType', 'approvals'])->findOrFail($id);
        Log::info('Leave ID: '.$leave->id);

$approvals = Leave_Request_Approval::where('leave_request_id', $leave->id)->get();

Log::info($approvals->toArray());
        Log::info($leave);
        $leave->approvals = $leave->approvals->sortBy('level');
        return view('admin.Leave_Management.leave_request_approval.show', compact('leave'));
    }


    /**
     * Approve leave request
     */
    public function approve(Request $request, $id)
    {
        //Approval Code
        if ($request->action == 'approve') {
            $leave = LeaveRequests::with('staff', 'leaveType')->findOrFail($id);

            if ($leave->status !== 'pending') {
                return back()->with('error', 'Leave already processed');
            }

            $userId = auth()->id();
            $staff = $leave->staff;

            if ($leave->current_approval_level == 1 && $staff->level1_supervisor_id != $userId) {
                return back()->with('error', 'You are not authorized for Level 1 approval');
            }

            if ($leave->current_approval_level == 2 && $staff->level2_supervisor_id != $userId) {
                return back()->with('error', 'You are not authorized for Level 2 approval');
            }

            if ($leave->current_approval_level == 3 && $staff->level3_supervisor_id != $userId) {
                return back()->with('error', 'You are not authorized for Level 3 approval');
            }


            $alreadyApproved = Leave_Request_Approval::where('leave_request_id', $leave->id)
                ->where('approver_id', $userId)
                ->exists();

            if ($alreadyApproved) {
                return back()->with('error', 'You already approved this request');
            }


            DB::transaction(function () use ($leave, $request, $userId) {

                Leave_Request_Approval::create([
                    'leave_request_id' => $leave->id,
                    'approver_id' => $userId,
                    'level' => $leave->current_approval_level,
                    'status' => 'approved',
                    'remarks' => $request->remarks
                ]);

                //Single Approval Leave

                if ($leave->leaveType->approval_level == 'Single') {

                    $leave->update([
                        'status' => 'approved'
                    ]);

                    LeaveAdjustment::where('staff_id', $leave->employee_id)
                        ->increment('debit', $leave->total_leave_days);

                    return;
                }


                //Multi Level Approval

                $nextLevel = $leave->current_approval_level + 1;

                if ($nextLevel > 3) {

                    $leave->update([
                        'status' => 'approved'
                    ]);

                    LeaveAdjustment::where('staff_id', $leave->employee_id)
                        ->increment('debit', $leave->total_leave_days);

                } else {

                    $leave->update([
                        'current_approval_level' => $nextLevel
                    ]);

                }

            });
            return back()->with('success', 'Approval recorded');

            //Reject Code
        } else if ($request->action == 'reject') {
            $leave = LeaveRequests::findOrFail($id);

            DB::transaction(function () use ($leave, $request) {

                Leave_Request_Approval::create([
                    'leave_request_id' => $leave->id,
                    'approver_id' => auth()->id(),
                    'level' => $leave->current_approval_level,
                    'status' => 'rejected',
                    'remarks' => $request->remarks
                ]);

                $leave->update([
                    'status' => 'rejected'
                ]);
            });

            return back()->with('success', 'Leave rejected');
        }
    }

}
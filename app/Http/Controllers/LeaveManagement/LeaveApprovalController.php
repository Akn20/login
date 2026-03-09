<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveApprovalController extends Controller
{

public function index()
{
$data = [
            [
                'id' => 1,
                'employee' => 'John Doe',
                'leave_type' => 'Casual Leave',
                'from_date' => '2026-03-12',
                'to_date' => '2026-03-13',
                'total_days' => 2,
                'status' => 'pending',
                'created_at' => '2026-03-09',
            ],
            [
                'id' => 2,
                'employee' => 'Jane Smith',
                'leave_type' => 'Sick Leave',
                'from_date' => '2026-03-15',
                'to_date' => '2026-03-15',
                'total_days' => 1,
                'status' => 'approved',
                'created_at' => '2026-03-08',
            ],
            [
                'id' => 3,
                'employee' => 'Michael Brown',
                'leave_type' => 'Privilege Leave',
                'from_date' => '2026-03-20',
                'to_date' => '2026-03-22',
                'total_days' => 3,
                'status' => 'rejected',
                'created_at' => '2026-03-07',
            ],
        ];

        $leaveRequests = collect($data);


return view('admin.Leave_Management.leave_request_approval.index', compact('leaveRequests'));
}


public function show($id)
{
$leave = LeaveRequest::findOrFail($id);

return view('admin.leave-approvals.show',compact('leave'));
}


public function approve($id)
{
$leave = LeaveRequest::findOrFail($id);

$leave->update([
'status' => 'approved'
]);

return back()->with('success','Leave approved');
}


public function reject($id)
{
$leave = LeaveRequest::findOrFail($id);

$leave->update([
'status' => 'rejected'
]);

return back()->with('success','Leave rejected');
}

}

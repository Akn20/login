<?php

namespace App\Http\Controllers\HR\Reports;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use App\Models\Department;
use App\Models\LeaveType;
use App\Models\LeaveAdjustment;
use Illuminate\Http\Request;
use App\Exports\LeaveReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LeaveReportController extends Controller
{
    public function index(Request $request)
{
    $query = LeaveApplication::with(['staff.department', 'leaveType', 'approvals.approver']);

    // 🔍 APPLY FILTERS FIRST
    if ($request->employee) {
        $query->whereHas('staff', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->employee . '%');
        });
    }

    if ($request->department_id) {
        $query->whereHas('staff', function ($q) use ($request) {
            $q->where('department_id', $request->department_id);
        });
    }

    if ($request->leave_type_id) {
        $query->where('leave_type_id', $request->leave_type_id);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->from_date && $request->to_date) {
        $query->whereBetween('from_date', [$request->from_date, $request->to_date]);
    }

    // ✅ EXPORT AFTER FILTERS
    if ($request->export) {

        $data = $query->get();

        foreach ($data as $leave) {
            $credit = LeaveAdjustment::where('staff_id', $leave->staff_id)
                ->where('leave_type_id', $leave->leave_type_id)
                ->sum('credit');

            $debit = LeaveAdjustment::where('staff_id', $leave->staff_id)
                ->where('leave_type_id', $leave->leave_type_id)
                ->sum('debit');

            $leave->remaining_balance = $credit - $debit;
        }

        if ($request->export == 'excel') {
            return Excel::download(new LeaveReportExport($data), 'leave-report.xlsx');
        }

        if ($request->export == 'pdf') {
            $pdf = Pdf::loadView('admin.hr.reports.leave-pdf', compact('data'));
            return $pdf->download('leave-report.pdf');
        }
    }

    // 📄 NORMAL VIEW
    $leaves = $query->latest()->paginate(10);

    foreach ($leaves as $leave) {
        $credit = LeaveAdjustment::where('staff_id', $leave->staff_id)
            ->where('leave_type_id', $leave->leave_type_id)
            ->sum('credit');

        $debit = LeaveAdjustment::where('staff_id', $leave->staff_id)
            ->where('leave_type_id', $leave->leave_type_id)
            ->sum('debit');

        $leave->remaining_balance = $credit - $debit;
    }

    $departments = Department::all();
    $leaveTypes = LeaveType::all();

    return view('admin.hr.reports.leave', compact(
        'leaves',
        'departments',
        'leaveTypes'
    ));
}
}
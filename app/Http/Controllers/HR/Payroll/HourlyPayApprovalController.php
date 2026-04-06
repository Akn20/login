<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HourlyPayApproval;
use App\Models\Staff;
use App\Models\HourlyPay;

class HourlyPayApprovalController extends Controller
{

/* ================= INDEX ================= */

public function index(Request $request)
{
    $query = HourlyPayApproval::with('staff');

    // SEARCH FILTER
    if ($request->search) {

        $query->whereHas('staff', function ($q) use ($request) {

            $q->where('name', 'like', '%' . $request->search . '%');

        });

    }

    $entries = $query
                ->latest()
                ->paginate(10);

    return view(
        'hr.payroll.hourly_pay_approval.index',
        compact('entries')
    );
}



/* ================= CREATE ================= */

public function create()
{
    $staffs = Staff::orderBy('name')->get();

    $workTypes = HourlyPay::orderBy('name')->get();

    $approvers = Staff::orderBy('name')->get();

    return view(
        'hr.payroll.hourly_pay_approval.create',
        compact(
            'staffs',
            'workTypes',
            'approvers'
        )
    );
}



/* ================= STORE ================= */

public function store(Request $request)
{

    $request->validate([

        'staff_id' => 'required',

        'work_type_code' => 'required',

        'payroll_month' => 'required',

        'attendance_date' => 'required|date',

        'approved_hours' => 'required|numeric|min:0',

        'source_type' => 'required',

    ]);


    /* Approved Validation */

    if ($request->approval_status == 'Approved') {

        $request->validate([

            'approved_by' => 'required',

            'approved_date' => 'required|date',

        ]);

    }


    /* Prepare Data */

    $data = [

        'staff_id' => $request->staff_id,

        'work_type_code' => $request->work_type_code,

        'payroll_month' => $request->payroll_month,

        'attendance_date' => $request->attendance_date,

        'approved_hours' => $request->approved_hours,

        'shift_code' => $request->shift_code,

        'day_type' => $request->day_type ?? 'Working',

        'source_type' => $request->source_type,

        'approval_status' => $request->approval_status ?? 'Pending',

        'approved_by' => $request->approved_by,

        'approved_date' => $request->approved_date,

        'locked_for_payroll' => $request->locked_for_payroll ?? 0,

    ];


    /* Rejected Logic */

    if ($request->approval_status == 'Rejected') {

        $data['approved_by'] = null;

        $data['approved_date'] = null;

    }


    HourlyPayApproval::create($data);


    return redirect()
        ->route('hr.payroll.hourly-pay-approval.index')
        ->with(
            'success',
            'Hourly Pay Approval saved successfully.'
        );

}



/* ================= EDIT ================= */

public function edit($id)
{

    $entry = HourlyPayApproval::findOrFail($id);

    /* Prevent editing locked */

    if ($entry->locked_for_payroll == 1) {

        return redirect()
            ->route('hr.payroll.hourly-pay-approval.index')
            ->with(
                'error',
                'Locked records cannot be edited.'
            );

    }


    $staffs = Staff::orderBy('name')->get();

    $workTypes = HourlyPay::orderBy('name')->get();

    $approvers = Staff::orderBy('name')->get();


    return view(
        'hr.payroll.hourly_pay_approval.create',
        compact(
            'entry',
            'staffs',
            'workTypes',
            'approvers'
        )
    );

}



/* ================= UPDATE ================= */

public function update(Request $request, $id)
{

    $entry = HourlyPayApproval::findOrFail($id);


    /* Prevent update if locked */

    if ($entry->locked_for_payroll == 1) {

        return redirect()
            ->route('hr.payroll.hourly-pay-approval.index')
            ->with(
                'error',
                'Locked records cannot be updated.'
            );

    }


    /* Base Validation */

    $request->validate([

        'staff_id' => 'required',

        'work_type_code' => 'required',

        'payroll_month' => 'required',

        'attendance_date' => 'required|date',

        'approved_hours' => 'required|numeric|min:0',

        'source_type' => 'required',

    ]);


    /* Approved Validation */

    if ($request->approval_status == 'Approved') {

        $request->validate([

            'approved_by' => 'required',

            'approved_date' => 'required|date',

        ]);

    }


    /* Prepare Data */

    $data = [

        'staff_id' => $request->staff_id,

        'work_type_code' => $request->work_type_code,

        'payroll_month' => $request->payroll_month,

        'attendance_date' => $request->attendance_date,

        'approved_hours' => $request->approved_hours,

        'shift_code' => $request->shift_code,

        'day_type' => $request->day_type,

        'source_type' => $request->source_type,

        'approval_status' => $request->approval_status,

        'approved_by' => $request->approved_by,

        'approved_date' => $request->approved_date,

        'locked_for_payroll' => $request->locked_for_payroll ?? 0,

    ];


    /* Rejected Logic */

    if ($request->approval_status == 'Rejected') {

        $data['approved_by'] = null;

        $data['approved_date'] = null;

    }


    $entry->update($data);


    return redirect()
        ->route('hr.payroll.hourly-pay-approval.index')
        ->with(
            'success',
            'Entry updated successfully.'
        );

}

/* ================= DELETE ================= */

public function destroy($id)
{
    $entry = HourlyPayApproval::findOrFail($id);

    /* Prevent delete if locked */

    if ($entry->locked_for_payroll == 1) {

        return redirect()
            ->route('hr.payroll.hourly-pay-approval.index')
            ->with(
                'error',
                'Locked records cannot be deleted.'
            );

    }

    /* Soft Delete */

    $entry->delete();

    return redirect()
        ->route('hr.payroll.hourly-pay-approval.index')
        ->with(
            'success',
            'Entry moved to trash successfully.'
        );
}

/* ================= TRASH ================= */

public function trash()
{
    $entries = HourlyPayApproval::onlyTrashed()
        ->with('staff')
        ->latest()
        ->paginate(10);

    return view(
        'hr.payroll.hourly_pay_approval.trash',
        compact('entries')
    );
}



/* ================= RESTORE ================= */

public function restore($id)
{
    $entry = HourlyPayApproval::onlyTrashed()
        ->findOrFail($id);

    $entry->restore();

    return redirect()
        ->route('hr.payroll.hourly-pay-approval.trash')
        ->with(
            'success',
            'Entry restored successfully.'
        );
}

/* ================= PERMANENT DELETE ================= */
public function forceDelete($id)
{
    $entry = HourlyPayApproval::onlyTrashed()
                ->findOrFail($id);

    $entry->forceDelete();

    return redirect()
        ->route('hr.payroll.hourly-pay-approval.trash')
        ->with(
            'success',
            'Entry permanently deleted.'
        );
}
}
<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HourlyPayApproval;
use App\Models\Staff;
use App\Models\HourlyPay;
use App\Models\Shift; // ✅ ADDED

class HourlyPayApprovalController extends Controller
{

/* ================= INDEX ================= */

public function index(Request $request)
{
    
$query = HourlyPayApproval::with('staff'); // ✅ KEEP THIS (WORKING)

    if ($request->search) {
        $query->whereHas('staff', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    $entries = $query
                ->latest()
                ->paginate(10);

    // JSON RESPONSE
    if ($request->wantsJson()) {
        return response()->json([
            'status' => 200,
            'message' => 'Records retrieved successfully.',
            'data' => $entries
        ]);
    }

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

    $shifts = Shift::where('status',1)
                    ->orderBy('shift_name')
                    ->get(); // ✅ ADDED

    return view(
        'hr.payroll.hourly_pay_approval.create',
        compact(
            'staffs',
            'workTypes',
            'approvers',
            'shifts' // ✅ ADDED
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


    if ($request->approval_status == 'Approved') {

        $request->validate([

            'approved_by' => 'required',

            'approved_date' => 'required|date',

        ]);

    }


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


    if ($request->approval_status == 'Rejected') {

        $data['approved_by'] = null;

        $data['approved_date'] = null;

    }


    $entry = HourlyPayApproval::create($data);

    // JSON RESPONSE
    if ($request->wantsJson()) {
        return response()->json([
            'status' => 201,
            'message' => 'Hourly Pay Approval created successfully.',
            'data' => $entry
        ], 201);
    }

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

    if ($entry->locked_for_payroll == 1) {

        // JSON RESPONSE
        if (request()->wantsJson()) {
            return response()->json([
                'status' => 403,
                'message' => 'Locked records cannot be edited.',
                'data' => null
            ], 403);
        }

        return redirect()
            ->route('hr.payroll.hourly-pay-approval.index')
            ->with(
                'error',
                'Locked records cannot be edited.'
            );
            return redirect()
    ->route('hr.payroll.hourly-pay-approval.index')
    ->with('error', 'Locked records cannot be edited.');

    }


    $staffs = Staff::orderBy('name')->get();

    $workTypes = HourlyPay::orderBy('name')->get();

    $approvers = Staff::orderBy('name')->get();

    $shifts = Shift::where('status',1)
                    ->orderBy('shift_name')
                    ->get(); // ✅ ADDED

    // JSON RESPONSE
    if (request()->wantsJson()) {
        return response()->json([
            'status' => 200,
            'message' => 'Record retrieved successfully.',
            'data' => [
                'entry' => $entry,
                'staffs' => $staffs,
                'workTypes' => $workTypes,
                'approvers' => $approvers,
                'shifts' => $shifts
            ]
        ]);
    }

    return view(
        'hr.payroll.hourly_pay_approval.create',
        compact(
            'entry',
            'staffs',
            'workTypes',
            'approvers',
            'shifts' // ✅ ADDED
        )
    );

}


/* ================= UPDATE ================= */

public function update(Request $request, $id)
{

    $entry = HourlyPayApproval::findOrFail($id);

    if ($entry->locked_for_payroll == 1) {

        // JSON RESPONSE
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 403,
                'message' => 'Locked records cannot be updated.',
                'data' => null
            ], 403);
        }

        return redirect()
            ->route('hr.payroll.hourly-pay-approval.index')
            ->with(
                'error',
                'Locked records cannot be updated.'
            );

    }


    $request->validate([

        'staff_id' => 'required',

        'work_type_code' => 'required',

        'payroll_month' => 'required',

        'attendance_date' => 'required|date',

        'approved_hours' => 'required|numeric|min:0',

        'source_type' => 'required',

    ]);


    if ($request->approval_status == 'Approved') {

        $request->validate([

            'approved_by' => 'required',

            'approved_date' => 'required|date',

        ]);

    }


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


    if ($request->approval_status == 'Rejected') {

        $data['approved_by'] = null;

        $data['approved_date'] = null;

    }


    $entry->update($data);

    // JSON RESPONSE
    if ($request->wantsJson()) {
        return response()->json([
            'status' => 200,
            'message' => 'Entry updated successfully.',
            'data' => $entry
        ]);
    }

    return redirect()
        ->route('hr.payroll.hourly-pay-approval.index')
        ->with(
            'success',
            'Entry updated successfully.'
        );

}
public function show($id)
{
    $data = HourlyPayApproval::with('staff')->find($id);

    if (!$data) {
        return response()->json([
            'success' => false,
            'message' => 'Record not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}


public function destroy($id)
{
    $entry = HourlyPayApproval::find($id);

    if (!$entry) {
        return response()->json([
            'status' => 404,
            'message' => 'Record not found',
            'data' => null
        ], 404);
    }

    // prevent delete if locked
    if ($entry->locked_for_payroll == 1) {
        return response()->json([
            'status' => 403,
            'message' => 'Locked records cannot be deleted',
            'data' => null
        ], 403);
    }

    $entry->delete();

    return response()->json([
        'status' => 200,
        'message' => 'Deleted successfully'
    ]);
}



public function forceDelete($id)
{
    $entry = HourlyPayApproval::withTrashed()->find($id);

    if (!$entry) {
        return response()->json([
            'status' => 404,
            'message' => 'Record not found'
        ], 404);
    }

    $entry->forceDelete(); // 🔥 PERMANENT DELETE

    return response()->json([
        'status' => 200,
        'message' => 'Permanently deleted'
    ]);
}


public function trash()
{
    $records = HourlyPayApproval::onlyTrashed()->get();

    // 👉 If API request (Postman / JSON)
    if (request()->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Trash records fetched',
            'data' => $records
        ]);
    }

    // 👉 If Browser (Web view)
   return view('hr.payroll.hourly_pay_approval.trash', [
        'entries' => $records
    ]);
}

public function restore($id)
{
    $entry = HourlyPayApproval::onlyTrashed()->find($id);

    if (!$entry) {
        return response()->json([
            'success' => false,
            'message' => 'Record not found'
        ], 404);
    }

    $entry->restore();

    return response()->json([
        'success' => true,
        'message' => 'Record restored successfully'
    ]);
}

}


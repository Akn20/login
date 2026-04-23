<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrePayrollAdjustment;
use App\Models\Staff;
use App\Models\EmployeeSalaryAssignment; // IMPORTANT
use Illuminate\Support\Facades\Auth;

class PrePayrollAdjustmentController extends Controller
{
    //  INDEX
    public function index()
    {
        $records = PrePayrollAdjustment::with(['employee'])
            ->latest()
            ->paginate(10);

        return view('hr.payroll.pre_payroll_adjustment.index', compact('records'));
    }

    // CREATE
    public function create()
    {
        $employees = Staff::pluck('name', 'id');

        // IMPORTANT (for dropdown)
     $assignments = EmployeeSalaryAssignment::with('salaryStructure')->get();

        return view(
            'hr.payroll.pre_payroll_adjustment.create',
            compact('employees', 'assignments')
        );
    }

    //  STORE
   public function store(Request $request)
{
    $request->validate([
        'employee_id' => 'required',
        'salary_assignment_id' => 'required',
        'payroll_month' => 'required',
        'working_days' => 'required',
        'days_paid' => 'required|lte:working_days',
        'adhoc_earnings' => 'nullable|numeric|min:0',
        'adhoc_deductions' => 'nullable|numeric|min:0',
    ]);

    // CALCULATION
    $gross = ($request->fixed_earnings_total ?? 0)
           + ($request->adhoc_earnings ?? 0);

    $deductions = ($request->fixed_deductions_total ?? 0)
                + ($request->adhoc_deductions ?? 0);

    $net = $gross - $deductions;

    //  PREPARE DATA
    $data = $request->all();

// FIX NULL VALUES
$data['fixed_earnings_total'] = $request->fixed_earnings_total ?? 0;
$data['fixed_deductions_total'] = $request->fixed_deductions_total ?? 0;
$data['adhoc_earnings'] = $request->adhoc_earnings ?? 0;
$data['adhoc_deductions'] = $request->adhoc_deductions ?? 0;

    //HANDLE STATUS (based on button)
    if ($request->action == 'submit') {
        $data['status'] = 'Submitted';
        $data['submitted_by'] = Auth::id();
    } else {
        $data['status'] = 'Draft';
    }
}
//---------Api methods-----------------------------------------------------
public function apiIndex()
{
    $data = PrePayrollAdjustment::with('employee')->latest()->get();

    return response()->json([
        'status' => true,
        'message' => 'Pre Payroll list fetched',
        'data' => $data
    ]);
}
public function apiStore(Request $request)
{
    $validated = $request->validate([
        'employee_id' => 'required',
        'salary_assignment_id' => 'required',
        'payroll_month' => 'required',
        'working_days' => 'required|numeric',
        'days_paid' => 'required|lte:working_days',
        'status' => 'required',
    ]);

    $gross = ($request->fixed_earnings_total ?? 0)
           + ($request->adhoc_earnings ?? 0);

    $deductions = ($request->fixed_deductions_total ?? 0)
                + ($request->adhoc_deductions ?? 0);

    $net = $gross - $deductions;

    $record = PrePayrollAdjustment::create([
        ...$validated,
        'fixed_earnings_total' => $request->fixed_earnings_total,
        'adhoc_earnings' => $request->adhoc_earnings,
        'fixed_deductions_total' => $request->fixed_deductions_total,
        'adhoc_deductions' => $request->adhoc_deductions,
        'gross_earnings' => $gross,
        'total_deductions' => $deductions,
        'net_payable' => $net,
        'created_by' => Auth::id()
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Created successfully',
        'data' => $record
    ], 201);
}
public function apiShow($id)
{
    $record = PrePayrollAdjustment::with('employee')->find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Record not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $record
    ]);
}
public function apiUpdate(Request $request, $id)
{
    $record = PrePayrollAdjustment::find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Record not found'
        ], 404);
    }

    $validated = $request->validate([
        'employee_id' => 'required',
        'salary_assignment_id' => 'required',
        'payroll_month' => 'required',
        'working_days' => 'required|numeric',
        'days_paid' => 'required|lte:working_days',
        'status' => 'required',
    ]);

    $gross = ($request->fixed_earnings_total ?? 0)
           + ($request->adhoc_earnings ?? 0);

    $deductions = ($request->fixed_deductions_total ?? 0)
                + ($request->adhoc_deductions ?? 0);

    $net = $gross - $deductions;

    $record->update([
        ...$validated,
        'fixed_earnings_total' => $request->fixed_earnings_total,
        'adhoc_earnings' => $request->adhoc_earnings,
        'fixed_deductions_total' => $request->fixed_deductions_total,
        'adhoc_deductions' => $request->adhoc_deductions,
        'gross_earnings' => $gross,
        'total_deductions' => $deductions,
        'net_payable' => $net,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Updated successfully',
        'data' => $record
    ]);
}
public function apiDestroy($id)
{
    $record = PrePayrollAdjustment::find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Record not found'
        ], 404);
    }

    $record->delete();

    return response()->json([
        'status' => true,
        'message' => 'Deleted successfully'
    ]);
}
public function apiDeleted()
{
    $data = PrePayrollAdjustment::onlyTrashed()->get();

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}public function apiRestore($id)
{
    $record = PrePayrollAdjustment::onlyTrashed()->find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Record not found'
        ], 404);
    }

    $record->restore();

    return response()->json([
        'status' => true,
        'message' => 'Restored successfully'
    ]);
}
public function apiForceDelete($id)
{
    $record = PrePayrollAdjustment::onlyTrashed()->find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Record not found'
        ], 404);
    }

    $record->forceDelete();

    return response()->json([
        'status' => true,
        'message' => 'Permanently deleted'
    ]);


    // ADD CALCULATED VALUES
    $data['gross_earnings'] = $gross;
    $data['total_deductions'] = $deductions;
    $data['net_payable'] = $net;
    $data['created_by'] = Auth::id();

    //  SAVE
    PrePayrollAdjustment::create($data);

    return redirect()->route('hr.pre-payroll.index')
        ->with('success', 'Created Successfully');
}

public function edit($id)
{
    $record = PrePayrollAdjustment::findOrFail($id);

    $employees = Staff::pluck('name', 'id');
    $assignments = EmployeeSalaryAssignment::with('salaryStructure')->get();

    return view('hr.payroll.pre_payroll_adjustment.edit', compact(
        'record', 'employees', 'assignments'
    ));
}
public function update(Request $request, $id)
{
    $record = PrePayrollAdjustment::findOrFail($id);

    // 🚫 LOCK AFTER APPROVAL
    if ($record->status == 'Approved') {
        abort(403, 'Already Approved');
    }

    $request->validate([
        'employee_id' => 'required',
        'salary_assignment_id' => 'required',
        'payroll_month' => 'required',
        'working_days' => 'required',
        'days_paid' => 'required|lte:working_days',
        'adhoc_earnings' => 'nullable|numeric|min:0',
        'adhoc_deductions' => 'nullable|numeric|min:0',
    ]);

    // CALCULATIONS
    $gross = ($request->fixed_earnings_total ?? 0)
           + ($request->adhoc_earnings ?? 0);

    $deductions = ($request->fixed_deductions_total ?? 0)
                + ($request->adhoc_deductions ?? 0);

    $net = $gross - $deductions;

    $data = $request->all();

    // FIX NULL VALUES
    $data['fixed_earnings_total'] = $request->fixed_earnings_total ?? 0;
    $data['fixed_deductions_total'] = $request->fixed_deductions_total ?? 0;
    $data['adhoc_earnings'] = $request->adhoc_earnings ?? 0;
    $data['adhoc_deductions'] = $request->adhoc_deductions ?? 0;

    // 🔥 STATUS LOGIC (THIS WAS MISSING)
    if ($request->action == 'submit') {
        $data['status'] = 'Submitted';
        $data['submitted_by'] = Auth::id();
    } else {
        $data['status'] = 'Draft';
    }

    // ADD CALCULATED VALUES
    $data['gross_earnings'] = $gross;
    $data['total_deductions'] = $deductions;
    $data['net_payable'] = $net;

    $record->update($data);

    return redirect()->route('hr.pre-payroll.index')
        ->with('success', 'Updated Successfully');
}
public function approve($id)
{
    $record = PrePayrollAdjustment::findOrFail($id);

    $record->status = 'Approved';
    $record->approved_by = Auth::id();
    $record->approved_on = now();

    $record->save();

    return redirect()->route('hr.pre-payroll.index')
        ->with('success', 'Approved Successfully');

}
}
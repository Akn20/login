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
    public function index(Request $request)
{
   $query = PrePayrollAdjustment::with([
    'employee',
    'creator',
    'submitter',
    'approver'
]);

    if ($request->employee_id) {
        $query->where('employee_id', $request->employee_id);
    }

    if ($request->payroll_month) {
        $query->where('payroll_month', $request->payroll_month);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $records = $query->latest()->paginate(10);

    // Required for dropdown
    $employees = Staff::pluck('name', 'id');

    return view('hr.payroll.pre_payroll_adjustment.index', compact('records', 'employees'));
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

    $gross = ($request->fixed_earnings_total ?? 0)
           + ($request->adhoc_earnings ?? 0);

    $deductions = ($request->fixed_deductions_total ?? 0)
                + ($request->adhoc_deductions ?? 0);

    $net = $gross - $deductions;

    $data = $request->all();

    $data['fixed_earnings_total'] = $request->fixed_earnings_total ?? 0;
    $data['fixed_deductions_total'] = $request->fixed_deductions_total ?? 0;
    $data['adhoc_earnings'] = $request->adhoc_earnings ?? 0;
    $data['adhoc_deductions'] = $request->adhoc_deductions ?? 0;

    //  STATUS LOGIC
    if ($request->action == 'submit') {
        $data['status'] = 'Submitted';
        $data['submitted_by'] = Auth::id();
    } else {
        $data['status'] = 'Draft';
    }

    //  ADD CREATED BY
    $data['created_by'] = Auth::id();

    //  CALCULATED VALUES
    $data['gross_earnings'] = $gross;
    $data['total_deductions'] = $deductions;
    $data['net_payable'] = $net;

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

    //  LOCK AFTER APPROVAL
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

    //  STATUS LOGIC (THIS WAS MISSING)
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

    // 
    if (request()->expectsJson()) {
        return response()->json([
            'message' => 'Approved Successfully',
            'data' => $record
        ]);
    }

    return redirect()->route('hr.pre-payroll.index')
        ->with('success', 'Approved Successfully');
}


public function formData()
{
    return response()->json([
        'employees' => Staff::pluck('name', 'id'),

        'assignments' => EmployeeSalaryAssignment::with('salaryStructure')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->salaryStructure->salary_structure_name ?? 'No Name',
                ];
            }),
    ]);
}

//---------Api methods-----------------------------------------------------
public function apiIndex()
{
    $records = PrePayrollAdjustment::with('employee')->latest()->paginate(10);

    return response()->json([
        'data' => $records->map(function ($item) {
            return [
                'id' => $item->id,
                'employee_name' => optional($item->employee)->name,
                'payroll_month' => $item->payroll_month,
                'status' => $item->status,
            ];
        })
    ]);
}
public function apiShow($id)
{
    $record = PrePayrollAdjustment::findOrFail($id);
    return response()->json($record);
}
public function apiStore(Request $request)
{
    $record = PrePayrollAdjustment::create([

        // BASIC
        'employee_id' => $request->employee_id,
        'salary_assignment_id' => $request->salary_assignment_id,
        'payroll_month' => $request->payroll_month,
        'pay_type' => $request->pay_type,

        // ATTENDANCE
        'working_days' => $request->working_days,
        'days_paid' => $request->days_paid,
        'lop_days' => $request->lop_days,
        'ot_hours' => $request->ot_hours,

        // FIXED
        'fixed_earnings_total' => $request->fixed_earnings_total,
        'fixed_deductions_total' => $request->fixed_deductions_total,

        // STATUTORY
        'pf_employee' => $request->pf_employee,
        'esi_employee' => $request->esi_employee,
        'professional_tax' => $request->professional_tax,
        'tds_amount' => $request->tds_amount,

        // VARIABLE
        'adhoc_earnings' => $request->adhoc_earnings,
        'earnings_remarks' => $request->earnings_remarks,
        'adhoc_deductions' => $request->adhoc_deductions,
        'deduction_remarks' => $request->deduction_remarks,

        // CALCULATED
        'gross_earnings' =>
            ($request->fixed_earnings_total ?? 0) +
            ($request->adhoc_earnings ?? 0),

        'total_deductions' =>
            ($request->fixed_deductions_total ?? 0) +
            ($request->adhoc_deductions ?? 0),

        'net_payable' =>
            (
                ($request->fixed_earnings_total ?? 0) +
                ($request->adhoc_earnings ?? 0)
            ) -
            (
                ($request->fixed_deductions_total ?? 0) +
                ($request->adhoc_deductions ?? 0)
            ),

        // STATUS
        'status' => $request->status ?? 'Draft',
    ]);

    return response()->json([
        'message' => 'Created',
        'data' => $record
    ]);
}
public function apiUpdate(Request $request, $id)
{
    $record = PrePayrollAdjustment::findOrFail($id);

    $record->update($request->all());

    return response()->json([
        'message' => 'Updated',
        'data' => $record
    ]);
}
public function apiDelete($id)
{
    $record = PrePayrollAdjustment::findOrFail($id);
    $record->delete();

    return response()->json(['message' => 'Deleted successfully']);
}


}
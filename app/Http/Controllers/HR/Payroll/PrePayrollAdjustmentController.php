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
    $records = PrePayrollAdjustment::latest()->paginate(10);
    return response()->json($records);
}
public function apiShow($id)
{
    $record = PrePayrollAdjustment::findOrFail($id);
    return response()->json($record);
}

public function apiStore(Request $request)
{
    $validated = $request->validate([
        'employee_id' => 'required',
        'salary_assignment_id' => 'required',
        'payroll_month' => 'required',
        'pay_type' => 'required',
        'working_days' => 'required',
        'days_paid' => 'required',
        'status' => 'required',
    ]);

    $record = PrePayrollAdjustment::create([
        ...$validated,

        'lop_days' => $request->lop_days ?? 0,
        'ot_hours' => $request->ot_hours ?? 0,

        'fixed_earnings_total' => $request->fixed_earnings_total ?? 0,
        'fixed_deductions_total' => $request->fixed_deductions_total ?? 0,

        'pf_employee' => $request->pf_employee ?? 0,
        'esi_employee' => $request->esi_employee ?? 0,
        'professional_tax' => $request->professional_tax ?? 0,
        'tds_amount' => $request->tds_amount ?? 0,

        'adhoc_earnings' => $request->adhoc_earnings ?? 0,
        'earnings_remarks' => $request->earnings_remarks,

        'adhoc_deductions' => $request->adhoc_deductions ?? 0,
        'deduction_remarks' => $request->deduction_remarks,
    ]);

    return response()->json([
        'message' => 'Created successfully',
        'data' => $record
    ]);
}
public function apiUpdate(Request $request, $id)
{
    $record = PrePayrollAdjustment::findOrFail($id);

    $record->update([
        'employee_id' => $request->employee_id,
        'salary_assignment_id' => $request->salary_assignment_id,
        'payroll_month' => $request->payroll_month,
        'pay_type' => $request->pay_type,
        'working_days' => $request->working_days,
        'days_paid' => $request->days_paid,

        'lop_days' => $request->lop_days ?? 0,
        'ot_hours' => $request->ot_hours ?? 0,

        'fixed_earnings_total' => $request->fixed_earnings_total ?? 0,
        'fixed_deductions_total' => $request->fixed_deductions_total ?? 0,

        'pf_employee' => $request->pf_employee ?? 0,
        'esi_employee' => $request->esi_employee ?? 0,
        'professional_tax' => $request->professional_tax ?? 0,
        'tds_amount' => $request->tds_amount ?? 0,

        'adhoc_earnings' => $request->adhoc_earnings ?? 0,
        'earnings_remarks' => $request->earnings_remarks,

        'adhoc_deductions' => $request->adhoc_deductions ?? 0,
        'deduction_remarks' => $request->deduction_remarks,

        'status' => $request->status,
    ]);

    return response()->json([
        'message' => 'Updated successfully',
        'data' => $record
    ]);
}
public function apiDelete($id)
{
    $record = PrePayrollAdjustment::findOrFail($id);
    $record->delete();

    return response()->json(['message' => 'Deleted successfully']);
}
public function apiDeleted()
{
    $records = PrePayrollAdjustment::onlyTrashed()->get();
    return response()->json($records);
}
public function restore($id)
{
    $record = PrePayrollAdjustment::onlyTrashed()->findOrFail($id);
    $record->restore();

    return response()->json(['message' => 'Restored successfully']);
}
public function forceDelete($id)
{
    $record = PrePayrollAdjustment::onlyTrashed()->findOrFail($id);
    $record->forceDelete();

    return response()->json(['message' => 'Permanently deleted']);
}
}
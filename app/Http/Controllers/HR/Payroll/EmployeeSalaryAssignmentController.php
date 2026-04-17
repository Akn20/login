<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use App\Models\EmployeeSalaryAssignment;
use App\Models\SalaryStructure;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Allowance;
use App\Models\PayrollDeduction;
use App\Models\HourlyPay; 
use Illuminate\Support\Facades\Auth;

class EmployeeSalaryAssignmentController extends Controller
{
    // 🔹 INDEX
    public function index()
    {
        $records = EmployeeSalaryAssignment::with(['employee', 'salaryStructure'])
            ->latest()->paginate(10);
        
        return view('hr.payroll.employee_salary_assignment.index', compact('records'));
    }

    // 🔹 CREATE
    public function create()
    {
        $employees = Staff::pluck('name', 'id');
        $structures = SalaryStructure::pluck('salary_structure_name', 'id');
        
        $allowances = Allowance::all(); 
        $deductions = PayrollDeduction::all(); 
        $workTypes = HourlyPay::pluck('name', 'id');
        return view('hr.payroll.employee_salary_assignment.create', compact('employees', 'structures','allowances','deductions','workTypes'));
    }

    // 🔹 STORE
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'salary_structure_id' => 'required',

            'salary_basis' => 'required|in:Ctc,Gross',
            'salary_amount' => 'required|numeric',
            'pay_frequency' => 'required|in:Monthly,Weekly',
            'currency' => 'required',

            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
            'status' => 'required',

            'allowed_work_types' => 'required_if:hourly_pay_eligible,1',
        ]);

        // 🔥 Business Rule (TC15)
        $exists = EmployeeSalaryAssignment::where('employee_id', $request->employee_id)
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->exists();

        if ($exists && $request->status == 'Active') {
            return back()->withErrors('Active assignment already exists for this employee');
        }

        EmployeeSalaryAssignment::create([
            ...$request->all(),

            'allowed_work_types' => json_encode($request->allowed_work_types ?? []),
            'hourly_pay_eligible' => $request->hourly_pay_eligible ?? 0,
            'overtime_eligible' => $request->overtime_eligible ?? 0,

            'created_by' => Auth::id()
        ]);

        return redirect()->route('hr.payroll.employee-salary-assignment.index')
            ->with('success', 'Created Successfully');
    }

    // 🔹 SHOW
    public function show($id)
    {
        $record = EmployeeSalaryAssignment::with(['employee', 'salaryStructure'])
            ->findOrFail($id);

        return view('hr.payroll.employee_salary_assignment.show', compact('record'));
    }

    // 🔹 EDIT
    public function edit($id)
    {
        $record = EmployeeSalaryAssignment::findOrFail($id);
        $employees = Staff::pluck('name', 'id');
        $structures = SalaryStructure::pluck('salary_structure_name', 'id');
        $allowances = Allowance::all(); 
        $deductions = PayrollDeduction::all(); 
        $workTypes = HourlyPay::pluck('name', 'id'); 
        return view('hr.payroll.employee_salary_assignment.edit', compact('record', 'employees', 'structures','allowances','deductions','workTypes'));
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $record = EmployeeSalaryAssignment::findOrFail($id);

        $request->validate([
            'employee_id' => 'required',
            'salary_structure_id' => 'required',
            'salary_amount' => 'required|numeric',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $record->update([
            ...$request->all(),
            'allowed_work_types' => json_encode($request->allowed_work_types ?? []),
        ]);

        return redirect()->route('hr.payroll.employee-salary-assignment.index')
            ->with('success', 'Updated Successfully');
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        EmployeeSalaryAssignment::findOrFail($id)->delete();

        return back()->with('success', 'Deleted Successfully');
    }

    // 🔹 DELETED LIST
    public function deleted()
    {
        $records = EmployeeSalaryAssignment::onlyTrashed()->paginate(10);

        return view('hr.payroll.employee_salary_assignment.deleted', compact('records'));
    }

    // 🔹 RESTORE
    public function restore($id)
    {
        EmployeeSalaryAssignment::withTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Restored');
    }
}
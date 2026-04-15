<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use App\Models\SalaryStructure;
use Illuminate\Http\Request;

class SalaryStructureController extends Controller
{
    // 🔹 LIST
    public function index()
    {
        $records = SalaryStructure::latest()->paginate(10);
        return view('hr.payroll.salary_structure.index', compact('records'));
    }

    // 🔹 CREATE
public function create()
{
    $allowances = \App\Models\Allowance::where('status', 1)->get();
    $deductions = \App\Models\PayrollDeduction::where('status', 'ACTIVE')->get();

    return view('hr.payroll.salary_structure.create', compact('allowances', 'deductions'));
}
    // 🔹 STORE
    public function store(Request $request)
    {
        $request->validate([
            'salary_structure_code' => 'required|unique:salary_structures',
            'salary_structure_name' => 'required',
            'structure_category' => 'required',
            'status' => 'required',

            'fixed_allowance_components' => 'required|array',
            'residual_component_id' => 'required',
            'effective_from' => 'required|date',
'effective_to' => 'nullable|date|after_or_equal:effective_from',
            'allowed_work_types' => 'nullable|array',
            'fixed_deduction_components' => 'nullable|array',
            
        ]);
        if (!in_array($request->residual_component_id, $request->fixed_allowance_components)) {
    return back()->withErrors([
        'residual_component_id' => 'Residual must be one of the selected fixed components'
    ])->withInput();
}

        SalaryStructure::create([
            'salary_structure_code' => $request->salary_structure_code,
            'salary_structure_name' => $request->salary_structure_name,
            'structure_category' => $request->structure_category,
            'status' => $request->status,

            'fixed_allowance_components' => $request->fixed_allowance_components,
            'variable_allowance_allowed' => $request->variable_allowance_allowed ?? 0,
            'residual_component_id' => $request->residual_component_id,

            'hourly_pay_eligible' => $request->hourly_pay_eligible ?? 0,
            'overtime_eligible' => $request->overtime_eligible ?? 0,
            'allowed_work_types' => $request->allowed_work_types ?? [],

            'fixed_deduction_components' => $request->fixed_deduction_components ?? [],
            'variable_deduction_allowed' => $request->variable_deduction_allowed ?? 0,
'effective_from' => $request->effective_from,
'effective_to' => $request->effective_to,
            'pf_applicable' => $request->pf_applicable ?? 0,
            'esi_applicable' => $request->esi_applicable ?? 0,
            'pt_applicable' => $request->pt_applicable ?? 0,
            'tds_applicable' => $request->tds_applicable ?? 0,
        ]);

        return redirect()->route('hr.payroll.salary-structure.index')
            ->with('success', 'Created Successfully');
    }

    // 🔹 SHOW
    public function show($id)
    {
        $record = SalaryStructure::findOrFail($id);
        return view('hr.payroll.salary_structure.show', compact('record'));
    }

    // 🔹 EDIT
public function edit($id)
{
    $record = SalaryStructure::findOrFail($id);

    $allowances = \App\Models\Allowance::where('status', 1)->get();
    $deductions = \App\Models\PayrollDeduction::where('status', 'ACTIVE')->get();

    return view('hr.payroll.salary_structure.edit', compact('record', 'allowances', 'deductions'));
}
    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $record = SalaryStructure::findOrFail($id);

        $request->validate([
            'salary_structure_code' => 'required|unique:salary_structures,salary_structure_code,' . $id,
            'salary_structure_name' => 'required',
            'structure_category' => 'required',
            'status' => 'required',
            'effective_from' => 'required|date',
'effective_to' => 'nullable|date|after_or_equal:effective_from',
            'fixed_allowance_components' => 'required|array',
            'residual_component_id' => 'required',

            'allowed_work_types' => 'nullable|array',
            'fixed_deduction_components' => 'nullable|array',
        ]);
        if (!in_array($request->residual_component_id, $request->fixed_allowance_components)) {
    return back()->withErrors([
        'residual_component_id' => 'Residual must be one of the selected fixed components'
    ])->withInput();
}

        $record->update([
            'salary_structure_code' => $request->salary_structure_code,
            'salary_structure_name' => $request->salary_structure_name,
            'structure_category' => $request->structure_category,
            'status' => $request->status,

            'fixed_allowance_components' => $request->fixed_allowance_components,
            'variable_allowance_allowed' => $request->variable_allowance_allowed ?? 0,
            'residual_component_id' => $request->residual_component_id,

            'hourly_pay_eligible' => $request->hourly_pay_eligible ?? 0,
            'overtime_eligible' => $request->overtime_eligible ?? 0,
            'allowed_work_types' => $request->allowed_work_types ?? [],

            'fixed_deduction_components' => $request->fixed_deduction_components ?? [],
            'variable_deduction_allowed' => $request->variable_deduction_allowed ?? 0,
'effective_from' => $request->effective_from,
'effective_to' => $request->effective_to,
            'pf_applicable' => $request->pf_applicable ?? 0,
            'esi_applicable' => $request->esi_applicable ?? 0,
            'pt_applicable' => $request->pt_applicable ?? 0,
            'tds_applicable' => $request->tds_applicable ?? 0,
        ]);

        return redirect()->route('hr.payroll.salary-structure.index')
            ->with('success', 'Updated Successfully');
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        SalaryStructure::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }
public function deleted()
{
    $records = SalaryStructure::onlyTrashed()->paginate(10);
    return view('hr.payroll.salary_structure.deleted', compact('records'));
}

public function restore($id)
{
    SalaryStructure::onlyTrashed()->findOrFail($id)->restore();
    return redirect()->back()->with('success', 'Restored Successfully');
}

public function forceDelete($id)
{
    SalaryStructure::onlyTrashed()->findOrFail($id)->forceDelete();
    return redirect()->back()->with('success', 'Permanently Deleted');
}
}
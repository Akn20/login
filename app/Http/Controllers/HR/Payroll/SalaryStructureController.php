<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use App\Models\SalaryStructure;
use Illuminate\Http\Request;
class SalaryStructureController extends Controller
{
    //  LIST
    public function index()
    {
        $records = SalaryStructure::latest()->paginate(10);
        return view('salary_structure.index', compact('records'));
    }

    //  CREATE PAGE
    public function create()
    {
        return view('salary_structure.create');
    }

    //  STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'salary_structure_code' => 'required|unique:salary_structures',
            'salary_structure_name' => 'required',
            'structure_category' => 'required',
            'status' => 'required',

            'fixed_allowance_components' => 'required|array',
            'residual_component_id' => 'required',

            'salary_ceiling_amount' => 'nullable|numeric',
        ]);

        SalaryStructure::create([
            ...$validated,

            'fixed_allowance_components' => json_encode($request->fixed_allowance_components),
            'allowed_work_types' => json_encode($request->allowed_work_types ?? []),
            'fixed_deduction_components' => json_encode($request->fixed_deduction_components ?? []),

            'variable_allowance_allowed' => $request->variable_allowance_allowed ?? 0,
            'hourly_pay_eligible' => $request->hourly_pay_eligible ?? 0,
            'overtime_eligible' => $request->overtime_eligible ?? 0,
            'variable_deduction_allowed' => $request->variable_deduction_allowed ?? 0,

            'pf_applicable' => $request->pf_applicable ?? 0,
            'esi_applicable' => $request->esi_applicable ?? 0,
            'pt_applicable' => $request->pt_applicable ?? 0,
            'tds_applicable' => $request->tds_applicable ?? 0,
        ]);

        return redirect()->route('salary-structure.index')
            ->with('success', 'Created Successfully');
    }

    //  SHOW
    public function show($id)
    {
        $record = SalaryStructure::findOrFail($id);
        return view('salary_structure.show', compact('record'));
    }

    //  EDIT
    public function edit($id)
    {
        $record = SalaryStructure::findOrFail($id);
        return view('salary_structure.edit', compact('record'));
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $record = SalaryStructure::findOrFail($id);

        $validated = $request->validate([
            'salary_structure_code' => 'required|unique:salary_structures,salary_structure_code,' . $id,
            'salary_structure_name' => 'required',
            'structure_category' => 'required',
            'status' => 'required',
        ]);

        $record->update([
            ...$validated,

            'fixed_allowance_components' => json_encode($request->fixed_allowance_components ?? []),
            'allowed_work_types' => json_encode($request->allowed_work_types ?? []),
            'fixed_deduction_components' => json_encode($request->fixed_deduction_components ?? []),

            'variable_allowance_allowed' => $request->variable_allowance_allowed ?? 0,
            'hourly_pay_eligible' => $request->hourly_pay_eligible ?? 0,
            'overtime_eligible' => $request->overtime_eligible ?? 0,
            'variable_deduction_allowed' => $request->variable_deduction_allowed ?? 0,

            'pf_applicable' => $request->pf_applicable ?? 0,
            'esi_applicable' => $request->esi_applicable ?? 0,
            'pt_applicable' => $request->pt_applicable ?? 0,
            'tds_applicable' => $request->tds_applicable ?? 0,
        ]);

        return redirect()->route('salary-structure.index')
            ->with('success', 'Updated Successfully');
    }

    //  DELETE (Soft Delete)
    public function destroy($id)
    {
        SalaryStructure::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }
 // ================= API METHODS ================= //
public function apiIndex()
{
    $records = SalaryStructure::latest()->get();
    return response()->json($records);
}
public function apiStore(Request $request)
{
    $validated = $request->validate([
        'salary_structure_code' => 'required|unique:salary_structures',
        'salary_structure_name' => 'required',
        'structure_category' => 'required',
        'status' => 'required',
    ]);

    $record = SalaryStructure::create([
        ...$validated,
        'fixed_allowance_components' => json_encode($request->fixed_allowance_components ?? []),
        'allowed_work_types' => json_encode($request->allowed_work_types ?? []),
        'fixed_deduction_components' => json_encode($request->fixed_deduction_components ?? []),

        'variable_allowance_allowed' => $request->variable_allowance_allowed ?? 0,
        'hourly_pay_eligible' => $request->hourly_pay_eligible ?? 0,
        'overtime_eligible' => $request->overtime_eligible ?? 0,
        'variable_deduction_allowed' => $request->variable_deduction_allowed ?? 0,

        'pf_applicable' => $request->pf_applicable ?? 0,
        'esi_applicable' => $request->esi_applicable ?? 0,
        'pt_applicable' => $request->pt_applicable ?? 0,
        'tds_applicable' => $request->tds_applicable ?? 0,
    ]);

    return response()->json(['message' => 'Created', 'data' => $record]);
}
public function apiShow($id)
{
    $record = SalaryStructure::findOrFail($id);
    return response()->json($record);
}
public function apiUpdate(Request $request, $id)
{
    $record = SalaryStructure::findOrFail($id);

    $record->update($request->all());

    return response()->json(['message' => 'Updated']);
}
public function apiDestroy($id)
{
    SalaryStructure::findOrFail($id)->delete();

    return response()->json(['message' => 'Deleted']);
}
public function apiDeleted()
{
    $records = SalaryStructure::onlyTrashed()->get();
    return response()->json($records);
}
public function apiRestore($id)
{
    SalaryStructure::withTrashed()->findOrFail($id)->restore();

    return response()->json(['message' => 'Restored']);
}
public function apiForceDelete($id)
{
    SalaryStructure::withTrashed()->findOrFail($id)->forceDelete();

    return response()->json(['message' => 'Permanently Deleted']);
}
}
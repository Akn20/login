<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatutoryDeduction;
use App\Models\DeductionRuleSet;

class StatutoryDeductionController extends Controller
{
    // 🔹 INDEX
    public function index()
    {
        $records = StatutoryDeduction::with('ruleSet')->latest()->paginate(10);
        return view('hr.payroll.statutory_deduction.index', compact('records'));
    }

    // 🔹 CREATE
    public function create()
    {
        $ruleSets = DeductionRuleSet::where('status', 'active')->get();
        return view('hr.payroll.statutory_deduction.create', compact('ruleSets'));
    }

    // 🔹 STORE
    public function store(Request $request)
{
    // Validate first
    $validated = $request->validate([
        'statutory_code' => 'required|unique:statutory_deductions,statutory_code',
        'statutory_name' => 'required',
        'statutory_category' => 'required',
        'status' => 'required',
        'rule_set_id' => 'required',

        'eligibility_flag' => 'nullable|boolean',
        'salary_ceiling_applicable' => 'nullable|boolean',
        'salary_ceiling_amount' => 'nullable|numeric',
        'state_applicable' => 'nullable|boolean',
        'prorata_applicable' => 'nullable|boolean',
        'lop_impact' => 'nullable|boolean',
        'rounding_rule' => 'nullable|string',
        'show_in_payslip' => 'nullable|boolean',
        'payslip_order' => 'nullable|numeric',
        'compliance_head' => 'nullable|string',
        'authority_code' => 'nullable|string',
    ]);

    // Defaults
    $validated['eligibility_flag'] = $request->eligibility_flag ?? 0;
    $validated['salary_ceiling_applicable'] = $request->salary_ceiling_applicable ?? 0;
    $validated['state_applicable'] = $request->state_applicable ?? 0;
    $validated['prorata_applicable'] = $request->prorata_applicable ?? 0;
    $validated['lop_impact'] = $request->lop_impact ?? 0;
    $validated['show_in_payslip'] = $request->show_in_payslip ?? 1;

    $validated['applicable_states'] = json_encode($request->states ?? []);
   // $validated['statutory_authority_code'] = $request->authority_code;
$validated['authority_code'] = $request->authority_code;
    StatutoryDeduction::create($validated);

    return redirect()->route('hr.payroll.statutory-deduction.index')
                     ->with('success', 'Created successfully');
}

    // 🔹 SHOW
    public function show($id)
    {
        $record = StatutoryDeduction::with('ruleSet')->findOrFail($id);
        return view('hr.payroll.statutory_deduction.show', compact('record'));
    }

    // 🔹 EDIT
    public function edit($id)
    {
        $record = StatutoryDeduction::findOrFail($id);
        $ruleSets = DeductionRuleSet::where('status', 'active')->get();

        return view('hr.payroll.statutory_deduction.edit', compact('record', 'ruleSets'));
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $record = StatutoryDeduction::findOrFail($id);

        $request->validate([
            'statutory_code' => 'required|unique:statutory_deductions,statutory_code,' . $id,
            'statutory_name' => 'required',
        ]);

        $record->update([
            ...$request->all(),
            'applicable_states' => json_encode($request->applicable_states)
        ]);

        return redirect()->route('hr.payroll.statutory-deduction.index')
            ->with('success', 'Updated Successfully');
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        StatutoryDeduction::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    // 🔹 DELETED
   public function deleted()
{
    $records = StatutoryDeduction::onlyTrashed()
                ->latest()
                ->paginate(10);

    return view('hr.payroll.statutory_deduction.deleted', compact('records'));
}

    // 🔹 RESTORE
    public function restore($id)
    {
        StatutoryDeduction::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back()->with('success', 'Restored Successfully');
    }

    // 🔹 FORCE DELETE
    public function forceDelete($id)
    {
        StatutoryDeduction::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back()->with('success', 'Permanently Deleted');
    }


    // ================= API METHODS ================= //

public function apiIndex()
{
    return response()->json([
        'data' => StatutoryDeduction::latest()->get()
    ]);
}

public function apiStore(Request $request)
{
    $request->validate([
        'statutory_code' => 'required|unique:statutory_deductions,statutory_code',
        'statutory_name' => 'required',
        'statutory_category' => 'required',
        'status' => 'required',
        'rule_set_id' => 'required|exists:deduction_rule_sets,id',
    ]);

    $data = StatutoryDeduction::create([
        'statutory_code' => $request->statutory_code,
        'statutory_name' => $request->statutory_name,
        'statutory_category' => $request->statutory_category,
        'status' => $request->status,

        'rule_set_id' => $request->rule_set_id,

        'eligibility_flag' => (bool) $request->eligibility_flag,
        'salary_ceiling_applicable' => (bool) $request->salary_ceiling_applicable,
        'salary_ceiling_amount' => $request->salary_ceiling_amount,

        'state_applicable' => (bool) $request->state_applicable,
        'applicable_states' => json_encode($request->states ?? []),

        'prorata_applicable' => (bool) $request->prorata_applicable,
        'lop_impact' => (bool) $request->lop_impact,

        'rounding_rule' => $request->rounding_rule,

        'show_in_payslip' => (bool) $request->show_in_payslip,
        'payslip_order' => $request->payslip_order,

        'compliance_head' => $request->compliance_head,
        'authority_code' => $request->authority_code,
    ]);

    return response()->json([
        'message' => 'Created successfully',
        'data' => $data
    ]);
}

public function apiShow($id)
{
    return response()->json([
        'data' => StatutoryDeduction::findOrFail($id)
    ]);
}

public function apiUpdate(Request $request, $id)
{
    $data = StatutoryDeduction::findOrFail($id);

    $request->validate([
        'statutory_code' => 'required|unique:statutory_deductions,statutory_code,' . $id,
        'statutory_name' => 'required',
        'rule_set_id' => 'required|exists:deduction_rule_sets,id',
    ]);

    $data->update([
        'statutory_code' => $request->statutory_code,
        'statutory_name' => $request->statutory_name,
        'statutory_category' => $request->statutory_category,
        'status' => $request->status,

        'rule_set_id' => $request->rule_set_id,

        'eligibility_flag' => (bool) $request->eligibility_flag,
        'salary_ceiling_applicable' => (bool) $request->salary_ceiling_applicable,
        'salary_ceiling_amount' => $request->salary_ceiling_amount,

        'state_applicable' => (bool) $request->state_applicable,
        'applicable_states' => json_encode($request->states ?? []),

        'prorata_applicable' => (bool) $request->prorata_applicable,
        'lop_impact' => (bool) $request->lop_impact,

        'rounding_rule' => $request->rounding_rule,

        'show_in_payslip' => (bool) $request->show_in_payslip,
        'payslip_order' => $request->payslip_order,

        'compliance_head' => $request->compliance_head,
        'authority_code' => $request->authority_code,
    ]);

    return response()->json([
        'message' => 'Updated successfully',
        'data' => $data
    ]);
}

public function apiDestroy($id)
{
    StatutoryDeduction::findOrFail($id)->delete();

    return response()->json([
        'message' => 'Deleted successfully'
    ]);
}

public function apiDeleted()
{
    return response()->json([
        'data' => StatutoryDeduction::onlyTrashed()->get()
    ]);
}

public function apiRestore($id)
{
    StatutoryDeduction::onlyTrashed()->findOrFail($id)->restore();

    return response()->json([
        'message' => 'Restored successfully'
    ]);
}

public function apiForceDelete($id)
{
    StatutoryDeduction::onlyTrashed()->findOrFail($id)->forceDelete();

    return response()->json([
        'message' => 'Deleted permanently'
    ]);
}
}
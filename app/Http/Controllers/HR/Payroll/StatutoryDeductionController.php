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
    $validated['statutory_authority_code'] = $request->authority_code;

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
        $records = StatutoryDeduction::onlyTrashed()->get();
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
}
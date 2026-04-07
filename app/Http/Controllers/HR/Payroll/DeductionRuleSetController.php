<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeductionRuleSet;

class DeductionRuleSetController extends Controller
{
    // LIST
    public function index()
    {
        $rules = DeductionRuleSet::latest()->paginate(10);
        return view('hr.payroll.deduction_rule_set.index', compact('rules'));
    }

    // CREATE
    public function create()
    {
        return view('hr.payroll.deduction_rule_set.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'rule_set_code' => 'required|unique:deduction_rule_sets,rule_set_code',
            'rule_set_name' => 'required',
            'rule_category' => 'required',
            'calculation_type' => 'required',
            'calculation_applies_on' => 'required',
            'effective_from' => 'required|date',
            'status' => 'required',
        ]);

        DeductionRuleSet::create([
            'rule_set_code' => $request->rule_set_code,
            'rule_set_name' => $request->rule_set_name,
            'rule_category' => $request->rule_category,
            'calculation_type' => $request->calculation_type,
            'calculation_base' => $request->calculation_base,
            'calculation_value' => $request->calculation_value,
            'calculation_applies_on' => $request->calculation_applies_on,
            'slab_reference' => $request->slab_reference,
            'maximum_limit' => $request->maximum_limit,
            'minimum_limit' => $request->minimum_limit,
            'rounding_rule' => $request->rounding_rule,
            'prorata_applicable' => $request->prorata_applicable ?? 0,
            'lop_impact' => $request->lop_impact ?? 0,
            'editable_at_payroll' => $request->editable_at_payroll ?? 0,
            'skip_if_insufficient_salary' => $request->skip_if_insufficient_salary ?? 0,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
            'priority' => $request->priority,
            'max_percent_net_salary' => $request->max_percent_net_salary,
            'remarks' => $request->remarks,
            'status' => $request->status,
        ]);

        return redirect()->route('hr.payroll.deduction-rule-set.index')
            ->with('success', 'Created Successfully');
    }

    // SHOW
    public function show($id)
    {
        $rule = DeductionRuleSet::findOrFail($id);
        return view('hr.payroll.deduction_rule_set.show', compact('rule'));
    }

    // EDIT
    public function edit($id)
    {
        $rule = DeductionRuleSet::findOrFail($id);
        return view('hr.payroll.deduction_rule_set.edit', compact('rule'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $rule = DeductionRuleSet::findOrFail($id);

        $request->validate([
            'rule_set_code' => 'required|unique:deduction_rule_sets,rule_set_code,' . $id,
            'rule_set_name' => 'required',
        ]);

        $rule->update([
            'rule_set_code' => $request->rule_set_code,
            'rule_set_name' => $request->rule_set_name,
            'rule_category' => $request->rule_category,
            'calculation_type' => $request->calculation_type,
            'calculation_base' => $request->calculation_base,
            'calculation_value' => $request->calculation_value,
            'calculation_applies_on' => $request->calculation_applies_on,
            'slab_reference' => $request->slab_reference,
            'maximum_limit' => $request->maximum_limit,
            'minimum_limit' => $request->minimum_limit,
            'rounding_rule' => $request->rounding_rule,
            'prorata_applicable' => $request->prorata_applicable ?? 0,
            'lop_impact' => $request->lop_impact ?? 0,
            'editable_at_payroll' => $request->editable_at_payroll ?? 0,
            'skip_if_insufficient_salary' => $request->skip_if_insufficient_salary ?? 0,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
            'priority' => $request->priority,
            'max_percent_net_salary' => $request->max_percent_net_salary,
            'remarks' => $request->remarks,
            'status' => $request->status,
        ]);

        return redirect()->route('hr.payroll.deduction-rule-set.index')
            ->with('success', 'Updated Successfully');
    }

    // DELETE (Soft)
    public function destroy($id)
    {
        DeductionRuleSet::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    // DELETED LIST
    public function deleted()
    {
        $deleted = DeductionRuleSet::onlyTrashed()->get();
        return view('hr.payroll.deduction_rule_set.deleted', compact('deleted'));
    }

    // RESTORE
    public function restore($id)
    {
        DeductionRuleSet::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with('success', 'Restored Successfully');
    }

    // FORCE DELETE
    public function forceDelete($id)
    {
        DeductionRuleSet::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back()->with('success', 'Permanently Deleted');
    }
}
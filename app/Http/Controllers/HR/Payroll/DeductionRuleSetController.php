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
    'rule_set_code' => 'required|string|max:50|unique:deduction_rule_sets,rule_set_code',
    'rule_set_name' => 'required|string|max:100',

    'rule_category' => 'required|in:Statutory,Loan,Recovery,Ad-hoc',
    'calculation_type' => 'required|in:Fixed,Percentage,Slab,EMI',

    'calculation_base' => 'nullable|required_if:calculation_type,Percentage|in:Basic,Gross,CTC,Net',

    'calculation_value' => 'nullable|numeric|min:0',

    'calculation_applies_on' => 'required|in:Pre,Post',

    'slab_reference' => 'nullable|string|max:100',

    'maximum_limit' => 'nullable|numeric|min:0',
    'minimum_limit' => 'nullable|numeric|min:0|lte:maximum_limit',

    'rounding_rule' => 'nullable|in:Nearest,Up,Down',

    'prorata_applicable' => 'nullable|boolean',
    'lop_impact' => 'nullable|boolean',
    'editable_at_payroll' => 'nullable|boolean',
    'skip_if_insufficient_salary' => 'nullable|boolean',

    'priority' => 'nullable|integer|min:0|max:100',

    'max_percent_net_salary' => 'nullable|numeric|min:0|max:100',

    'effective_from' => 'required|date',
    'effective_to' => 'nullable|date|after_or_equal:effective_from',

    'status' => 'required|in:active,inactive',

    'remarks' => 'nullable|string|max:500',
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
    'rule_set_code' => 'required|string|max:50|unique:deduction_rule_sets,rule_set_code,' . $id,
    'rule_set_name' => 'required|string|max:100',

    'rule_category' => 'required|in:Statutory,Loan,Recovery,Ad-hoc',
    'calculation_type' => 'required|in:Fixed,Percentage,Slab,EMI',

    'calculation_base' => 'nullable|required_if:calculation_type,Percentage|in:Basic,Gross,CTC,Net',

    'calculation_value' => 'nullable|numeric|min:0',

    'calculation_applies_on' => 'required|in:Pre,Post',

    'slab_reference' => 'nullable|string|max:100',

    'maximum_limit' => 'nullable|numeric|min:0',
    'minimum_limit' => 'nullable|numeric|min:0|lte:maximum_limit',

    'rounding_rule' => 'nullable|in:Nearest,Up,Down',

    'prorata_applicable' => 'nullable|boolean',
    'lop_impact' => 'nullable|boolean',
    'editable_at_payroll' => 'nullable|boolean',
    'skip_if_insufficient_salary' => 'nullable|boolean',

    'priority' => 'nullable|integer|min:0|max:100',

    'max_percent_net_salary' => 'nullable|numeric|min:0|max:100',

    'effective_from' => 'required|date',
    'effective_to' => 'nullable|date|after_or_equal:effective_from',

    'status' => 'required|in:active,inactive',

    'remarks' => 'nullable|string|max:500',
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
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
    'statutory_code'            => 'required|unique:statutory_deductions,statutory_code',
    'statutory_name'            => 'required',
    'statutory_category'        => 'required',
    'status'                    => 'required',
    'rule_set_id'               => 'required',

    // Yes — mandatory per image
    'eligibility_flag'          => 'required|boolean',
    'state_applicable'          => 'required|boolean',
    'prorata_applicable'        => 'required|boolean',
    'lop_impact'                => 'required|boolean',
    'show_in_payslip'           => 'required|boolean',
    'compliance_head'           => 'required|string',
    'authority_code'            => 'required|string',

    // Conditional per image
    'salary_ceiling_applicable' => 'required|boolean',
    'salary_ceiling_amount'     => 'required_if:salary_ceiling_applicable,1|nullable|numeric',
    'states'                    => 'required_if:state_applicable,1|nullable|array',

    // No — optional per image
    'rounding_rule'             => 'nullable|string',
    'payslip_order'             => 'nullable|numeric',
]);

    // Defaults

    $validated['applicable_states'] = json_encode($request->states ?? []);

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
}
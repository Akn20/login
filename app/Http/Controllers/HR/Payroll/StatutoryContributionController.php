<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatutoryContribution;
use App\Models\DeductionRuleSet;

class StatutoryContributionController extends Controller
{

    // ================= INDEX =================
    public function index(Request $request)
    {
        $contributions = StatutoryContribution::latest()->paginate(10);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $contributions
            ]);
        }

        return view(
            'hr.payroll.statutory_contribution.index',
            ['contributions' => $contributions]
        );
    }

    // ================= CREATE =================
    public function create(Request $request)
    {
        $ruleSets = DeductionRuleSet::pluck('rule_set_code');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'ruleSets' => $ruleSets
            ]);
        }

        return view(
            'hr.payroll.statutory_contribution.create',
            ['ruleSets' => $ruleSets]
        );
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contribution_code' => 'required|unique:statutory_contributions,contribution_code',
            'contribution_name' => 'required',
            'statutory_category' => 'required',
            'rule_set_code' => 'required',
            'status' => 'required',
            'compliance_head' => 'required',
            'statutory_code' => 'required',

            'salary_ceiling_amount' => 'required_if:salary_ceiling_applicable,1|nullable|numeric|min:1',
            'applicable_states' => 'required_if:state_applicable,1|nullable|array',

            'prorata_applicable' => 'required',
            'lop_impact' => 'required',
            'show_in_payslip' => 'required',
            'included_in_ctc' => 'required',
            'payslip_order' => 'nullable|integer|min:1',
        ]);

        if ($request->has('applicable_states')) {
$validated['applicable_states'] = $request->applicable_states;        }

        $contribution = StatutoryContribution::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Statutory Contribution Created Successfully',
                'data' => $contribution
            ]);
        }

        return redirect()
            ->route('hr.payroll.statutory-contribution.index')
            ->with('success', 'Statutory Contribution Created Successfully');
    }

    // ================= SHOW =================
    public function show(Request $request, $id)
    {
        $statutoryContribution = StatutoryContribution::findOrFail($id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $statutoryContribution
            ]);
        }

        return view(
            'hr.payroll.statutory_contribution.view',
            ['statutoryContribution' => $statutoryContribution]
        );
    }

    // ================= EDIT =================
    public function edit(Request $request, $id)
    {
        $statutoryContribution = StatutoryContribution::findOrFail($id);
        $ruleSets = DeductionRuleSet::pluck('rule_set_code');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $statutoryContribution,
                'ruleSets' => $ruleSets
            ]);
        }

        return view(
            'hr.payroll.statutory_contribution.edit',
            [
                'statutoryContribution' => $statutoryContribution,
                'ruleSets' => $ruleSets
            ]
        );
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $statutoryContribution = StatutoryContribution::findOrFail($id);

        $validated = $request->validate([
            'contribution_code' => 'required|unique:statutory_contributions,contribution_code,' . $id,
            'contribution_name' => 'required',
            'statutory_category' => 'required',
            'rule_set_code' => 'required',
            'status' => 'required',
            'compliance_head' => 'required',
            'statutory_code' => 'required',

            'salary_ceiling_amount' => 'required_if:salary_ceiling_applicable,1|nullable|numeric|min:1',
            'applicable_states' => 'required_if:state_applicable,1|nullable|array',

            'prorata_applicable' => 'required',
            'lop_impact' => 'required',
            'show_in_payslip' => 'required',
            'included_in_ctc' => 'required',
            'payslip_order' => 'nullable|integer|min:1',
        ]);

        if ($request->has('applicable_states')) {
$validated['applicable_states'] = $request->applicable_states;        }

        $statutoryContribution->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Updated Successfully',
                'data' => $statutoryContribution
            ]);
        }

        return redirect()
            ->route('hr.payroll.statutory-contribution.index')
            ->with('success', 'Updated Successfully');
    }

    // ================= DELETE =================
    public function destroy(Request $request, $id)
    {
        $statutoryContribution = StatutoryContribution::findOrFail($id);
        $statutoryContribution->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Deleted Successfully'
            ]);
        }

        return redirect()
            ->route('hr.payroll.statutory-contribution.index')
            ->with('success', 'Deleted Successfully');
    }

    // ================= DELETED LIST =================
    public function deleted(Request $request)
    {
        $contributions = StatutoryContribution::onlyTrashed()->latest()->paginate(10);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $contributions
            ]);
        }

        return view(
            'hr.payroll.statutory_contribution.deleted',
            ['contributions' => $contributions]
        );
    }

    // ================= RESTORE =================
    public function restore(Request $request, $id)
    {
        $contribution = StatutoryContribution::onlyTrashed()->findOrFail($id);
        $contribution->restore();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Restored Successfully'
            ]);
        }

        return redirect()
            ->route('hr.payroll.statutory-contribution.deleted')
            ->with('success', 'Restored Successfully');
    }

    // ================= FORCE DELETE =================
    public function forceDelete(Request $request, $id)
    {
        $contribution = StatutoryContribution::onlyTrashed()->findOrFail($id);
        $contribution->forceDelete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permanently Deleted Successfully'
            ]);
        }

        return redirect()
            ->route('hr.payroll.statutory-contribution.deleted')
            ->with('success', 'Permanently Deleted Successfully');
    }
}
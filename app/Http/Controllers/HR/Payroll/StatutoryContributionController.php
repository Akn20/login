<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StatutoryContribution;
use App\Models\DeductionRuleSet;

class StatutoryContributionController extends Controller
{

    // ================= INDEX =================

    public function index()
    {

        $contributions =
            StatutoryContribution::latest()
                ->paginate(10);

        return view(
            'hr.payroll.statutory_contribution.index',
            [
                'contributions' => $contributions
            ]
        );

    }



    // ================= CREATE =================

    public function create()
    {

        $ruleSets =
            DeductionRuleSet::pluck('rule_set_code');

        return view(
            'hr.payroll.statutory_contribution.create',
            [
                'ruleSets' => $ruleSets
            ]
        );

    }



    // ================= STORE =================

    public function store(Request $request)
    {

        $request->validate([

            'contribution_code' =>
                'required|unique:statutory_contributions,contribution_code',

            'contribution_name' =>
                'required',

            'statutory_category' =>
                'required',

            'rule_set_code' =>
                'required',

            'status' =>
                'required',

            'compliance_head' =>
                'required',

            'statutory_code' =>
                'required',

            // ⭐ REQUIRED TEST CASE VALIDATIONS

            'salary_ceiling_amount' =>
                'required_if:salary_ceiling_applicable,1|nullable|numeric|min:1',

            'applicable_states' =>
                'required_if:state_applicable,1|nullable|array',

            // ⭐ SAFE VALIDATIONS

            'prorata_applicable' =>
                'required',

            'lop_impact' =>
                'required',

            'show_in_payslip' =>
                'required',

            'included_in_ctc' =>
                'required',

            'payslip_order' =>
                'nullable|integer|min:1',

        ]);


        // Convert states array to JSON
        $data = $request->all();

        if ($request->has('applicable_states')) {

            $data['applicable_states'] =
                json_encode($request->applicable_states);

        }


        StatutoryContribution::create($data);


        return redirect()
            ->route('hr.payroll.statutory-contribution.index')
            ->with(
                'success',
                'Statutory Contribution Created Successfully'
            );

    }



    // ================= EDIT =================

    public function edit($id)
    {

        $statutoryContribution =
            StatutoryContribution::findOrFail($id);

        $ruleSets =
            DeductionRuleSet::pluck('rule_set_code');

        return view(
            'hr.payroll.statutory_contribution.edit',
            [
                'statutoryContribution' => $statutoryContribution,
                'ruleSets' => $ruleSets
            ]
        );

    }



    // ================= SHOW =================

    public function show($id)
    {

        $statutoryContribution =
            StatutoryContribution::findOrFail($id);

        return view(
            'hr.payroll.statutory_contribution.view',
            [
                'statutoryContribution'
                    => $statutoryContribution
            ]
        );

    }



    // ================= UPDATE =================

    public function update(Request $request, $id)
    {

        $statutoryContribution =
            StatutoryContribution::findOrFail($id);


        $request->validate([

            'contribution_code' =>
                'required|unique:statutory_contributions,contribution_code,' . $id,

            'contribution_name' =>
                'required',

            'statutory_category' =>
                'required',

            'rule_set_code' =>
                'required',

            'status' =>
                'required',

            'compliance_head' =>
                'required',

            'statutory_code' =>
                'required',

            // ⭐ REQUIRED TEST CASE VALIDATIONS

            'salary_ceiling_amount' =>
                'required_if:salary_ceiling_applicable,1|nullable|numeric|min:1',

            'applicable_states' =>
                'required_if:state_applicable,1|nullable|array',

            // ⭐ SAFE VALIDATIONS

            'prorata_applicable' =>
                'required',

            'lop_impact' =>
                'required',

            'show_in_payslip' =>
                'required',

            'included_in_ctc' =>
                'required',

            'payslip_order' =>
                'nullable|integer|min:1',

        ]);


        // Convert states array to JSON
        $data = $request->all();

        if ($request->has('applicable_states')) {

            $data['applicable_states'] =
                json_encode($request->applicable_states);

        }


        $statutoryContribution->update($data);


        return redirect()
            ->route('hr.payroll.statutory-contribution.index')
            ->with(
                'success',
                'Updated Successfully'
            );

    }



    // ================= DELETE =================

    public function destroy($id)
    {

        $statutoryContribution =
            StatutoryContribution::findOrFail($id);

        $statutoryContribution->delete();

        return redirect()
            ->route('hr.payroll.statutory-contribution.index')
            ->with(
                'success',
                'Deleted Successfully'
            );

    }



    // ================= DELETED LIST =================

    public function deleted()
    {

        $contributions =
            StatutoryContribution::onlyTrashed()
                ->latest()
                ->paginate(10);

        return view(
            'hr.payroll.statutory_contribution.deleted',
            [
                'contributions' => $contributions
            ]
        );

    }



    // ================= RESTORE =================

    public function restore($id)
    {

        $contribution =
            StatutoryContribution::onlyTrashed()
                ->findOrFail($id);

        $contribution->restore();

        return redirect()
            ->route('hr.payroll.statutory-contribution.deleted')
            ->with(
                'success',
                'Restored Successfully'
            );

    }



    // ================= PERMANENT DELETE =================

    public function forceDelete($id)
    {

        $contribution =
            StatutoryContribution::onlyTrashed()
                ->findOrFail($id);

        $contribution->forceDelete();

        return redirect()
            ->route('hr.payroll.statutory-contribution.deleted')
            ->with(
                'success',
                'Permanently Deleted Successfully'
            );

    }

}
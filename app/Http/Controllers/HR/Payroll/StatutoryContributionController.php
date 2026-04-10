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

        // MUST send ruleSets
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

        ]);


        StatutoryContribution::create($request->all());


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

    
//==========show===========//

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

        $statutoryContribution->update($request->all());

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

}
<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RateEmployeeMapping;
use App\Models\DeductionRuleSet;
use App\Models\HourlyPay;
use App\Models\Staff;

class RateEmployeeMappingController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $rateMappings = RateEmployeeMapping::latest()
            ->paginate(10);

        return view(
            'hr.payroll.rate_employee_mapping.index',
            compact('rateMappings')
        );

    }



    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {

        $ruleSets = DeductionRuleSet::select(
                'rule_set_code',
                'rule_set_name'
            )
            ->whereNull('deleted_at')
            ->get();


        $workTypes = HourlyPay::select(
                'code',
                'name'
            )
            ->whereNull('deleted_at')
            ->get();


        $employees = Staff::select(
                'id',
                'name'
            )
            ->whereNull('deleted_at')
            ->get();


        $employeeTypes = [

            'Permanent',
            'Contract',
            'Temporary'

        ];


        $employeeCategories = [

            'Full Time',
            'Part Time',
            'Consultant'

        ];


        return view(
            'hr.payroll.rate_employee_mapping.create',
            compact(
                'ruleSets',
                'workTypes',
                'employees',
                'employeeTypes',
                'employeeCategories'
            )
        );

    }


/*
|--------------------------------------------------------------------------
| STORE
|--------------------------------------------------------------------------
*/

public function store(Request $request)
{

    $validated = $request->validate([

        'rule_set_code' => 'required|string|max:50',

        'rule_set_name' => 'required|string|max:100',

        'work_type_code' => 'required|string|max:50',

        'rate_type' => 'required|in:Flat,Multiplier',

        'base_rate_source' =>
            'required|in:Employee Rate,Rule Rate',

        'employee_type' =>
            'required|string|max:50',

        'base_rate_value' =>
            'nullable|numeric|min:0',

        'multiplier_value' =>
            'nullable|numeric|min:0',

        'maximum_hours' =>
            'nullable|numeric|min:1',

        'round_off_rule' =>
            'nullable|in:Nearest,Up,Down',

        'employee_id' =>
            'nullable|integer',

        'employee_category' =>
            'nullable|string|max:50'

    ]);


    // Flat Validation

    if (
        $request->rate_type === 'Flat'
        && empty($request->base_rate_value)
    ) {

        return back()
            ->withErrors([
                'base_rate_value' =>
                'Base Rate Value is required for Flat Rate'
            ])
            ->withInput();

    }


    // Multiplier Validation

    if (
        $request->rate_type === 'Multiplier'
        && empty($request->multiplier_value)
    ) {

        return back()
            ->withErrors([
                'multiplier_value' =>
                'Multiplier Value is required'
            ])
            ->withInput();

    }


    // Rule Rate Condition

    if (
        $request->rate_type === 'Flat'
        && $request->base_rate_source === 'Rule Rate'
        && empty($request->base_rate_value)
    ) {

        return back()
            ->withErrors([
                'base_rate_value' =>
                'Base Rate Value required when Rule Rate selected'
            ])
            ->withInput();

    }


    /*
    --------------------------------------------------
    Duplicate Rule Set Protection (NEW PART)
    --------------------------------------------------
    */

    try {

        RateEmployeeMapping::create($validated);

    } catch (\Illuminate\Database\QueryException $e) {

        return back()
            ->withErrors([
                'rule_set_code' =>
                'Rule Set Code already exists'
            ])
            ->withInput();

    }


    return redirect()
        ->route('hr.payroll.rate-employee-mapping.index')
        ->with(
            'success',
            'Rate Employee Mapping created successfully'
        );

}


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {

        $rateMapping =
            RateEmployeeMapping::with('employee')
            ->findOrFail($id);

        return view(
            'hr.payroll.rate_employee_mapping.show',
            compact('rateMapping')
        );

    }



    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

        $rateMapping =
            RateEmployeeMapping::findOrFail($id);


        $ruleSets =
            DeductionRuleSet::select(
                'rule_set_code',
                'rule_set_name'
            )
            ->whereNull('deleted_at')
            ->get();


        $workTypes =
            HourlyPay::select(
                'code',
                'name'
            )
            ->whereNull('deleted_at')
            ->get();


        $employees =
            Staff::select(
                'id',
                'name'
            )
            ->whereNull('deleted_at')
            ->get();


        $employeeTypes = [

            'Permanent',
            'Contract',
            'Temporary'

        ];


        $employeeCategories = [

            'Full Time',
            'Part Time',
            'Consultant'

        ];


        return view(
            'hr.payroll.rate_employee_mapping.edit',
            compact(
                'rateMapping',
                'ruleSets',
                'workTypes',
                'employees',
                'employeeTypes',
                'employeeCategories'
            )
        );

    }



    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {

        $rateMapping =
            RateEmployeeMapping::findOrFail($id);


        $validated = $request->validate([

            'rule_set_code' =>
                'required|string|max:50|unique:rate_employee_mappings,rule_set_code,' . $id,

            'rule_set_name' =>
                'required|string|max:100',

            'work_type_code' =>
                'required|string|max:50',

            'rate_type' =>
                'required|in:Flat,Multiplier',

            'base_rate_source' =>
                'required|in:Employee Rate,Rule Rate',

            'employee_type' =>
                'required|string|max:50',

            'base_rate_value' =>
                'nullable|numeric|min:0',

            'multiplier_value' =>
                'nullable|numeric|min:0',

            'maximum_hours' =>
                'nullable|numeric|min:1',

            'round_off_rule' =>
                'nullable|in:Nearest,Up,Down',

            'employee_id' =>
                'nullable|integer',

            'employee_category' =>
                'nullable|string|max:50'

        ]);


        // SAME CONDITIONAL VALIDATION AS STORE

        if (
            $request->rate_type === 'Flat'
            && empty($request->base_rate_value)
        ) {

            return back()
                ->withErrors([
                    'base_rate_value' =>
                    'Base Rate Value is required for Flat Rate'
                ])
                ->withInput();

        }


        if (
            $request->rate_type === 'Multiplier'
            && empty($request->multiplier_value)
        ) {

            return back()
                ->withErrors([
                    'multiplier_value' =>
                    'Multiplier Value is required'
                ])
                ->withInput();

        }


        $rateMapping->update($validated);


        return redirect()
            ->route('hr.payroll.rate-employee-mapping.index')
            ->with(
                'success',
                'Updated successfully'
            );

    }



    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {

        $rateMapping =
            RateEmployeeMapping::findOrFail($id);

        $rateMapping->delete();

        return redirect()
            ->route('hr.payroll.rate-employee-mapping.index')
            ->with('success', 'Record deleted');

    }



    /*
    |--------------------------------------------------------------------------
    | DELETED LIST
    |--------------------------------------------------------------------------
    */
public function deleted()
{

    $rateMappings =
        RateEmployeeMapping::with('employee') // ✅ required
        ->onlyTrashed()
        ->paginate(10);

    return view(
        'hr.payroll.rate_employee_mapping.deleted',
        compact('rateMappings')
    );

}

/*
|--------------------------------------------------------------------------
| RESTORE
|--------------------------------------------------------------------------
*/

public function restore($id)
{

    $rateMapping =
        RateEmployeeMapping::onlyTrashed()
        ->findOrFail($id);

    $rateMapping->restore();

    return redirect()
        ->route('hr.payroll.rate-employee-mapping.index') // ✅ go back to main list
        ->with(
            'success',
            'Record restored successfully'
        );

}



/*
|--------------------------------------------------------------------------
| FORCE DELETE
|--------------------------------------------------------------------------
*/

public function forceDelete($id)
{

    $rateMapping =
        RateEmployeeMapping::onlyTrashed()
        ->findOrFail($id);

    $rateMapping->forceDelete();

    return redirect()
        ->route('hr.payroll.rate-employee-mapping.deleted') // stay on deleted page
        ->with(
            'success',
            'Record permanently deleted'
        );

}
}
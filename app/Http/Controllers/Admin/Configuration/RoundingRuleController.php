<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoundingRule;

class RoundingRuleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $rules = RoundingRule::latest()
            ->paginate(10);

        return view(
            'admin.configuration.rounding.index',
            compact('rules')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'admin.configuration.rounding.create'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'module_name' => 'required',

            'rounding_type' => 'required',

            'decimal_places' => 'required|numeric|min:0|max:5'

        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        RoundingRule::create([

            'module_name' => $request->module_name,

            'rounding_type' => $request->rounding_type,

            'decimal_places' => $request->decimal_places,

            'is_active' => $request->is_active ?? true

        ]);

        return redirect()
            ->route('admin.configuration.rounding-rules.index')
            ->with(
                'success',
                'Rounding Rule Created Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $rule = RoundingRule::findOrFail($id);

        return view(
            'admin.configuration.rounding.edit',
            compact('rule')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $rule = RoundingRule::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'module_name' => 'required',

            'rounding_type' => 'required',

            'decimal_places' => 'required|numeric|min:0|max:5'

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $rule->update([

            'module_name' => $request->module_name,

            'rounding_type' => $request->rounding_type,

            'decimal_places' => $request->decimal_places,

            'is_active' => $request->is_active ?? true

        ]);

        return redirect()
            ->route('admin.configuration.rounding-rules.index')
            ->with(
                'success',
                'Rounding Rule Updated Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $rule = RoundingRule::findOrFail($id);

        $rule->delete();

        return redirect()
            ->route('admin.configuration.rounding-rules.index')
            ->with(
                'success',
                'Rounding Rule Deleted Successfully'
            );
    }
}

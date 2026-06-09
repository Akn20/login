<?php

namespace App\Http\Controllers\Api\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoundingRule;

class RoundingRuleApiController extends Controller
{
    public function index()
    {
        $rules = RoundingRule::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $rules
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([

            'module_name' => 'required',

            'rounding_type' => 'required',

            'decimal_places' => 'required|numeric'

        ]);

        $rule = RoundingRule::create([

            'module_name' => $request->module_name,

            'rounding_type' => $request->rounding_type,

            'decimal_places' => $request->decimal_places,

            'is_active' => $request->is_active ?? true

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Rounding Rule Created Successfully',

            'data' => $rule

        ], 201);
    }

    public function show($id)
    {
        $rule = RoundingRule::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $rule
        ]);
    }

    public function update(Request $request, $id)
    {
        $rule = RoundingRule::findOrFail($id);

        $request->validate([

            'module_name' => 'required',

            'rounding_type' => 'required',

            'decimal_places' => 'required|numeric'

        ]);

        $rule->update([

            'module_name' => $request->module_name,

            'rounding_type' => $request->rounding_type,

            'decimal_places' => $request->decimal_places,

            'is_active' => $request->is_active ?? true

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Rounding Rule Updated Successfully',

            'data' => $rule

        ]);
    }

    public function destroy($id)
    {
        $rule = RoundingRule::findOrFail($id);

        $rule->delete();

        return response()->json([

            'success' => true,

            'message' => 'Rounding Rule Deleted Successfully'

        ]);
    }
}

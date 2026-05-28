<?php

namespace App\Http\Controllers\Api\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaxStructure;

class TaxApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $taxes = TaxStructure::latest()->get();

        return response()->json([

            'success' => true,

            'message' => 'Tax List Retrieved Successfully',

            'data' => $taxes

        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'tax_name' => 'required',

            'tax_percentage' => 'required|numeric',

            'tax_type' => 'required',

            'calculation_type' => 'required'

        ]);

        $tax = TaxStructure ::create([

            'tax_name' => $request->tax_name,

            'tax_percentage' => $request->tax_percentage,

            'tax_type' => $request->tax_type,

            'calculation_type' => $request->calculation_type,

            'is_active' => $request->is_active ?? true

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Tax Created Successfully',

            'data' => $tax

        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $tax = TaxStructure::findOrFail($id);

        return response()->json([

            'success' => true,

            'data' => $tax

        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $tax = TaxStructure::findOrFail($id);

        $request->validate([

            'tax_name' => 'required',

            'tax_percentage' => 'required|numeric',

            'tax_type' => 'required',

            'calculation_type' => 'required'

        ]);

        $tax->update([

            'tax_name' => $request->tax_name,

            'tax_percentage' => $request->tax_percentage,

            'tax_type' => $request->tax_type,

            'calculation_type' => $request->calculation_type,

            'is_active' => $request->is_active ?? true

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Tax Updated Successfully',

            'data' => $tax

        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $tax = TaxStructure::findOrFail($id);

        $tax->delete();

        return response()->json([

            'success' => true,

            'message' => 'Tax Deleted Successfully'

        ], 200);
    }
}

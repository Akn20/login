<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\LocalTaxSetting;
use Illuminate\Http\Request;

class LocalTaxSettingApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => LocalTaxSetting::all()
        ]);
    }

    public function store(Request $request)
{
    try {

        $tax = LocalTaxSetting::create([
            'hospital_id' => 1,
            'tax_name' => $request->tax_name,
            'tax_percentage' => $request->tax_percentage,
            'tax_type' => $request->tax_type,
            'applicable_on' => $request->applicable_on,
            'status' => $request->status ?? 'Active'
        ]);

        return response()->json([
            'success' => true,
            'data' => $tax
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ], 500);
    }
}

    public function show($id)
    {
        $tax = LocalTaxSetting::find($id);

        if (!$tax) {
            return response()->json([
                'success' => false,
                'message' => 'Tax Setting Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tax
        ]);
    }

    public function update(Request $request, $id)
    {
        $tax = LocalTaxSetting::find($id);

        if (!$tax) {
            return response()->json([
                'success' => false,
                'message' => 'Tax Setting Not Found'
            ], 404);
        }

        $request->validate([
            'tax_name' => 'required',
            'tax_percentage' => 'required|numeric',
            'tax_type' => 'required',
            'applicable_on' => 'required'
        ]);

        $tax->update([
            'tax_name' => $request->tax_name,
            'tax_percentage' => $request->tax_percentage,
            'tax_type' => $request->tax_type,
            'applicable_on' => $request->applicable_on,
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tax Setting Updated Successfully',
            'data' => $tax->fresh()
        ]);
    }

    public function destroy($id)
    {
        $tax = LocalTaxSetting::find($id);

        if (!$tax) {
            return response()->json([
                'success' => false,
                'message' => 'Tax Setting Not Found'
            ], 404);
        }

        $tax->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tax Setting Deleted Successfully'
        ]);
    }
}
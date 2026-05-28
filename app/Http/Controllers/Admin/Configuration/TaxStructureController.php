<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaxStructure;

class TaxStructureController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $taxes = TaxStructure::latest()->paginate(10);

        return view(
            'admin.configuration.tax.index',
            compact('taxes')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.configuration.tax.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'tax_name' => 'required|unique:tax_structures,tax_name',

            'tax_percentage' => 'required|numeric|min:0|max:100',

            'tax_type' => 'required',

            'calculation_type' => 'required'

        ]);

        TaxStructure::create([

            'tax_name' => $request->tax_name,

            'tax_percentage' => $request->tax_percentage,

            'tax_type' => $request->tax_type,

            'calculation_type' => $request->calculation_type,

            'is_active' => $request->is_active ?? 1

        ]);

        return redirect()
            ->route('admin.configuration.taxes.index')
            ->with('success', 'Tax Created Successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $tax = TaxStructure::findOrFail($id);

        return view(
            'admin.configuration.tax.edit',
            compact('tax')
        );
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

            'tax_name' => 'required|unique:tax_structures,tax_name,' . $id,

            'tax_percentage' => 'required|numeric|min:0|max:100',

            'tax_type' => 'required',

            'calculation_type' => 'required'

        ]);

        $tax->update([

            'tax_name' => $request->tax_name,

            'tax_percentage' => $request->tax_percentage,

            'tax_type' => $request->tax_type,

            'calculation_type' => $request->calculation_type,

            'is_active' => $request->is_active ?? 1

        ]);

        return redirect()
            ->route('admin.configuration.taxes.index')
            ->with('success', 'Tax Updated Successfully');
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

        return redirect()
            ->route('admin.configuration.taxes.index')
            ->with('success', 'Tax Deleted Successfully');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\LocalTaxSetting;
use Illuminate\Http\Request;

class LocalTaxSettingController extends Controller
{
    public function index()
    {
        $taxes = LocalTaxSetting::all();

        return view(
    'admin.local_tax_settings.index',
    compact('taxes')
);
    }

    public function create()
    {
        return view('admin.local_tax_settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tax_name' => 'required',
            'tax_percentage' => 'required|numeric',
            'tax_type' => 'required',
            'applicable_on' => 'required'
        ]);

        LocalTaxSetting::create([
            'hospital_id' => 1,
            'tax_name' => $request->tax_name,
            'tax_percentage' => $request->tax_percentage,
            'tax_type' => $request->tax_type,
            'applicable_on' => $request->applicable_on,
            'status' => $request->status
        ]);

        return redirect()
            ->route('local-tax-settings.index')
            ->with('success', 'Tax Setting Added Successfully');
    }

    public function show($id)
    {
        $tax = LocalTaxSetting::findOrFail($id);

        return view(
    'admin.local_tax_settings.show',
    compact('tax')
);
    }

    public function edit($id)
    {
        $tax = LocalTaxSetting::findOrFail($id);

        return view(
    'admin.local_tax_settings.edit',
    compact('tax')
);
    }

    public function update(Request $request, $id)
    {
        $tax = LocalTaxSetting::findOrFail($id);

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

        return redirect()
            ->route('local-tax-settings.index')
            ->with('success', 'Tax Setting Updated Successfully');
    }

    public function destroy($id)
    {
        $tax = LocalTaxSetting::findOrFail($id);

        $tax->delete();

        return redirect()
            ->route('local-tax-settings.index')
            ->with('success', 'Tax Setting Deleted Successfully');
    }
}
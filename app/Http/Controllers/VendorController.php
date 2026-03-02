<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->get();
        return view('admin.pharmacy.vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.pharmacy.vendor.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'vendor_name'  => 'required|max:150|unique:vendors,vendor_name',
                'phone_number' => 'nullable|max:20',
                'email'        => 'nullable|email|max:150',
                'address'      => 'nullable|max:500',
                'status'       => 'required|in:Active,Inactive',
            ],
            [
                'vendor_name.required' => 'Vendor name is required.',
                'vendor_name.unique'   => 'This vendor already exists.',
                'status.required'      => 'Please select status.',
            ]
        );

        Vendor::create([
            'vendor_name'  => $request->vendor_name,
            'phone_number' => $request->phone_number,
            'email'        => $request->email,
            'address'      => $request->address,
            'status'       => $request->status,
            'created_by'   => 1,
        ]);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor added successfully');
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->load(['purchases', 'payments']);
        return view('admin.pharmacy.vendor.show', compact('vendor'));
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.pharmacy.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'vendor_name'  => "required|max:150|unique:vendors,vendor_name,$id",
                'phone_number' => 'nullable|max:20',
                'email'        => 'nullable|email|max:150',
                'address'      => 'nullable|max:500',
                'status'       => 'required|in:Active,Inactive',
            ],
            [
                'vendor_name.required' => 'Vendor name is required.',
                'vendor_name.unique'   => 'This vendor already exists.',
                'status.required'      => 'Please select status.',
            ]
        );

        $vendor = Vendor::findOrFail($id);

        $vendor->update([
            'vendor_name'  => $request->vendor_name,
            'phone_number' => $request->phone_number,
            'email'        => $request->email,
            'address'      => $request->address,
            'status'       => $request->status,
            'updated_by'   => 1,
        ]);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor updated successfully');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor deleted successfully');
    }

    public function trash()
    {
        $vendors = Vendor::onlyTrashed()->get();
        return view('admin.pharmacy.vendor.trash', compact('vendors'));
    }

    public function restore($id)
    {
        Vendor::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.vendors.trash')->with('success', 'Vendor restored');
    }

    public function forceDelete($id)
    {
        Vendor::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.vendors.trash')->with('success', 'Vendor removed permanently');
    }
    //added by sushan for api
    public function apiIndex(){
        $vendors=vendor::where('status','Active')->get();
        return response()->json($vendors);
    }
}

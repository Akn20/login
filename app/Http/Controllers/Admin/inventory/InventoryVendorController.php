<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryVendor;
use Illuminate\Http\Request;

class InventoryVendorController extends Controller
{
    public function index()
    {
        $vendors = InventoryVendor::latest()->get();

        return view('admin.inventory_vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.inventory_vendor.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'vendor_name' => 'required|max:150|unique:inventory_vendors,vendor_name',
                'phone_number' => 'required|digits:10',
                'email' => 'required|email|max:150',
                'address' => 'required|max:500',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'vendor_name.required' => 'Vendor name is required.',
                'vendor_name.unique' => 'This vendor already exists.',
                'phone_number.required' => 'Phone number is required.',
                'phone_number.digits' => 'Phone number must be exactly 10 digits.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'status.required' => 'Please select status.',
            ]
        );

        InventoryVendor::create([
            'vendor_name' => $request->vendor_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status,
            'created_by' => 1,
        ]);

        return redirect()->route('admin.inventory-vendors.index')
            ->with('success', 'Vendor added successfully');
    }

    public function show($id)
    {
        $vendor = InventoryVendor::findOrFail($id);
        $vendor->load(['purchaseOrders', 'purchases', 'payments']);

        return view('admin.inventory_vendor.show', compact('vendor'));
    }

    public function edit($id)
    {
        $vendor = InventoryVendor::findOrFail($id);

        return view('admin.inventory_vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'vendor_name' => "required|max:150|unique:inventory_vendors,vendor_name,$id",
                'phone_number' => 'required|digits:10',
                'email' => 'required|email|max:150',
                'address' => 'required|max:500',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'vendor_name.required' => 'Vendor name is required.',
                'vendor_name.unique' => 'This vendor already exists.',
                'phone_number.required' => 'Phone number is required.',
                'phone_number.digits' => 'Phone number must be exactly 10 digits.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'status.required' => 'Please select status.',
            ]
        );

        $vendor = InventoryVendor::findOrFail($id);

        $vendor->update([
            'vendor_name' => $request->vendor_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status,
            'updated_by' => 1,
        ]);

        return redirect()->route('admin.inventory-vendors.index')
            ->with('success', 'Vendor updated successfully');
    }

    public function delete($id)
    {
        $vendor = InventoryVendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('admin.inventory-vendors.index')
            ->with('success', 'Vendor deleted successfully');
    }

    public function trash()
    {
        $vendors = InventoryVendor::onlyTrashed()->get();

        return view('admin.inventory_vendor.trash', compact('vendors'));
    }

    public function restore($id)
    {
        InventoryVendor::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.inventory-vendors.trash')->with('success', 'Vendor restored');
    }

    public function forceDelete($id)
    {
        InventoryVendor::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.inventory-vendors.trash')->with('success', 'Vendor removed permanently');
    }

    public function apiIndex()
    {
        $vendors = InventoryVendor::where('status', 'Active')->get();

        return response()->json($vendors);
    }
}

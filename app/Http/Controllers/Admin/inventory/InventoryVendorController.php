<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryVendor;
use Illuminate\Http\Request;

class InventoryVendorController extends Controller
{
    public function index(Request $request)
    {
        $vendors = InventoryVendor::latest()->get();

        // API response (Postman / Mobile App)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'message' => 'Inventory vendors fetched successfully.',
                'data' => $vendors,
            ]);
        }

        // Existing web response
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
                'gst_number' => 'nullable|max:50',
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

        $vendor = InventoryVendor::create([
            'vendor_name' => $request->vendor_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'gst_number' => $request->gst_number,
            'address' => $request->address,
            'status' => $request->status,
            'created_by' => 1,
        ]);

        // API response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'message' => 'Vendor added successfully.',
                'data' => $vendor,
            ], 201);
        }

        // Existing web response
        return redirect()
            ->route('admin.inventory-vendors.index')
            ->with('success', 'Vendor added successfully');
    }

    public function show(Request $request, $id)
    {
        $vendor = InventoryVendor::findOrFail($id);
        $vendor->load(['purchaseOrders', 'purchases', 'payments']);

        // API response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'message' => 'Vendor fetched successfully.',
                'data' => $vendor,
            ]);
        }

        // Existing web response
        return view('admin.inventory_vendor.show', compact('vendor'));
    }

    public function edit(Request $request, $id)
    {
        $vendor = InventoryVendor::findOrFail($id);

        // API response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'message' => 'Vendor fetched successfully.',
                'data' => $vendor,
            ]);
        }

        // Existing web response
        return view('admin.inventory_vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'vendor_name' => "required|max:150|unique:inventory_vendors,vendor_name,$id",
                'phone_number' => 'required|digits:10',
                'email' => 'required|email|max:150',
                'gst_number' => 'nullable|max:50',
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
            'gst_number' => $request->gst_number,
            'address' => $request->address,
            'status' => $request->status,
            'updated_by' => 1,
        ]);

        // API response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'message' => 'Vendor updated successfully.',
                'data' => $vendor->fresh(),
            ]);
        }

        // Existing web response
        return redirect()
            ->route('admin.inventory-vendors.index')
            ->with('success', 'Vendor updated successfully');
    }

    public function delete(Request $request, $id)
    {
        $vendor = InventoryVendor::findOrFail($id);
        $vendor->delete();

        // API response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'message' => 'Vendor deleted successfully.',
            ]);
        }

        // Existing web response
        return redirect()
            ->route('admin.inventory-vendors.index')
            ->with('success', 'Vendor deleted successfully');
    }

    public function trash(Request $request)
    {
        $vendors = InventoryVendor::onlyTrashed()->get();

        // API response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'message' => 'Deleted vendors fetched successfully.',
                'data' => $vendors,
            ]);
        }

        // Existing web response
        return view('admin.inventory_vendor.trash', compact('vendors'));
    }

    public function restore(Request $request, $id)
    {
        $vendor = InventoryVendor::withTrashed()->findOrFail($id);
        $vendor->restore();

        // API response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'message' => 'Vendor restored successfully.',
                'data' => $vendor,
            ]);
        }

        // Existing web response
        return redirect()
            ->route('admin.inventory-vendors.trash')
            ->with('success', 'Vendor restored successfully');
    }

    public function forceDelete(Request $request, $id)
    {
        $vendor = InventoryVendor::withTrashed()->findOrFail($id);
        $vendor->forceDelete();

        // API response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'message' => 'Vendor permanently deleted.',
            ]);
        }

        // Existing web response
        return redirect()
            ->route('admin.inventory-vendors.trash')
            ->with('success', 'Vendor removed permanently');
    }

    public function apiIndex()
    {
        $vendors = InventoryVendor::where('status', 'Active')->get();

        return response()->json([
            'status' => true,
            'message' => 'Active vendors fetched successfully.',
            'data' => $vendors,
        ]);
    }
}
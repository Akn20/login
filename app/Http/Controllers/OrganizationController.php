<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Organization List
     */
    public function index(Request $request)
    {
        $query = Organization::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $organizations = $query->latest()->paginate(10);

        return view('admin.organization.index', compact('organizations'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        return view('admin.organization.create');
    }

    /**
     * Store Organization
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'type' => 'required|in:Private,Trust,Government',
            'registration_number' => 'nullable|string|max:100',
            'gst' => 'nullable|string|max:15',
            'contact_number' => 'required|digits:10',
            'email' => 'required|email|max:255',

            'admin_name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'admin_email' => 'required|email|max:255',
            'admin_mobile' => 'required|digits:10',

            'plan_type' => 'required|in:Basic,Standard,Premium',
            'status' => 'required|boolean',

            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'state' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'country' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'pincode' => 'required|digits:6',
        ]);

        Organization::create($validated);

        // IMPORTANT: use the admin.* route name here
        return redirect()->route('admin.organization.index')
            ->with('success', 'Organization Created Successfully');
    }

    /**
     * Show Edit Form
     */
    public function edit($id)
    {
        $organization = Organization::findOrFail($id);

        return view('admin.organization.edit', compact('organization'));
    }

    /**
     * Update Organization
     */
    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'email' => 'nullable|email|max:255',
            'type' => 'nullable|in:Private,Trust,Government',
            'status' => 'nullable|boolean',
            // add more fields to validate/update if needed
        ]);

        $organization->update($validated);

        return redirect()->route('admin.organization.index')
            ->with('success', 'Organization Updated Successfully');
    }

    /**
     * Soft Delete Organization
     */
    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete(); // soft delete

        return redirect()->route('admin.organization.index')
            ->with('success', 'Organization Deleted Successfully');
    }

    /**
     * Show Deleted Organizations
     */
    public function deleted()
    {
        $organizations = Organization::onlyTrashed()->latest()->paginate(10);

        return view('admin.organization.deleted', compact('organizations'));
    }

    /**
     * Restore Organization
     */
    public function restore($id)
    {
        $organization = Organization::withTrashed()->findOrFail($id);
        $organization->restore();

        return redirect()->route('admin.organization.deleted')
            ->with('success', 'Organization Restored Successfully');
    }

    /**
     * Permanently Delete
     */
    public function forceDelete($id)
    {
        $organization = Organization::withTrashed()->findOrFail($id);
        $organization->forceDelete();

        return redirect()->route('admin.organization.deleted')
            ->with('success', 'Organization Permanently Deleted');
    }

    /**
     * Show Organization Details
     */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);

        return view('admin.organization.show', compact('organization'));
    }

    public function toggleStatus($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->status = !$organization->status;
        $organization->save();

        return back()->with('success', 'Status updated');
    }

    /* ===================== API ===================== */

    public function apiIndex()
    {
        $data = Organization::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'type' => 'required|in:Private,Trust,Government',
            'registration_number' => 'nullable|string|max:100',
            'gst' => 'nullable|string|max:15',
            'contact_number' => 'required|digits:10',
            'email' => 'required|email|max:255',

            'admin_name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'admin_email' => 'required|email|max:255',
            'admin_mobile' => 'required|digits:10',

            'plan_type' => 'required|in:Basic,Standard,Premium',
            'status' => 'required|boolean',

            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'state' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'country' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'pincode' => 'required|digits:6',
        ]);

        $org = Organization::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Organization created',
            'data' => $org,
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization) {
            return response()->json([
                'status' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'type' => 'required|in:Private,Trust,Government',
            'registration_number' => 'nullable|string|max:100',
            'gst' => 'nullable|string|max:15',
            'contact_number' => 'required|digits:10',
            'email' => 'required|email|max:255',

            'admin_name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'admin_email' => 'required|email|max:255',
            'admin_mobile' => 'required|digits:10',

            'plan_type' => 'required|in:Basic,Standard,Premium',
            'status' => 'required|boolean',

            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'state' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'country' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'pincode' => 'required|digits:6',
        ]);

        $organization->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Organization updated successfully',
            'data' => $organization,
        ]);
    }

    public function apiDelete($id)
    {
        $org = Organization::findOrFail($id);
        $org->delete();

        return response()->json([
            'status' => true,
            'message' => 'Organization deleted',
        ]);
    }

    public function apiShow($id)
    {
        $organization = Organization::find($id);

        if (!$organization) {
            return response()->json([
                'status' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $organization,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\Organization;
use App\Models\Module;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{


    /**
     * Institution List Pag
     */
    public function index(Request $request)
    {
        $query = Institution::with(['organization', 'modules']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $institutions = $query->latest()->paginate(10);

        return view('institutions.index', compact('institutions'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $organizations = Organization::where('status', 1)->get();
        $modules = Module::orderBy('priority')->get();

        $lastInstitution = Institution::withTrashed()->latest()->first();

        $nextNumber = $lastInstitution
            ? ((int) substr($lastInstitution->code, 4)) + 1
            : 1;

        $nextCode = 'INST' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('institutions.create', compact(
            'nextCode',
            'organizations',
            'modules'
        ));
    }

    public function toggleStatus($id)
    {
        $institution = Institution::findOrFail($id);

        $institution->status = !$institution->status;
        $institution->save();

        return back()->with('success', 'Status updated successfully');
    }


    /**
     * Store Institution
     */
    /**
     * Store Institutions
     */

    public function store(Request $request)
    {
        $validated = $request->validate([

            // Core
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'code' => 'required|unique:institutions,code',
            'gst_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'timezone' => 'nullable|string|max:100',

            // Branding
            'institution_url' => 'nullable|url|max:255',
            'login_template' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'default_language' => 'nullable|string|max:100',

            // Admin
            'admin_name' => 'nullable|string|max:255',
            'admin_email' => 'nullable|email|max:255',
            'admin_mobile' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:100',
            'status' => 'required|boolean',

            // Legal
            'mou_copy' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'po_number' => 'nullable|string|max:255',
            'po_start_date' => 'nullable|date',
            'po_end_date' => 'nullable|date',
            'subscription_plan' => 'nullable|string|max:255',

            // Billing
            'invoice_type' => 'nullable|string|max:255',
            'invoice_frequency' => 'nullable|string|max:255',
            'payment_mode' => 'nullable|string|max:255',
            'invoice_amount' => 'nullable|numeric',
            'payment_status' => 'nullable|string|max:255',
            'payment_received' => 'nullable|boolean',
            'payment_date' => 'nullable|date',
            'transaction_reference' => 'nullable|string|max:255',

            // Support
            'poc_name' => 'nullable|string|max:255',
            'poc_email' => 'nullable|email|max:255',
            'poc_contact' => 'nullable|string|max:20',
            'support_sla' => 'nullable|string|max:255',

            // Modules
            'modules' => 'nullable|array',
            'modules.*' => 'exists:modules,id',
        ]);

        // Upload logo
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $validated['logo'] = $filename;
        }

        if ($request->hasFile('mou_copy')) {
            $file = $request->file('mou_copy');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/mou'), $filename);

            $validated['mou_copy'] = 'uploads/mou/' . $filename;
        }


        $institution = Institution::create($validated);

        if ($request->modules) {
            $institution->modules()->sync($request->modules);
        }

        return redirect()->route('institutions.index')
            ->with('success', 'Institution Created Successfully');
    }



    public function destroy($id)
    {
        $institution = Institution::findOrFail($id);
        $institution->delete(); // soft delete

        return redirect()->route('institutions.index')
            ->with('success', 'Institution Deleted Successfully');
    }



    /**
     * Edit Form
     */
    public function edit($id)
    {
        $institution = Institution::with('modules')->findOrFail($id);
        $organizations = Organization::where('status', 1)->get();
        $modules = Module::orderBy('priority')->get();

        return view('institutions.edit', compact(
            'institution',
            'organizations',
            'modules'
        ));
    }

    /**
     * Update Institution
     */
    public function update(Request $request, $id)
    {
        $institution = Institution::findOrFail($id);

        $validated = $request->validate([

            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'code' => 'required|unique:institutions,code,' . $id,
            'gst_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'timezone' => 'nullable|string|max:100',

            'institution_url' => 'nullable|url|max:255',
            'login_template' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'default_language' => 'nullable|string|max:100',

            'admin_name' => 'nullable|string|max:255',
            'admin_email' => 'nullable|email|max:255',
            'admin_mobile' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:100',
            'status' => 'required|boolean',

            'mou_copy' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'po_number' => 'nullable|string|max:255',
            'po_start_date' => 'nullable|date',
            'po_end_date' => 'nullable|date',
            'subscription_plan' => 'nullable|string|max:255',

            'invoice_type' => 'nullable|string|max:255',
            'invoice_frequency' => 'nullable|string|max:255',
            'payment_mode' => 'nullable|string|max:255',
            'invoice_amount' => 'nullable|numeric',
            'payment_status' => 'nullable|string|max:255',
            'payment_received' => 'nullable|boolean',
            'payment_date' => 'nullable|date',
            'transaction_reference' => 'nullable|string|max:255',

            'poc_name' => 'nullable|string|max:255',
            'poc_email' => 'nullable|email|max:255',
            'poc_contact' => 'nullable|string|max:20',
            'support_sla' => 'nullable|string|max:255',

            'modules' => 'nullable|array',
            'modules.*' => 'exists:modules,id',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $validated['logo'] = $filename;
        }
        if ($request->hasFile('mou_copy')) {
            $file = $request->file('mou_copy');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/mou'), $filename);

            $validated['mou_copy'] = 'uploads/mou/' . $filename;
        }


        $institution->update($validated);

        $institution->modules()->sync($request->modules ?? []);

        return redirect()->route('institutions.index')
            ->with('success', 'Institution Updated Successfully');
    }


    /**
     * Show
     */
    public function show($id)
    {
        $institution = Institution::with(['organization', 'modules'])
            ->findOrFail($id);

        return view('institutions.show', compact('institution'));
    }
    /**
     * Show Deleted Institutions
     */
    public function deleted()
    {
        $institutions = Institution::onlyTrashed()
            ->with(['organization', 'modules'])
            ->latest()
            ->paginate(10);

        return view('institutions.deleted', compact('institutions'));
    }

    /**
     * Restore Deleted Institution
     */
    public function restore($id)
    {
        $institution = Institution::onlyTrashed()->findOrFail($id);
        $institution->restore();

        return redirect()->route('institutions.deleted')
            ->with('success', 'Institution restored successfully');
    }

    /**
     * Permanently Delete Institution
     */
    public function forceDelete($id)
    {
        $institution = Institution::onlyTrashed()->findOrFail($id);
        $institution->forceDelete();

        return redirect()->route('institutions.deleted')
            ->with('success', 'Institution permanently deleted');
    }




    /* ============================================================
       API SECTION
    ============================================================ */

    public function apiIndex()
    {
        return response()->json([
            'status' => true,
            'message' => 'Institution list fetched successfully',
            'data' => Institution::with(['organization', 'modules'])->latest()->get()
        ]);
    }

    public function apiShow($id)
    {
        $institution = Institution::with(['organization', 'modules'])->find($id);

        if (!$institution) {
            return response()->json([
                'status' => false,
                'message' => 'Institution not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $institution
        ]);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255',
            'code' => 'required|unique:institutions,code',
            'gst_number' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'pincode' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'email' => 'nullable|email',
            'timezone' => 'nullable|string',
            'institution_url' => 'nullable|string',
            'login_template' => 'nullable|string',
            'default_language' => 'nullable|string',
            'admin_name' => 'nullable|string',
            'admin_email' => 'nullable|email',
            'admin_mobile' => 'nullable|string',
            'role' => 'nullable|string',
            'status' => 'required|boolean',
            'subscription_plan' => 'nullable|string',
            'invoice_type' => 'nullable|string',
            'invoice_frequency' => 'nullable|string',
            'payment_mode' => 'nullable|string',
            'invoice_amount' => 'nullable|numeric',
            'payment_status' => 'nullable|string',
            'payment_received' => 'nullable|boolean',
            'payment_date' => 'nullable|date',
            'transaction_reference' => 'nullable|string',
            'poc_name' => 'nullable|string',
            'poc_email' => 'nullable|email',
            'poc_contact' => 'nullable|string',
            'support_sla' => 'nullable|string',
        ]);

        $institution = Institution::create($validated);

        if ($request->modules) {
            $institution->modules()->sync($request->modules);
        }

        return response()->json([
            'status' => true,
            'message' => 'Institution created successfully',
            'data' => $institution
        ], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $institution = Institution::find($id);

        if (!$institution) {
            return response()->json([
                'status' => false,
                'message' => 'Institution not found'
            ], 404);
        }

        $institution->update($request->only([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255',
            'code' => 'required|unique:institutions,code',
            'gst_number' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'pincode' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'email' => 'nullable|email',
            'timezone' => 'nullable|string',
            'institution_url' => 'nullable|string',
            'login_template' => 'nullable|string',
            'default_language' => 'nullable|string',
            'admin_name' => 'nullable|string',
            'admin_email' => 'nullable|email',
            'admin_mobile' => 'nullable|string',
            'role' => 'nullable|string',
            'status' => 'required|boolean',
            'subscription_plan' => 'nullable|string',
            'invoice_type' => 'nullable|string',
            'invoice_frequency' => 'nullable|string',
            'payment_mode' => 'nullable|string',
            'invoice_amount' => 'nullable|numeric',
            'payment_status' => 'nullable|string',
            'payment_received' => 'nullable|boolean',
            'payment_date' => 'nullable|date',
            'transaction_reference' => 'nullable|string',
            'poc_name' => 'nullable|string',
            'poc_email' => 'nullable|email',
            'poc_contact' => 'nullable|string',
            'support_sla' => 'nullable|string',

        ]));

        if ($request->modules) {
            $institution->modules()->sync($request->modules);
        }

        return response()->json([
            'status' => true,
            'message' => 'Institution updated successfully',
            'data' => $institution
        ]);
    }

    public function apiDelete($id)
    {
        $institution = Institution::find($id);

        if (!$institution) {
            return response()->json([
                'status' => false,
                'message' => 'Institution not found'
            ], 404);
        }

        $institution->delete();

        return response()->json([
            'status' => true,
            'message' => 'Institution deleted successfully'
        ]);
    }
}

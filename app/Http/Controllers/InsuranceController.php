<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientInsurance;
use App\Models\InsuranceDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Patient;

class InsuranceController extends Controller
{
    /**
     * 🔹 LIST
     */

public function index(Request $request)
{
    $query = PatientInsurance::with('patient'); // 🔥 relation

    // 🔍 Patient name filter
    if ($request->patient_name) {
        $query->whereHas('patient', function ($q) use ($request) {
            $q->where('first_name', 'like', '%' . $request->patient_name . '%')
              ->orWhere('last_name', 'like', '%' . $request->patient_name . '%');
        });
    }

    if ($request->policy_number) {
        $query->where('policy_number', 'like', '%' . $request->policy_number . '%');
    }

    if ($request->provider_name) {
        $query->where('provider_name', 'like', '%' . $request->provider_name . '%');
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $insurances = $query->latest()->paginate(10);

    return view('admin.Receptionist.insurance.index', compact('insurances'));
}

    /**
     * 🔹 CREATE
     */
    public function create()
{
    $patients = Patient::select('id', 'first_name', 'last_name', 'patient_code')->get();

    return view('admin.Receptionist.insurance.create', compact('patients'));
}

    /**
     * 🔹 STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'insurance_type' => 'required',
            'provider_name' => 'required',
            'policy_number' => 'required|unique:patient_insurances,policy_number',
            'policy_holder_name' => 'required',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
            'insurance_card' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $insurance = PatientInsurance::create([
                
                'patient_id' => $request->patient_id,
                'insurance_type' => $request->insurance_type,
                'provider_name' => $request->provider_name,
                'policy_number' => $request->policy_number,
                'policy_holder_name' => $request->policy_holder_name,
                'valid_from' => $request->valid_from,
                'valid_to' => $request->valid_to,
                'sum_insured' => $request->sum_insured,
                'tpa_name' => $request->tpa_name,
                'remarks' => $request->remarks,
                'status' => 'pending',
                'created_by' => auth()->id() ?? 1,
            ]);

            // Upload Documents
            $this->uploadDocuments($request, $insurance->id);

            DB::commit();

            return redirect()->route('admin.insurance.index')
                ->with('success', 'Insurance created successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * 🔹 EDIT
     */
    public function edit($id)
    {
        $insurance = PatientInsurance::with('documents')->findOrFail($id);

        $patients = Patient::select('id', 'first_name', 'last_name', 'patient_code')->get();

        return view('admin.Receptionist.insurance.edit', compact('insurance', 'patients'));
    }

    /**
     * 🔹 UPDATE
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $insurance = PatientInsurance::findOrFail($id);

        $status = $request->status;

        // map claimed → verified
        if ($status == 'claimed') {
            $status = 'verified';
        }

        // ❗ Prevent editing if not pending
        //if ($insurance->status != 'pending') {
        //    return back()->with('error', 'Only pending insurance can be updated');
        //}

        $request->validate([
            'provider_name' => 'required',
            'policy_number' => 'required|unique:patient_insurances,policy_number,' . $id,
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
            'status' => 'required|in:pending,claimed,rejected',
        ]);

        DB::beginTransaction();

        try {

            $insurance->update([
                'insurance_type' => $request->insurance_type,
                'provider_name' => $request->provider_name,
                'policy_number' => $request->policy_number,
                'policy_holder_name' => $request->policy_holder_name,
                'valid_from' => $request->valid_from,
                'valid_to' => $request->valid_to,
                'sum_insured' => $request->sum_insured,
                'tpa_name' => $request->tpa_name,
                'status' => $status,
                'remarks' => $request->remarks,
            ]);

            // Upload new docs (replace old if same type)
            $this->uploadDocuments($request, $insurance->id, true);

            DB::commit();

            return redirect()->route('admin.insurance.index')
                ->with('success', 'Insurance updated successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * 🔹 SHOW
     */
    public function show($id)
    {
        $insurance = PatientInsurance::with(['documents', 'patient'])->findOrFail($id);

        return view('admin.Receptionist.insurance.show', compact('insurance'));
    }

    /**
     * 🔹 DELETE (OPTIONAL BUT IMPORTANT)
     */
    public function destroy($id)
    {
        $insurance = PatientInsurance::with('documents')->findOrFail($id);

        foreach ($insurance->documents as $doc) {
            if (Storage::disk('public')->exists($doc->file_path)) {
                Storage::disk('public')->delete($doc->file_path);
            }
            $doc->delete();
        }

        $insurance->delete();

        return back()->with('success', 'Insurance deleted successfully');
    }

    /**
     * 🔹 DOCUMENT UPLOAD HANDLER
     */
  
private function uploadDocuments(Request $request, $insuranceId, $replace = false)
{
    $documents = [
        'insurance_card' => 'Insurance Card',
        'id_proof' => 'ID Proof',
        'authorization_letter' => 'Authorization Letter',
    ];

    foreach ($documents as $field => $type) {

        // ✅ CHECK FILE EXISTS
        if ($request->hasFile($field) && $request->file($field)->isValid()) {

            // 🔁 REPLACE OLD FILE (FOR UPDATE)
            if ($replace) {
                $oldDoc = InsuranceDocument::where('insurance_id', $insuranceId)
                    ->where('document_type', $type)
                    ->first();

                if ($oldDoc) {

                    // ✅ DELETE OLD FILE FROM STORAGE
                    if ($oldDoc->file_path && Storage::disk('public')->exists($oldDoc->file_path)) {
                        Storage::disk('public')->delete($oldDoc->file_path);
                    }

                    // ✅ DELETE OLD DB RECORD
                    $oldDoc->delete();
                }
            }

            // 📂 GET FILE
            $file = $request->file($field);

            // ✅ GENERATE UNIQUE FILE NAME (IMPORTANT)
            $fileName = time() . '_' . $field . '.' . $file->getClientOriginalExtension();

            // ✅ STORE FILE
            $path = $file->storeAs('insurance_documents', $fileName, 'public');

            // ✅ SAVE IN DB
            InsuranceDocument::create([
                'id' => Str::uuid(),
                'insurance_id' => $insuranceId,
                'document_type' => $type,
                'file_path' => $path,
                'uploaded_at' => now(),
            ]);
        }
    }
}

    //API FUNCTIONS

    public function apiIndex()
    {
        $insurances = PatientInsurance::with('patient','documents')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $insurances
        ]);
    }

    public function apiShow($id)
    {
        $insurance = PatientInsurance::with('patient','documents')->find($id);

        if (!$insurance) {
            return response()->json([
                'status' => false,
                'message' => 'Insurance not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $insurance
        ]);
    }



public function apiStore(Request $request)
{
    //  VALIDATION
    $request->validate([
        'patient_id' => 'required',
        'provider_name' => 'required',
        'policy_number' => 'required',

        //  FILE VALIDATION
        'insurance_card' => 'required|file|mimes:jpg,jpeg,png,pdf',
        'id_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'authorization_letter' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
    ]);

    DB::beginTransaction();

    try {

        //  CREATE INSURANCE
        $insurance = PatientInsurance::create([
            'id' => Str::uuid(),
            'patient_id' => $request->patient_id,
            'insurance_type' => $request->insurance_type,
            'provider_name' => $request->provider_name,
            'policy_number' => $request->policy_number,
            'policy_holder_name' => $request->policy_holder_name,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'sum_insured' => $request->sum_insured,
            'tpa_name' => $request->tpa_name,
            'remarks' => $request->remarks,
            'status' => 'pending',
            'created_by' => $request->created_by ?? 1,
        ]);

        //  UPLOAD DOCUMENTS
        $this->uploadDocuments($request, $insurance->id);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Insurance created successfully',
            'data' => $insurance
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
    public function apiUpdate(Request $request, $id)
    {
        $insurance = PatientInsurance::find($id);

        if (!$insurance) {
            return response()->json([
                'status' => false,
                'message' => 'Insurance not found'
            ], 404);
        }

        $status = $request->status;

        // 🔥 mapping
        if ($status == 'claimed') {
            $status = 'verified';
        }

        DB::beginTransaction();

        try {

            $insurance->update([
                'insurance_type' => $request->insurance_type,
                'provider_name' => $request->provider_name,
                'policy_number' => $request->policy_number,
                'policy_holder_name' => $request->policy_holder_name,
                'valid_from' => $request->valid_from,
                'valid_to' => $request->valid_to,
                'sum_insured' => $request->sum_insured,
                'tpa_name' => $request->tpa_name,
                'remarks' => $request->remarks,
                'status' => $status,
            ]);

            $this->uploadDocuments($request, $insurance->id, true);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Updated successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function apiDestroy($id)
    {
        $insurance = PatientInsurance::with('documents')->find($id);

        if (!$insurance) {
            return response()->json([
                'status' => false,
                'message' => 'Insurance not found'
            ], 404);
        }

        foreach ($insurance->documents as $doc) {
            if (Storage::disk('public')->exists($doc->file_path)) {
                Storage::disk('public')->delete($doc->file_path);
            }
            $doc->delete();
        }

        $insurance->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }

 
}
<?php

namespace App\Http\Controllers\Api\PatientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataUsageConsent;

class DataUsageConsentApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | List All Consents
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $consents = DataUsageConsent::with('patient')
            ->latest()
            ->get();

        return response()->json([

            'success' => true,

            'data' => $consents

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Store Consent
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'patient_id' => 'required|exists:patients,id',

            'purpose' => 'required',

            'consent_status' => 'required',

            'remarks' => 'nullable|string',

            'document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048'

        ]);

        $documentPath = null;

        if ($request->hasFile('document')) {

            $documentPath = $request->file('document')
                ->store('data-usage-consents', 'public');
        }

        $consent = DataUsageConsent::create([

            'patient_id' => $request->patient_id,

            'purpose' => $request->purpose,

            'consent_status' => $request->consent_status,

            'remarks' => $request->remarks,

            'document_path' => $documentPath,

            'consent_taken_at' => now(),

            'recorded_by' => auth()->id()

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Consent recorded successfully',

            'data' => $consent

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Show Single Consent
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $consent = DataUsageConsent::with('patient')
            ->findOrFail($id);

        return response()->json([

            'success' => true,

            'data' => $consent

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Consent
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $consent = DataUsageConsent::findOrFail($id);

        $documentPath = $consent->document_path;

        if ($request->hasFile('document')) {

            $documentPath = $request->file('document')
                ->store('data-usage-consents', 'public');
        }

        $consent->update([

            'purpose' => $request->purpose,

            'consent_status' => $request->consent_status,

            'remarks' => $request->remarks,

            'document_path' => $documentPath

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Consent updated successfully',

            'data' => $consent

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Consent
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $consent = DataUsageConsent::findOrFail($id);

        $consent->delete();

        return response()->json([

            'success' => true,

            'message' => 'Consent deleted successfully'

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Patient Consent History
    |--------------------------------------------------------------------------
    */

    public function history($patient_id)
    {
        $history = DataUsageConsent::where(
                'patient_id',
                $patient_id
            )
            ->latest()
            ->get();

        return response()->json([

            'success' => true,

            'data' => $history

        ]);
    }
}
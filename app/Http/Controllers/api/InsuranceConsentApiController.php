<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InsuranceConsent;

class InsuranceConsentApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $consents = InsuranceConsent::with([
            'patient',
            'insurance'
        ])->latest()->get();

        return response()->json([

            'success' => true,

            'data' => $consents
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'patient_id' => 'required|exists:patients,id',

            'insurance_id' => 'required|exists:patient_insurances,id',

            'consent_status' => 'required',

            'document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $document = null;

        /*
        |--------------------------------------------------------------------------
        | Upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('document')) {

            $document = $request->file('document')
                ->store(
                    'insurance-consents',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Store
        |--------------------------------------------------------------------------
        */

        $consent = InsuranceConsent::create([

            'patient_id' => $request->patient_id,

            'insurance_id' => $request->insurance_id,

            'consent_text' => $request->consent_text,

            'consent_status' => $request->consent_status,

            'consent_given_at' => now(),

            'document' => $document,

            'recorded_by' => auth()->id()
        ]);

        return response()->json([

            'success' => true,

            'message' => 'Insurance consent recorded successfully',

            'data' => $consent
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $consent = InsuranceConsent::with([
            'patient',
            'insurance'
        ])->findOrFail($id);

        return response()->json([

            'success' => true,

            'data' => $consent
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $consent = InsuranceConsent::findOrFail($id);

        $document = $consent->document;

        /*
        |--------------------------------------------------------------------------
        | Upload New File
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('document')) {

            $document = $request->file('document')
                ->store(
                    'insurance-consents',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $consent->update([

            'patient_id' => $request->patient_id,

            'insurance_id' => $request->insurance_id,

            'consent_text' => $request->consent_text,

            'consent_status' => $request->consent_status,

            'document' => $document
        ]);

        return response()->json([

            'success' => true,

            'message' => 'Insurance consent updated successfully',

            'data' => $consent
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $consent = InsuranceConsent::findOrFail($id);

        $consent->delete();

        return response()->json([

            'success' => true,

            'message' => 'Insurance consent deleted successfully'
        ]);
    }
}
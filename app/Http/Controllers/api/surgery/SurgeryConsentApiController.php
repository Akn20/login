<?php

namespace App\Http\Controllers\Api\Surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurgeryConsent;
use App\Models\Surgery;
use Illuminate\Support\Facades\Validator;

class SurgeryConsentApiController extends Controller
{
    /**
     * Store Surgery Consent
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [

                'surgery_id' => 'required|exists:surgeries,id',

                'consent_status' => 'required|in:Granted,Refused,Pending',

                'procedure_explained' => 'nullable|string',

                'risks_explained' => 'nullable|string',

                'remarks' => 'nullable|string',

                'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'

            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $surgery = Surgery::findOrFail($request->surgery_id);

            $documentPath = null;

            // Upload Document
            if ($request->hasFile('document')) {

                $documentPath = $request->file('document')
                    ->store('surgery-consents', 'public');
            }

            // Create or Update Consent
            $consent = SurgeryConsent::updateOrCreate(

                ['surgery_id' => $request->surgery_id],

                [
                    'patient_id' => $surgery->patient_id,

                    'consent_status' => $request->consent_status,

                    'procedure_explained' => $request->procedure_explained,

                    'risks_explained' => $request->risks_explained,

                    'remarks' => $request->remarks,

                    'document_path' => $documentPath,

                    'consent_taken_at' => now(),

                    'recorded_by' => auth()->id()
                ]
            );

            return response()->json([

                'success' => true,

                'message' => 'Surgery consent recorded successfully',

                'data' => $consent

            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' => 'Failed to record consent',

                'error' => $e->getMessage()

            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers\Doctor\Surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurgeryConsent;
use App\Models\Surgery;
use App\Models\Patient;
use Illuminate\Support\Str;

class ConsentController extends Controller
{
    /**
     * Consent List
     */
    public function index()
    {
        $consents = SurgeryConsent::with([
                'patient',
                'surgery'
            ])
            ->latest()
            ->paginate(10);

        return view(
            'doctor.surgery.consent.index',
            compact('consents')
        );
    }

    /**
     * Create Consent Page
     */
   public function create()
    {
        $surgeries = Surgery::with('patient')
            ->latest()
            ->get();

        return view(
            'doctor.surgery.consent.create',
            compact('surgeries')
        );
    }

    /**
     * Store Consent
     */
    public function store(Request $request)
    {
        $request->validate([

            'surgery_id' => 'required|exists:surgeries,id',

            'consent_status' => 'required|in:Granted,Refused,Pending',

            'procedure_explained' => 'nullable|string',

            'risks_explained' => 'nullable|string',

            'remarks' => 'nullable|string',

            'document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048'

        ]);

        $surgery = Surgery::findOrFail($request->surgery_id);

        $documentPath = null;

        /*
        |--------------------------------------------------------------------------
        | Upload Consent Document
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('document')) {

            $documentPath = $request->file('document')
                ->store('surgery-consents', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Create / Update Consent
        |--------------------------------------------------------------------------
        */

        SurgeryConsent::updateOrCreate(

            [
                'surgery_id' => $request->surgery_id
            ],

            [
                'id' => Str::uuid(),

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

        return redirect()
            ->route('consent.index')
            ->with(
                'success',
                'Surgery consent recorded successfully'
            );
    }

    /**
     * View Single Consent
     */
    public function show($id)
    {
        $consent = SurgeryConsent::with([
                'patient',
                'surgery'
            ])
            ->findOrFail($id);

        return view(
            'doctor.surgery.consent.show',
            compact('consent')
        );
    }

    /**
     * Patient Consent History
     */
    public function history($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);

        $consents = SurgeryConsent::with('surgery')
            ->where('patient_id', $patient_id)
            ->latest()
            ->get();

        return view(
            'doctor.surgery.consent.history',
            compact('patient', 'consents')
        );
    }
}
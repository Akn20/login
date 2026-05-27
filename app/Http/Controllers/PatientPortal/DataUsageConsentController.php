<?php

namespace App\Http\Controllers\PatientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataUsageConsent;
use App\Models\Patient;

class DataUsageConsentController extends Controller
{
    /**
     * Consent List
     */
    public function index()
    {
        $consents = DataUsageConsent::with('patient')
            ->latest()
            ->paginate(10);

        return view(
            'patient-portal.data-consent.index',
            compact('consents')
        );
    }

    /**
     * Create Page
     */
    public function create()
    {
        $patients = Patient::latest()->get();

        return view(
            'patient-portal.data-consent.create',
            compact('patients')
        );
    }

    /**
     * Store Consent
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

        /*
        |--------------------------------------------------------------------------
        | Upload Document
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('document')) {

            $documentPath = $request->file('document')
                ->store('data-usage-consents', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Store Consent
        |--------------------------------------------------------------------------
        */

        DataUsageConsent::create([

            'patient_id' => $request->patient_id,

            'purpose' => $request->purpose,

            'consent_status' => $request->consent_status,

            'remarks' => $request->remarks,

            'document_path' => $documentPath,

            'consent_taken_at' => now(),

            'recorded_by' => auth()->id()

        ]);

        return redirect()
            ->route('data-consent.index')
            ->with(
                'success',
                'Data usage consent recorded successfully'
            );
    }

    /**
     * View Consent
     */
    public function show($id)
    {
        $consent = DataUsageConsent::with('patient')
            ->findOrFail($id);

        return view(
            'patient-portal.data-consent.show',
            compact('consent')
        );
    }

    /**
     * Patient History
     */
    public function history($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);

        $consents = DataUsageConsent::where(
                'patient_id',
                $patient_id
            )
            ->latest()
            ->get();

        return view(
            'patient-portal.data-consent.history',
            compact('patient', 'consents')
        );
    }
}
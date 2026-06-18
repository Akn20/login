<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InsuranceConsent;
use App\Models\Patient;
use App\Models\PatientInsurance;

class InsuranceConsentController extends Controller
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
        ])->latest()->paginate(10);

        return view(
            'admin.insurance-consent.index',
            compact('consents')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $patients = Patient::latest()->get();

        $insurances = PatientInsurance::with('patient')
            ->latest()
            ->get();

        return view(
            'admin.insurance-consent.create',
            compact(
                'patients',
                'insurances'
            )
        );
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

        InsuranceConsent::create([

            'patient_id' => $request->patient_id,

            'insurance_id' => $request->insurance_id,

            'consent_text' => $request->consent_text,

            'consent_status' => $request->consent_status,

            'consent_given_at' => now(),

            'document' => $document,

            'recorded_by' => auth()->id()
        ]);

        return redirect()
            ->route('admin.insurance-consent.index')
            ->with(
                'success',
                'Insurance consent recorded successfully'
            );
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

        return view(
            'admin.insurance-consent.show',
            compact('consent')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $consent = InsuranceConsent::findOrFail($id);

        $patients = Patient::latest()->get();

        $insurances = PatientInsurance::with('patient')
            ->latest()
            ->get();

        return view(
            'admin.insurance-consent.edit',
            compact(
                'consent',
                'patients',
                'insurances'
            )
        );
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

        if ($request->hasFile('document')) {

            $document = $request->file('document')
                ->store(
                    'insurance-consents',
                    'public'
                );
        }

        $consent->update([

            'patient_id' => $request->patient_id,

            'insurance_id' => $request->insurance_id,

            'consent_text' => $request->consent_text,

            'consent_status' => $request->consent_status,

            'document' => $document
        ]);

        return redirect()
            ->route('admin.insurance-consent.index')
            ->with(
                'success',
                'Insurance consent updated successfully'
            );
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

        return redirect()
            ->route('admin.insurance-consent.index')
            ->with(
                'success',
                'Insurance consent deleted successfully'
            );
    }
}
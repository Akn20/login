<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Consultation;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientInquiryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SEARCH PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('admin.Receptionist.patient-inquiry.index');
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH BY UHID
    |--------------------------------------------------------------------------
    */

    public function searchUHID(Request $request)
    {
        $request->validate([
            'uhid' => 'required|max:50'
        ]);

        $patients = Patient::where(
            'patient_code',
            $request->uhid
        )->get();

        return view(
            'admin.Receptionist.patient-inquiry.index',
            compact('patients')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH BY MOBILE
    |--------------------------------------------------------------------------
    */

    public function searchMobile(Request $request)
    {
        $request->validate([
            'mobile' => 'required|min:10'
        ]);

        $patients = Patient::where(
            'mobile',
            'like',
            '%' . $request->mobile . '%'
        )->get();

        return view(
            'admin.Receptionist.patient-inquiry.index',
            compact('patients')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH BY NAME
    |--------------------------------------------------------------------------
    */

    public function searchName(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $patients = Patient::where(
            'first_name',
            'like',
            '%' . $request->name . '%'
        )
        ->orWhere(
            'last_name',
            'like',
            '%' . $request->name . '%'
        )
        ->get();

        return view(
            'admin.Receptionist.patient-inquiry.index',
            compact('patients')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PATIENT DETAILS
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $patient = Patient::findOrFail($id);

        return view(
            'admin.Receptionist.patient-inquiry.show',
            compact('patient')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VISIT HISTORY
    |--------------------------------------------------------------------------
    */

    public function visitHistory($id)
    {
        $patient = Patient::findOrFail($id);

        $consultations = Consultation::with([
            'doctor.department'
        ])
        ->where('patient_id', $id)
        ->latest()
        ->get();

        return view(
            'admin.Receptionist.patient-inquiry.visit-history',
            compact(
                'patient',
                'consultations'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VISIT SUMMARY
    |--------------------------------------------------------------------------
    */

    public function visitSummary($id)
    {
        $patient = Patient::findOrFail($id);

        $consultations = Consultation::with([
            'doctor.department'
        ])
        ->where('patient_id', $id)
        ->latest()
        ->get();

        return view(
            'admin.Receptionist.patient-inquiry.visit-summary',
            compact(
                'patient',
                'consultations'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PDF SUMMARY
    |--------------------------------------------------------------------------
    */

    public function printSummary($id)
    {
        $patient = Patient::findOrFail($id);

        $consultations = Consultation::with([
            'doctor.department'
        ])
        ->where('patient_id', $id)
        ->latest()
        ->get();

        $pdf = Pdf::loadView(
            'admin.Receptionist.patient-inquiry.visit-summary-pdf',
            compact(
                'patient',
                'consultations'
            )
        );

        return $pdf->download(
            'patient_visit_summary.pdf'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | API : SEARCH BY UHID
    |--------------------------------------------------------------------------
    */

    public function apiSearchUHID(Request $request)
    {
        $patients = Patient::where(
            'patient_code',
            $request->uhid
        )->get();

        return response()->json([
            'status' => true,
            'data' => $patients
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | API : SEARCH BY MOBILE
    |--------------------------------------------------------------------------
    */

    public function apiSearchMobile(Request $request)
    {
        $patients = Patient::where(
            'mobile',
            'like',
            '%' . $request->mobile . '%'
        )->get();

        return response()->json([
            'status' => true,
            'data' => $patients
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | API : SEARCH BY NAME
    |--------------------------------------------------------------------------
    */

    public function apiSearchName(Request $request)
    {
        $patients = Patient::where(
            'first_name',
            'like',
            '%' . $request->name . '%'
        )
        ->orWhere(
            'last_name',
            'like',
            '%' . $request->name . '%'
        )
        ->get();

        return response()->json([
            'status' => true,
            'data' => $patients
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | API : PATIENT DETAILS
    |--------------------------------------------------------------------------
    */

    public function apiShow($id)
{
    $patient = Patient::findOrFail($id);

    return response()->json([
        'status' => true,
        'data' => [
            'id' => $patient->id,
            'patient_code' => $patient->patient_code,
            'name' => $patient->first_name . ' ' . $patient->last_name,
            'gender' => $patient->gender,
            'age' => $patient->date_of_birth
                ? \Carbon\Carbon::parse($patient->date_of_birth)->age
                : null,
            'mobile' => $patient->mobile,
            'email' => $patient->email,
            'blood_group' => $patient->blood_group,
            'address' => $patient->address,
            'status' => $patient->status ? 'Active' : 'Inactive',
        ]
    ]);
}

    /*
    |--------------------------------------------------------------------------
    | API : VISIT HISTORY
    |--------------------------------------------------------------------------
    */

    public function apiVisitHistory($id)
    {
        $consultations = Consultation::with([
            'doctor.department'
        ])
        ->where('patient_id', $id)
        ->latest()
        ->get();

        return response()->json([
            'status' => true,
            'data' => $consultations
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | API : VISIT SUMMARY
    |--------------------------------------------------------------------------
    */

    public function apiVisitSummary($id)
    {
        $patient = Patient::findOrFail($id);

        $consultations = Consultation::with([
            'doctor.department'
        ])
        ->where('patient_id', $id)
        ->latest()
        ->get();

        return response()->json([
            'status' => true,
            'patient' => $patient,
            'consultations' => $consultations
        ]);
    }
}

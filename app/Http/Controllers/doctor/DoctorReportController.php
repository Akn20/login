<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Staff;
use App\Models\Surgery;
use App\Models\IPDAdmission;
use Carbon\Carbon;
use DB;

use Illuminate\Support\Str;

class DoctorReportController extends Controller
{
    public function consultationSummary(Request $request)
    {
        $query = Consultation::with([
            'doctor.department',
            'patient'
        ]);

        // SEARCH BY DOCTOR
        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // DATE FILTER
        if ($request->from_date && $request->to_date) {

            $query->whereBetween(
                'consultation_date',
                [
                    $request->from_date,
                    $request->to_date
                ]
            );
        }

        $consultations = $query->latest()->get();

        // DASHBOARD COUNTS
        $totalConsultations = $consultations->count();

        $todayConsultations = Consultation::whereDate(
            'consultation_date',
            today()
        )->count();

        // DOCTOR SUMMARY
        $doctorSummary = Consultation::select(
                'doctor_id',
                DB::raw('COUNT(*) as total_consultations')
            )
            ->groupBy('doctor_id')
            ->with('doctor.department')
            ->get();

        $doctors = Staff::all();

        return view(
            'doctor.reports.consultation-summary',
            compact(
                'consultations',
                'totalConsultations',
                'todayConsultations',
                'doctorSummary',
                'doctors'
            )
        );
    }

    public function opdSummary(Request $request)
{
    $query = Consultation::with([
        'patient',
        'doctor.department'
    ]);

    // Doctor filter
    if ($request->doctor_id) {

        $query->where(
            'doctor_id',
            $request->doctor_id
        );
    }

    // Patient search
    if ($request->patient_name) {

        $query->whereHas('patient', function ($q) use ($request) {

            $q->where('first_name', 'like', '%' . $request->patient_name . '%')
              ->orWhere('last_name', 'like', '%' . $request->patient_name . '%');

        });
    }

    // From date
    if ($request->from_date) {

        $query->whereDate(
            'consultation_date',
            '>=',
            $request->from_date
        );
    }

    // To date
    if ($request->to_date) {

        $query->whereDate(
            'consultation_date',
            '<=',
            $request->to_date
        );
    }

    $consultations = $query
        ->latest()
        ->get();

    $totalOpdCases = Consultation::count();

    $todayOpdCases = Consultation::whereDate(
        'consultation_date',
        today()
    )->count();

    $followUpCases = Consultation::whereNotNull(
        'diagnosis'
    )->count();

    $newPatients = Consultation::distinct(
        'patient_id'
    )->count('patient_id');

    $doctors = Staff::all();

    return view(
        'doctor.reports.opd-summary',
        compact(
            'consultations',
            'totalOpdCases',
            'todayOpdCases',
            'followUpCases',
            'newPatients',
            'doctors'
        )
    );
}

public function ipdSummary(Request $request)
{
    $query = IPDAdmission::with([
        'patient',
        'doctor.department'
    ]);

    // Doctor filter
    if ($request->doctor_id) {

        $query->where(
            'doctor_id',
            $request->doctor_id
        );
    }

    // Patient search
    if ($request->patient_name) {

        $query->whereHas('patient', function ($q) use ($request) {

            $q->where('first_name', 'like', '%' . $request->patient_name . '%')
              ->orWhere('last_name', 'like', '%' . $request->patient_name . '%');

        });
    }

    // Status filter
    if ($request->status) {

        $query->where(
            'status',
            $request->status
        );
    }

    // From date
    if ($request->from_date) {

        $query->whereDate(
            'admission_date',
            '>=',
            $request->from_date
        );
    }

    // To date
    if ($request->to_date) {

        $query->whereDate(
            'admission_date',
            '<=',
            $request->to_date
        );
    }

    $admissions = $query
        ->latest()
        ->get();

    $totalAdmissions = IPDAdmission::count();

    $activeAdmissions = IPDAdmission::where(
        'status',
        'Admitted'
    )->count();

    $dischargedPatients = IPDAdmission::where(
        'status',
        'Discharged'
    )->count();

    $todayAdmissions = IPDAdmission::whereDate(
        'admission_date',
        today()
    )->count();

    $doctors = Staff::all();

    return view(
        'doctor.reports.ipd-summary',
        compact(
            'admissions',
            'totalAdmissions',
            'activeAdmissions',
            'dischargedPatients',
            'todayAdmissions',
            'doctors'
        )
    );
}

public function prescriptionSummary(Request $request)
{
    $query = Consultation::with([
        'patient',
        'doctor.department',
        'medicines'
    ]);

    // Doctor Filter
    if ($request->doctor_id) {

        $query->where(
            'doctor_id',
            $request->doctor_id
        );
    }

    // From Date
    if ($request->from_date) {

        $query->whereDate(
            'consultation_date',
            '>=',
            $request->from_date
        );
    }

    // To Date
    if ($request->to_date) {

        $query->whereDate(
            'consultation_date',
            '<=',
            $request->to_date
        );
    }

    $consultations = $query
        ->latest()
        ->get();

    $totalPrescriptions = Consultation::count();

    $todayPrescriptions = Consultation::whereDate(
        'consultation_date',
        today()
    )->count();

    $doctors = Staff::all();

    return view(
        'doctor.reports.prescription-summary',
        compact(
            'consultations',
            'totalPrescriptions',
            'todayPrescriptions',
            'doctors'
        )
    );
}

public function surgerySummary(Request $request)
{
    $query = Surgery::with([
        'patient',
        'doctor.department'
    ]);

    // Doctor filter
    if ($request->doctor_id) {

        $query->where(
            'doctor_id',
            $request->doctor_id
        );
    }

    // Surgery status
    if ($request->status) {

        $query->where(
            'status',
            $request->status
        );
    }

    // From date
    if ($request->from_date) {

        $query->whereDate(
            'surgery_date',
            '>=',
            $request->from_date
        );
    }

    // To date
    if ($request->to_date) {

        $query->whereDate(
            'surgery_date',
            '<=',
            $request->to_date
        );
    }

    $surgeries = $query
        ->latest()
        ->get();

   $totalSurgeries = Surgery::count();

$todaySurgeries = Surgery::whereDate(
    'surgery_date',
    today()
)->count();

$emergencySurgeries = Surgery::where(
    'priority',
    'Emergency'
)->count();

$normalSurgeries = Surgery::where(
    'priority',
    'Normal'
)->count();
    $doctors = Staff::all();

    return view(
        'doctor.reports.surgery-summary',
        compact(
            'surgeries',
            'totalSurgeries',
            'emergencySurgeries',
            'normalSurgeries',
            'todaySurgeries',
            'doctors'
        )
    );
}


public function followupCompliance(Request $request)
{
    $query = Consultation::with([
        'patient',
        'doctor.department'
    ]);

    // Doctor filter
    if ($request->doctor_id) {

        $query->where(
            'doctor_id',
            $request->doctor_id
        );
    }

    // From date
    if ($request->from_date) {

        $query->whereDate(
            'consultation_date',
            '>=',
            $request->from_date
        );
    }

    // To date
    if ($request->to_date) {

        $query->whereDate(
            'consultation_date',
            '<=',
            $request->to_date
        );
    }

    $consultations = $query
        ->latest()
        ->get();

    $totalFollowups = $consultations->count();

    $todayFollowups = Consultation::whereDate(
        'consultation_date',
        today()
    )->count();

    $doctors = Staff::all();

    return view(
        'doctor.reports.followup-compliance',
        compact(
            'consultations',
            'totalFollowups',
            'todayFollowups',
            'doctors'
        )
    );
}
}
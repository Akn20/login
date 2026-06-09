<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\IPDAdmission;
use App\Models\Consultation;
use App\Models\ConsultationMedicine;
use App\Models\PatientMedicalFlag;
use App\Models\Surgery;

class MedicalHistoryController extends Controller
{
    public function index()
    {
        $search = request('search');

        $patients = collect();

        if ($search) {

            $patients = Patient::where(function ($query) use ($search) {

                $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('patient_code', 'LIKE', '%' . $search . '%')
                    ->orWhere('mobile', 'LIKE', '%' . $search . '%');

            })->get();
        }

        // API Response
        if (request()->expectsJson()) {

            return response()->json([
                'success' => true,
                'data' => $patients,
            ]);
        }

        // Web Response
        return view(
            'admin.patients.medical_history_mgt.index',
            compact('patients')
        );
    }

    public function show($patientId)
    {
        $patient = Patient::findOrFail($patientId);

        // OPD Visit History
        $opdVisits = Appointment::with([
            'doctor',
            'department'
        ])
            ->where('patient_id', $patientId)
            ->orderByDesc('appointment_date')
            ->get();

        // IPD Admission History
        $ipdAdmissions = IPDAdmission::with([
            'doctor',
            'department',
            'ward',
            'bed'
        ])
            ->where('patient_id', $patientId)
            ->orderByDesc('admission_date')
            ->get();

        // Diagnosis History
        $consultations = Consultation::with([
            'doctor'
        ])
            ->where('patient_id', $patientId)
            ->orderByDesc('consultation_date')
            ->get();

        // Medication History
        $consultationMedicines = ConsultationMedicine::with([
            'medicine',
            'consultation.doctor'
        ])
            ->whereHas('consultation', function ($query) use ($patientId) {

                $query->where('patient_id', $patientId);

            })
            ->get();

        // Allergy History
        $allergies = PatientMedicalFlag::where('patient_id', $patientId)
            ->where('type', 'allergy')
            ->latest()
            ->get();

        // Chronic Condition History
        $chronicConditions = PatientMedicalFlag::where('patient_id', $patientId)
            ->where('type', 'chronic')
            ->latest()
            ->get();

        // Surgery History
        $surgeries = Surgery::with([
            'surgeon',
            'assistantDoctor',
            'anesthetist'
        ])
            ->where('patient_id', $patientId)
            ->latest()
            ->get();

        // API Response
        if (request()->expectsJson()) {

            return response()->json([
                'success' => true,
                'data' => [
                    'patient' => $patient,
                    'opd_visits' => $opdVisits,
                    'ipd_admissions' => $ipdAdmissions,
                    'diagnosis_history' => $consultations,
                    'medication_history' => $consultationMedicines,
                    'allergies' => $allergies,
                    'chronic_conditions' => $chronicConditions,
                    'surgery_history' => $surgeries,
                ]
            ]);
        }

        // Web Response
        return view(
            'admin.patients.medical_history_mgt.show',
            compact(
                'patient',
                'opdVisits',
                'ipdAdmissions',
                'consultations',
                'consultationMedicines',
                'allergies',
                'chronicConditions',
                'surgeries'
            )
        );
    }
}
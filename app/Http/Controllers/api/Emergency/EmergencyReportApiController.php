<?php

namespace App\Http\Controllers\Api\Emergency;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PreOperative;
use App\Models\EmergencyCase;
use Carbon\Carbon;

class EmergencyReportApiController extends Controller
{
    /**
     * 🔹 1. LIST EMERGENCY CASES (NOT ALL PATIENTS)
     */
    public function index()
    {
        $cases = EmergencyCase::with('patient')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $cases->map(function ($case) {
                return [
                    'case_id' => $case->id,
                    'patient_id' => $case->patient_id,
                    'patient_name' => $case->patient_name,
                    'patient_code' => $case->patient?->patient_code,
                    'blood_group' => $case->patient?->blood_group,
                    'mobile' => $case->mobile,
                    'emergency_type' => $case->emergency_type,
                    'arrival_time' => $case->arrival_time,
                    'status' => 'emergency'
                ];
            })
        ]);
    }

    /**
     * 🔹 2. BASIC INFO (CASE BASED)
     */
    public function show($caseId)
    {
        $case = EmergencyCase::with('patient')->findOrFail($caseId);

        return response()->json([
            'status' => true,
            'data' => [
                'case_id' => $case->id,
                'patient_name' => $case->patient_name,
                'blood_group' => $case->patient?->blood_group,
                'mobile' => $case->mobile,
                'emergency_contact' => $case->patient?->emergency_contact,
            ]
        ]);
    }

    /**
     * 🔥 3. FULL EMERGENCY SNAPSHOT (BEST VERSION)
     */
    public function full($caseId)
    {
        $case = EmergencyCase::with('patient.medicalFlags')->findOrFail($caseId);

        $patient = $case->patient;

        // ❗ Handle direct entry (no patient)
        if (!$patient) {
            return response()->json([
                'status' => true,
                'data' => [
                    'patient' => [
                        'name' => $case->patient_name,
                        'blood_group' => null,
                        'mobile' => $case->mobile,
                        'age' => $case->age,
                    ],
                    'alerts' => [
                        'allergies' => [],
                        'chronic_conditions' => []
                    ],
                    'is_critical' => false
                ]
            ]);
        }

        // 🔹 1. Medical Flags
        $flagAllergies = $patient->medicalFlags
            ->where('type', 'allergy')
            ->map(function ($item) {
                return [
                    'title' => $item->title,
                    'severity' => $item->severity,
                    'source' => 'flag'
                ];
            });

        // 🔹 2. Surgery Allergies
        $surgeryAllergies = PreOperative::whereIn('surgery_id', function ($q) use ($patient) {
            $q->select('id')
              ->from('surgeries')
              ->where('patient_id', $patient->id);
        })->pluck('allergies')
          ->filter()
          ->map(function ($item) {
              return [
                  'title' => $item,
                  'severity' => null,
                  'source' => 'surgery'
              ];
          });

        // 🔹 3. Merge Allergies
        $allergies = $flagAllergies
            ->merge($surgeryAllergies)
            ->unique('title')
            ->values();

        // 🔹 4. Chronic Conditions
        $chronic = $patient->medicalFlags
            ->where('type', 'chronic')
            ->map(function ($item) {
                return [
                    'title' => $item->title,
                    'severity' => $item->severity
                ];
            })
            ->values();

        return response()->json([
            'status' => true,
            'data' => [
                'case' => [
                    'id' => $case->id,
                    'type' => $case->emergency_type,
                    'arrival_time' => $case->arrival_time,
                ],

                'patient' => [
                    'id' => $patient->id,
                    'name' => $patient->first_name . ' ' . $patient->last_name,
                    'blood_group' => $patient->blood_group,
                    'mobile' => $patient->mobile,
                    'emergency_contact' => $patient->emergency_contact,
                    'age' => Carbon::parse($patient->date_of_birth)->age,
                ],

                'alerts' => [
                    'allergies' => $allergies,
                    'chronic_conditions' => $chronic,
                ],

                // 🔥 Smart critical logic
                'is_critical' => $allergies->count() > 0
            ]
        ]);
    }
}
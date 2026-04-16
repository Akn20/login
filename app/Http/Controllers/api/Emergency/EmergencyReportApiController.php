<?php

namespace App\Http\Controllers\Api\Emergency;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PreOperative;
use Carbon\Carbon;

class EmergencyReportApiController extends Controller
{
    /**
     * 🔹 1. List Patients (Emergency Access)
     */
    public function index()
    {
        $patients = Patient::select(
                'id',
                'patient_code',
                'first_name',
                'last_name',
                'blood_group',
                'mobile'
            )
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $patients
        ]);
    }

    /**
     * 🔹 2. Basic Emergency Info
     */
    public function show($patientId)
    {
        $patient = Patient::findOrFail($patientId);

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $patient->id,
                'patient_name' => $patient->first_name . ' ' . $patient->last_name,
                'blood_group' => $patient->blood_group,
                'mobile' => $patient->mobile,
                'emergency_contact' => $patient->emergency_contact,
                'age' => Carbon::parse($patient->date_of_birth)->age,
            ]
        ]);
    }

    /**
     * 🔥 3. FULL EMERGENCY SNAPSHOT (MAIN API)
     */
    public function full($patientId)
    {
        $patient = Patient::with('medicalFlags')->findOrFail($patientId);

        // 🔹 1. Medical Flags (Primary)
        $flagAllergies = $patient->medicalFlags
            ->where('type', 'allergy')
            ->map(function ($item) {
                return [
                    'title' => $item->title,
                    'severity' => $item->severity,
                    'source' => 'flag'
                ];
            });

        // 🔹 2. Surgery Allergies (Fallback)
        $surgeryAllergies = PreOperative::whereIn('surgery_id', function ($q) use ($patientId) {
            $q->select('id')
              ->from('surgeries')
              ->where('patient_id', $patientId);
        })->pluck('allergies')
          ->filter()
          ->map(function ($item) {
              return [
                  'title' => $item,
                  'severity' => null,
                  'source' => 'surgery'
              ];
          });

        // 🔹 3. Merge + Unique
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

                // 🔥 Important for UI / Mobile
                'is_critical' => $allergies->count() > 0
            ]
        ]);
    }
}
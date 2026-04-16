<?php

namespace App\Http\Controllers\Api\Emergency;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PreOperative;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmergencyReportApiController extends Controller
{
    /**
     * 🔹 List all emergency patients
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
     * 🔹 Basic Emergency Info
     */
    public function show($patientId)
    {
        $patient = Patient::findOrFail($patientId);

        return response()->json([
            'status' => true,
            'data' => [
                'patient_name' => $patient->first_name . ' ' . $patient->last_name,
                'blood_group' => $patient->blood_group,
                'mobile' => $patient->mobile,
                'emergency_contact' => $patient->emergency_contact,
            ]
        ]);
    }

    /**
     * 🔥 FULL EMERGENCY SNAPSHOT (MAIN API)
     */
    public function full($patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $allergies = PreOperative::where('surgery_id', function ($q) use ($patientId) {
            $q->select('id')
              ->from('surgeries')
              ->where('patient_id', $patientId)
              ->latest()
              ->limit(1);
        })->pluck('allergies');

        return response()->json([
            'status' => true,
            'data' => [
                'patient' => [
                    'name' => $patient->first_name . ' ' . $patient->last_name,
                    'blood_group' => $patient->blood_group,
                    'mobile' => $patient->mobile,
                    'age' => Carbon::parse($patient->date_of_birth)->age,
                ],
                'alerts' => [
                    'allergies' => $allergies->filter()->values(),
                    'chronic_conditions' => [] // future expansion
                ]
            ]
        ]);
    }
}
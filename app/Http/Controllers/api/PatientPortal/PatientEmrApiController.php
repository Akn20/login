<?php

namespace App\Http\Controllers\Api\PatientPortal;

use App\Http\Controllers\Controller;
use App\Models\IpdAdmission;
use App\Models\IpdDischarge;

class PatientEmrApiController extends Controller
{
    // 🔹 List all discharged patients
    public function index()
    {
        $ipds = IpdAdmission::with('patient')
            ->where('status', 'discharged')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Discharge list fetched successfully',
            'data' => $ipds
        ]);
    }

    // 🔹 Get single discharge summary
    public function show($ipd_id)
    {
        $ipd = IpdAdmission::with('patient')->find($ipd_id);

        if (!$ipd) {
            return response()->json([
                'status' => false,
                'message' => 'IPD not found'
            ], 404);
        }

        if ($ipd->status !== 'discharged') {
            return response()->json([
                'status' => false,
                'message' => 'Discharge not completed'
            ], 403);
        }

        $discharge = IpdDischarge::where('ipd_id', $ipd_id)->first();

        if (!$discharge) {
            return response()->json([
                'status' => false,
                'message' => 'Discharge summary not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Discharge summary fetched',
            'data' => [
                'patient_name' => $ipd->patient->first_name . ' ' . $ipd->patient->last_name,
                'admission_id' => $ipd->admission_id,
                'diagnosis' => $discharge->diagnosis,
                'treatment' => $discharge->treatment_given,
                'doctor_name' => $discharge->doctor_name,
                'discharge_date' => $discharge->date
            ]
        ]);
    }
}
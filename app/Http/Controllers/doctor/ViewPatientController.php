<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;   // IMPORTANT
use Illuminate\Http\Request;
use App\Models\Consultation; // IMPORTANT

class ViewPatientController extends Controller
{
    public function apiPatientProfile($patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $consultations = Consultation::with(['doctor', 'medicines'])
            ->where('patient_id', $patientId)
            ->latest('consultation_date')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Patient profile fetched successfully',
            'data' => [
                'patient' => $patient,
                'consultations' => $consultations
            ]
        ], 200);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class EmergencyRecordController extends Controller
{   
    public function show($id)
    {
        $patient = Patient::with('medicalFlags')->findOrFail($id);

        return response()->json([
            'patient_name' => $patient->first_name . ' ' . $patient->last_name,

            'blood_group' => $patient->blood_group ?? 'Not Available',

            'emergency_contact' => $patient->emergency_contact ?? 'Not Available',

            'allergies' => $patient->medicalFlags
                ->where('type', 'allergy')
                ->values(),

            'chronic_conditions' => $patient->medicalFlags
                ->where('type', 'chronic')
                ->values(),
        ]);
    }
    public function viewEmergency($id)
    {
        $patient = Patient::with('medicalFlags')->findOrFail($id);

        return view('admin.emergency-records.show', [
            'patient' => $patient,
            'allergies' => $patient->medicalFlags->where('type', 'allergy'),
            'chronic' => $patient->medicalFlags->where('type', 'chronic'),
        ]);
    }
    public function index()
    {
        $patients = Patient::latest()->get();

        return view('admin.emergency-records.index', compact('patients'));
    }
}
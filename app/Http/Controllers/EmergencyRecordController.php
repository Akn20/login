<?php

namespace App\Http\Controllers;

use App\Models\PreOperative;
use App\Models\Surgery;
use Illuminate\Http\Request;
use App\Models\Patient;

class EmergencyRecordController extends Controller
{   
    public function show($id)
{
    $patient = Patient::with('medicalFlags')->findOrFail($id);

    // 🔹 Get allergies from medical flags
    $flagAllergies = $patient->medicalFlags
        ->where('type', 'allergy')
        ->pluck('title');

    // 🔹 Get allergies from surgery (fallback)
    $surgeryAllergies = PreOperative::whereIn('surgery_id', function ($q) use ($id) {
        $q->select('id')
          ->from('surgeries')
          ->where('patient_id', $id);
    })->pluck('allergies');

    // 🔹 Merge both
    $allergies = $flagAllergies
        ->merge($surgeryAllergies)
        ->filter()
        ->unique()
        ->values();

    // 🔹 Chronic only from flags
    $chronic = $patient->medicalFlags
        ->where('type', 'chronic')
        ->pluck('title')
        ->values();

    return response()->json([
        'patient_name' => $patient->first_name . ' ' . $patient->last_name,
        'blood_group' => $patient->blood_group ?? 'Not Available',
        'emergency_contact' => $patient->emergency_contact ?? 'Not Available',
        'allergies' => $allergies,
        'chronic_conditions' => $chronic,
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
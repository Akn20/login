<?php

namespace App\Http\Controllers;

use App\Models\EmergencyCase;
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

        // 🔹 Medical flag allergies
        $flagAllergies = $patient->medicalFlags
            ->where('type', 'allergy');

        // 🔹 Pre-operative allergies (from surgeries)
        $surgeryAllergies = PreOperative::whereIn('surgery_id', function ($q) use ($id) {
            $q->select('id')
            ->from('surgeries')
            ->where('patient_id', $id);
        })->pluck('allergies');

        // 🔹 Merge both (IMPORTANT)
        $allergies = $flagAllergies
            ->pluck('title')
            ->merge($surgeryAllergies)
            ->filter()
            ->unique()
            ->values();

        // 🔹 Chronic
        $chronic = $patient->medicalFlags
            ->where('type', 'chronic');

        return view('admin.emergency-records.show', [
            'patient' => $patient,
            'allergies' => $allergies,
            'chronic' => $chronic,
        ]);
    }
  public function index()
{
    // 🔹 1. Emergency Cases
    $cases = EmergencyCase::with('patient')->get()->map(function ($case) {
        return [
            'source' => 'case',
            'id' => $case->id,
            'patient_id' => $case->patient_id,
            'patient_name' => $case->patient_name,
            'patient_code' => $case->patient?->patient_code,
            'blood_group' => $case->patient?->blood_group,
            'mobile' => $case->mobile,
            'type' => $case->emergency_type,
            'arrival_time' => $case->arrival_time,
            'badge' => '🚑 Emergency Case'
        ];
    });

    // 🔹 2. Surgery Emergencies
    $surgeries = Surgery::where('priority', 'Emergency')
        ->with('patient')
        ->get()
        ->map(function ($surgery) {
            return [
                'source' => 'surgery',
                'id' => $surgery->id,
                'patient_id' => $surgery->patient_id,
                'patient_name' => $surgery->patient?->first_name . ' ' . $surgery->patient?->last_name,
                'patient_code' => $surgery->patient?->patient_code,
                'blood_group' => $surgery->patient?->blood_group,
                'mobile' => $surgery->patient?->mobile,
                'type' => $surgery->surgery_type,
                'arrival_time' => $surgery->surgery_date,
                'badge' => '🟠 Surgery Emergency'
            ];
        });

    // 🔥 3. Merge both
    $records = collect($cases)
        ->merge($surgeries)
        ->sortByDesc('arrival_time')
        ->values();

    return view('admin.emergency-records.index', compact('records'));
}
}
<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Nurse\PatientMonitoringController;
use App\Http\Controllers\Admin\Nurse\NurseShiftsController;
use App\Models\DischargePreparation;
use App\Models\Patient;
use App\Models\Vital;
use App\Models\MedicationAdministration;
use App\Models\Discharge;
use Illuminate\Support\Facades\DB;

class NurseDashboardController extends Controller
{
     public function index()
    {
        $user = auth()->user();

$institutionId = $user->institution_id;

// Assigned patients (correct)
$patients = Patient::select('patients.*')
    ->addSelect([
        'latest_vital_time' => DB::table('vitals')
            ->select('created_at')
            ->whereColumn('vitals.patient_id', 'patients.id')
            ->orderByDesc('created_at')
            ->limit(1)
    ])
    ->get();

// Critical patients
$criticalPatients = Vital::where(function ($q) {
    $q->where('spo2', '<', 92)
      ->orWhere('blood_pressure_systolic', '>', 180)
      ->orWhere('blood_pressure_diastolic', '>', 110)
      ->orWhere('temperature', '>', 102)
      ->orWhere('pulse_rate', '>', 130);
})->distinct('patient_id')->count('patient_id');

// Pending medications
$pendingMedications = MedicationAdministration::where('status', 'pending')->count();

// Pending vitals
$pendingVitals = Patient::whereNotIn('id', function ($query) {
    $query->select('patient_id')
        ->from('vitals')
        ->where('recorded_at', '>=', now()->subHours(4));
})->count();

// Discharges
$discharges = DischargePreparation::whereDate('created_at', today())->count();

        return view('admin.nurse.dashboard', compact('patients', 'criticalPatients', 'pendingMedications', 'pendingVitals', 'discharges'));
    }
}
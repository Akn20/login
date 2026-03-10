<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;   // IMPORTANT
use Illuminate\Http\Request;
use App\Models\Consultation; // IMPORTANT

class ViewPatientController extends Controller
{
    public function viewPatientProfile($id)
    {
        $patient = Patient::findOrFail($id);

        $consultations = Consultation::with(['doctor', 'medicines'])
            ->where('patient_id', $id)
            ->latest()
            ->get();

        return view('doctor.opd.view-patient-profile', compact('patient', 'consultations'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;

class MedicalHistoryController extends Controller
{
    public function index()
    {
        return view('admin.patients.medical_history_mgt.index');
    }

    public function show($patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $opdVisits = Appointment::where('patient_id', $patientId)->get();

dd($opdVisits);
        return view(
            'admin.patients.medical_history_mgt.show',
            compact(
                'patient',
                'opdVisits'
            )
        );
    }
}
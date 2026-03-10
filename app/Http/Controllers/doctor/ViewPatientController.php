<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;   // IMPORTANT
use Illuminate\Http\Request;

class ViewPatientController extends Controller
{
    public function viewPatientProfile($id)
    {
        $patient = Patient::findOrFail($id);

        return view('doctor.opd.view-patient-profile', compact('patient'));
    }
}
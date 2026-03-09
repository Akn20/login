<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{

    /* =========================
       Open Consultation Page
    ==========================*/
    public function index($id)
    {
        // Dummy patient data (until patient module integration)
        $patient = (object)[
            'id' => $id,
            'name' => 'Ramesh Kumar',
            'age' => 35,
            'gender' => 'Male',
            'blood_group' => 'O+',
            'phone' => '9876543210'
        ];

        return view('doctor.opd.consultation', compact('patient'));
    }


    /* =========================
       Save Consultation
    ==========================*/
    public function store(Request $request)
    {

        // Validate doctor input
        $request->validate([
            'symptoms' => 'required',
            'diagnosis' => 'required'
        ]);

        // For now we only store in array (since DB not ready)
        $consultation = [
            'patient_id' => $request->patient_id,
            'doctor_id' => 1,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->medicine,
            'tests' => $request->tests,
            'consultation_date' => now()
        ];

        return redirect()->route('doctor.opd.summary')
                         ->with('consultation', $consultation);
    }


    /* =========================
       Consultation Summary
    ==========================*/
    public function summary()
    {
        $consultation = session('consultation');

        return view('doctor.opd.consultation-summary', compact('consultation'));
    }

}
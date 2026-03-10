<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Patient;

class ConsultationController extends Controller
{

    /* =========================
       Open Consultation Page
    ==========================*/
    public function index($id)
    {
        $patient = Patient::findOrFail($id);

        $medicines = Medicine::where('status', 1)->get();

        return view('doctor.opd.consultation', compact('patient','medicines'));
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
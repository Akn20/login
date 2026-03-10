<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Consultation;
class ConsultationController extends Controller
{

    /* =========================
       Open Consultation Page
    ==========================*/
    public function index($id)
    {
        // Fetch patient
        $patient = Patient::findOrFail($id);

        // Fetch today's appointment for this patient
        $appointment = Appointment::where('patient_id', $id)
            ->whereDate('appointment_date', today())
            ->first();

        // Fetch medicines
        $medicines = Medicine::where('status', 1)->get();

        return view('doctor.opd.consultation', compact('patient', 'medicines', 'appointment'));
    }


    /* =========================
       Save Consultation
    ==========================*/
    public function store(Request $request)
    {
        $request->validate([
            'symptoms' => 'required',
            'diagnosis' => 'required'
        ]);

        $appointment = Appointment::find($request->appointment_id);

        $consultation = Consultation::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'tests' => $request->tests,
            'consultation_date' => now()
        ]);
        $consultation->medicines()->attach([
            $request->medicine => [
                'dosage' => $request->dosage,
                'frequency' => $request->frequency,
                'duration' => $request->duration,
                'instructions' => $request->instructions
            ]
        ]);

        return redirect()->route('doctor.consultation-summary')
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

    public function viewConsultations()
    {
        $consultations = Consultation::with('patient')->latest()->get();

        return view('doctor.opd.view-consultations', compact('consultations'));
    }
}
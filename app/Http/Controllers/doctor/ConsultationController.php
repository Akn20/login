<?php

namespace App\Http\Controllers\Doctor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Staff;
use App\Models\Roles;
use App\Models\LabRequest;

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

        $doctorRole = Roles::where('name', 'doctor')->first();

        $doctors = Staff::where('role_id', $doctorRole->id)->get();

        return view('doctor.opd.consultation', compact('patient', 'medicines', 'appointment', 'doctors'));
    }


    /* =========================
       Save Consultation
    ==========================*/
    public function store(Request $request)
    {
        $request->validate([
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',

            'medicine' => 'required|array',
            'medicine.*' => 'required',

            'dosage' => 'required|array',
            'dosage.*' => 'required|string',

            'frequency' => 'required|array',
            'frequency.*' => 'required|string',

            'duration' => 'required|array',
            'duration.*' => 'required|string',

            'instructions' => 'required|array',
            'instructions.*' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        $appointment->update([
            'appointment_status' => 'Completed'
        ]);

        $consultation = Consultation::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'referral_doctor_id' => $request->referral_doctor_id,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'tests' => $request->tests,
            'consultation_date' => now()
        ]);
       foreach ($request->medicine as $index => $medicineId) {
            $consultation->medicines()->attach($medicineId, [
                'dosage' => $request->dosage[$index],
                'frequency' => $request->frequency[$index],
                'duration' => $request->duration[$index],
                'instructions' => $request->instructions[$index]
            ]);

        }

        //Labrequests
        if($request->tests){

            $tests = explode(',', $request->tests);

            foreach($tests as $test){

                LabRequest::create([
                    'patient_id' => $request->patient_id,
                    'consultation_id' => $consultation->id,
                    'test_name' => trim($test),
                    'status' => 'pending'
                ]);

            }

        }

        return redirect()->route('doctor.view-consultations')->with('success', 'Consultation saved successfully');

    }


    /* =========================
       Consultation Summary
    ==========================*/
    public function summary($id)
    {
        $consultation = Consultation::with(['patient', 'medicines'])
            ->findOrFail($id);

        return view('doctor.opd.consultation-summary', compact('consultation'));
    }

    public function viewConsultations()
    {
        $consultations = Consultation::with('patient')->latest()->get();

        return view('doctor.opd.view-consultations', compact('consultations'));
    }
    /* =========================
       Print Prescription
    ==========================*/

    public function printPrescription($id)
    {
        $consultation = Consultation::with(['patient', 'medicines', 'doctor'])
            ->findOrFail($id);

        return view('doctor.opd.print-prescription', compact('consultation'));
    }


    /* =========================
      API: List Consultations
    ==========================*/
    public function apiIndex()
    {
        return response()->json([
            'status' => true,
            'message' => 'Consultation list fetched successfully',
            'data' => Consultation::with(['patient'])->latest()->get()
        ]);
    }


    /* =========================
       Show Single Consultation
    ==========================*/
    public function apiShow($id)
    {
        $consultation = Consultation::with('patient')->find($id);

        if (!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'Consultation not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $consultation
        ]);
    }


    /* =========================
       Store Consultation
    ==========================*/
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'tests' => 'nullable|string'
        ]);

        $consultation = Consultation::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'symptoms' => $validated['symptoms'],
            'diagnosis' => $validated['diagnosis'],
            'tests' => $validated['tests'] ?? null,
            'consultation_date' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Consultation created successfully',
            'data' => $consultation->load('patient')
        ], 201);
    }


    /* =========================
       Update Consultation
    ==========================*/
    public function apiUpdate(Request $request, $id)
    {
        $consultation = Consultation::find($id);

        if (!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'Consultation not found'
            ], 404);
        }

        $validated = $request->validate([
            'symptoms' => 'sometimes|string',
            'diagnosis' => 'sometimes|string',
            'tests' => 'sometimes|nullable|string'
        ]);

        $consultation->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Consultation updated successfully',
            'data' => $consultation->load('patient')
        ]);
    }


    /* =========================
       Delete Consultation
    ==========================*/
    public function apiDelete($id)
    {
        $consultation = Consultation::find($id);

        if (!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'Consultation not found'
            ], 404);
        }

        $consultation->delete();

        return response()->json([
            'status' => true,
            'message' => 'Consultation deleted successfully'
        ]);
    }


    /* =========================
       Consultation Summary
    ==========================*/
    public function apiSummary($id)
    {
        $consultation = Consultation::with('patient')->find($id);

        if (!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'Consultation not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Consultation summary fetched successfully',
            'data' => $consultation
        ]);
    }

}

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
use Illuminate\Support\Str;

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
        $tests = is_array($request->tests)
            ? implode(',', $request->tests)
            : $request->tests;

        $consultation = Consultation::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'referral_doctor_id' => $request->referral_doctor_id,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'tests' => $tests,
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

        // Labrequests
        if (!empty($request->tests)) {

            $tests = [];

            foreach ($request->tests as $testInput) {

                $splitTests = explode(',', $testInput);

                foreach ($splitTests as $test) {

                    $test = trim($test);

                    if ($test !== '') {
                        $tests[] = $test;
                    }
                }
            }

            foreach ($tests as $test) {

                LabRequest::create([
                    'id' => Str::uuid(),
                    'patient_id' => $request->patient_id,
                    'consultation_id' => $consultation->id,
                    'test_name' => $test,
                    'status' => 'pending'
                ]);

            }

        }

        return redirect()->route('doctor.view-consultations')->with('success', 'Consultation saved successfully');

    }
    // =========================
// Edit Consultation
// =========================
    public function edit($id)
    {
        $consultation = Consultation::with(['medicines', 'labRequests'])->findOrFail($id);

        $patient = Patient::find($consultation->patient_id);

        $medicines = Medicine::all();

        $doctorRole = Roles::where('name', 'doctor')->first();

        $doctors = Staff::where('role_id', $doctorRole->id)->get();

        return view(
            'doctor.opd.edit-consultation',
            compact('consultation', 'patient', 'medicines', 'doctors')
        );
    }
    // =========================
// Update Consultation
// =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'symptoms' => 'required',
            'diagnosis' => 'required',
            'medicine.*' => 'required',
            'dosage.*' => 'required',
            'frequency.*' => 'required',
            'duration.*' => 'required',
            'instructions.*' => 'required'
        ]);

        $consultation = Consultation::findOrFail($id);
        $tests = is_array($request->tests)
            ? implode(',', $request->tests)
            : $request->tests;
        $consultation->update([
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'tests' => $tests,
            'referral_doctor_id' => $request->referral_doctor_id
        ]);
        LabRequest::where('consultation_id', $consultation->id)->delete();

        // Labrequests
        if (!empty($request->tests)) {

            $tests = [];

            foreach ($request->tests as $testInput) {

                $splitTests = explode(',', $testInput);

                foreach ($splitTests as $test) {

                    $test = trim($test);

                    if ($test !== '') {
                        $tests[] = $test;
                    }
                }
            }

            foreach ($tests as $test) {

                LabRequest::create([
                    'id' => Str::uuid(),
                    'patient_id' => $consultation->patient_id,
                    'consultation_id' => $consultation->id,
                    'test_name' => $test,
                    'status' => 'pending'
                ]);

            }

        }

        // update prescription
        $consultation->medicines()->detach();

        foreach ($request->medicine as $index => $medicine) {

            if ($medicine) {

                $consultation->medicines()->attach($medicine, [
                    'dosage' => $request->dosage[$index],
                    'frequency' => $request->frequency[$index],
                    'duration' => $request->duration[$index],
                    'instructions' => $request->instructions[$index]
                ]);

            }

        }

        return redirect()
            ->route('doctor.view-consultations')
            ->with('success', 'Consultation updated successfully');
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
            'data' => Consultation::with(['patient', 'doctor', 'medicines'])
                ->latest()
                ->get()
        ]);
    }


    /* =========================
       Show Single Consultation
    ==========================*/
    public function apiShow($id)
    {
        $consultation = Consultation::with(['patient', 'medicines'])->find($id);

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
            'appointment_id' => 'required|exists:appointments,id',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'tests' => 'nullable|string',
            'referral_doctor_id' => 'nullable|exists:staff,id',

            'medicines' => 'nullable|array',
            'medicines.*.medicine' => 'required_with:medicines',
            'medicines.*.dosage' => 'nullable|string',
            'medicines.*.frequency' => 'nullable|string',
            'medicines.*.duration' => 'nullable|string',
            'medicines.*.instructions' => 'nullable|string'
        ]);

        // Get appointment
        $appointment = Appointment::findOrFail($validated['appointment_id']);

        // Mark appointment completed
        $appointment->update([
            'appointment_status' => 'Completed'
        ]);

        // Create consultation
        $consultation = Consultation::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $appointment->doctor_id,
            'referral_doctor_id' => $request->referral_doctor_id,
            'symptoms' => $validated['symptoms'],
            'diagnosis' => $validated['diagnosis'],
            'tests' => $validated['tests'] ?? null,
            'consultation_date' => now()
        ]);
        // Save Lab Requests
        $tests = is_array($request->tests)
            ? $request->tests
            : explode(',', $request->tests);

        foreach ($tests as $test) {

            $test = trim($test);

            if ($test !== '') {
                LabRequest::create([
                    'id' => Str::uuid(),
                    'patient_id' => $request->patient_id,
                    'consultation_id' => $consultation->id,
                    'test_name' => $test,
                    'status' => 'pending'
                ]);
            }
        }

        // Save medicines
        if ($request->medicines) {

            foreach ($request->medicines as $medicine) {

                $consultation->medicines()->attach($medicine['medicine'], [
                    'dosage' => $medicine['dosage'] ?? null,
                    'frequency' => $medicine['frequency'] ?? null,
                    'duration' => $medicine['duration'] ?? null,
                    'instructions' => $medicine['instructions'] ?? null
                ]);

            }

        }

        return response()->json([
            'status' => true,
            'message' => 'Consultation created successfully',
            'data' => $consultation->load(['patient', 'medicines'])
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
        if (!empty($validated['tests'])) {

            LabRequest::where('consultation_id', $consultation->id)->delete();

            $tests = explode(',', $validated['tests']);

            foreach ($tests as $test) {

                LabRequest::create([
                    'id' => Str::uuid(),
                    'patient_id' => $consultation->patient_id,
                    'consultation_id' => $consultation->id,
                    'test_name' => trim($test),
                    'status' => 'pending'
                ]);

            }

        }

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
        $consultation = Consultation::with([
            'patient',
            'doctor',
            'medicines',
            'referralDoctor'
        ])->find($id);

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
    public function apiPrescriptions($id)
    {
        $consultation = Consultation::with('medicines')->find($id);

        if (!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'Consultation not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Prescriptions fetched successfully',
            'data' => $consultation->medicines
        ]);
    }
    public function apiTests($id)
    {
        $consultation = Consultation::find($id);

        if (!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'Consultation not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Tests fetched successfully',
            'data' => $consultation->tests
        ]);
    }
    public function apiPatientHistory($patientId)
    {
        $consultations = Consultation::with([
            'patient',
            'doctor',
            'medicines'
        ])
            ->where('patient_id', $patientId)
            ->latest('consultation_date')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $consultations
        ]);
    }
    public function apiReferral($id)
    {
        $consultation = Consultation::with('referralDoctor')->find($id);

        if (!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'Consultation not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Referral doctor fetched successfully',
            'data' => $consultation->referralDoctor
        ]);
    }
    public function apiMedicines()
    {
        $medicines = Medicine::select('id', 'medicine_name')
            ->where('status', 1)
            ->get();

        return response()->json($medicines);
    }


}

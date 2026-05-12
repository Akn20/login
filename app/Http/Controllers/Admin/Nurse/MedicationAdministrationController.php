<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MedicationAdministration;

class MedicationAdministrationController extends Controller
{

    // 🔷 INDEX (Load page + medications)
    public function index(Request $request)
    {
        $patients = DB::table('patients')->whereNull('deleted_at')->get();

        $medications = [];

        if ($request->patient_id) {

            $patient = DB::table('patients')
                ->where('id', $request->patient_id)
                ->first();

            if ($patient) {

                $fullName = trim($patient->first_name . ' ' . $patient->last_name);

                $medications = DB::table('offline_prescription_items as items')
                    ->join('offline_prescriptions as p', 'items.offline_prescription_id', '=', 'p.id')

                    ->leftJoin('medication_administration as m', function ($join) {
                        $join->on('items.id', '=', 'm.prescription_item_id')
                            ->whereNull('m.deleted_at');
                    })

                    ->where('p.patient_name', $fullName)

                    ->select(
                        'items.*',
                        'm.status',
                        'm.administered_time'
                    )
                    ->get();
            }
        }

        return view('admin.nurse.medicationAdministration.index', compact('patients', 'medications'));
    }


    // 🔷 ADMINISTER MEDICATION
    public function administer(Request $request)
    {
        $request->validate([
            'prescription_item_id' => 'required'
        ]);

        $existing = MedicationAdministration::where('prescription_item_id', $request->prescription_item_id)
            ->whereNull('deleted_at')
            ->first();

        if ($existing && $existing->status == 'administered') {
            return back()->with('error', 'Already administered');
        }

        // 🔹 Get patient_name
        $patientName = DB::table('offline_prescription_items')
            ->join('offline_prescriptions', 'offline_prescription_items.offline_prescription_id', '=', 'offline_prescriptions.id')
            ->where('offline_prescription_items.id', $request->prescription_item_id)
            ->value('offline_prescriptions.patient_name');

        // 🔹 Convert to patient_id
        $patient = DB::table('patients')
            ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), $patientName)
            ->first();

        MedicationAdministration::updateOrCreate(
            [
                'prescription_item_id' => $request->prescription_item_id
            ],
            [
                'patient_id' => $patient ? $patient->id : null,
                'nurse_id' => 1, // ✅ store staff.id here
                'administered_time' => now(),
                'status' => 'administered'
            ]
        );

        return back()->with('success', 'Medication administered successfully');
    }


    // 🔷 MARK AS MISSED
    public function markMissed(Request $request)
    {
        $request->validate([
            'prescription_item_id' => 'required'
        ]);

        $existing = MedicationAdministration::where('prescription_item_id', $request->prescription_item_id)
            ->whereNull('deleted_at')
            ->first();

        if ($existing && $existing->status == 'administered') {
            return back()->with('error', 'Already administered, cannot mark missed');
        }

        // 🔹 Get patient_name
        $patientName = DB::table('offline_prescription_items')
            ->join('offline_prescriptions', 'offline_prescription_items.offline_prescription_id', '=', 'offline_prescriptions.id')
            ->where('offline_prescription_items.id', $request->prescription_item_id)
            ->value('offline_prescriptions.patient_name');

        // 🔹 Convert to patient_id
        $patient = DB::table('patients')
            ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), $patientName)
            ->first();

        MedicationAdministration::updateOrCreate(
            [
                'prescription_item_id' => $request->prescription_item_id
            ],
            [
                'patient_id' => $patient ? $patient->id : null,
                'nurse_id' => 1, // ✅ store staff.id here
                'status' => 'missed'
            ]
        );

        return back()->with('success', 'Medication marked as missed');
    }

    // ==================== API METHODS ====================

    public function apiIndex()
    {
        return response()->json([
            'data' => MedicationAdministration::with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    public function apiShow($id)
    {
        $medication = MedicationAdministration::with(['patient', 'nurse'])
            ->whereNull('deleted_at')
            ->find($id);

        if (!$medication) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => $medication]);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'prescription_item_id' => 'required',
            'status' => 'required|in:pending,administered,missed,skipped,refused',
            'nurse_id' => 'nullable|numeric',
            'administered_time' => 'nullable|date_format:Y-m-d H:i:s',
            'notes' => 'nullable|string'
        ]);

        // If nurse_id is not provided or invalid, find the first nurse user
        if (!isset($validated['nurse_id']) || !$validated['nurse_id']) {
            // Try to get the first user with nurse role, or fallback to user ID 1
            $nurse = DB::table('users')->first();
            $validated['nurse_id'] = $nurse ? $nurse->id : 1;
        }

        $medication = MedicationAdministration::create($validated);

        return response()->json(['data' => $medication->load(['patient', 'nurse'])], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $medication = MedicationAdministration::whereNull('deleted_at')->find($id);

        if (!$medication) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validated = $request->validate([
            'status' => 'sometimes|in:pending,administered,skipped,refused',
            'notes' => 'nullable|string'
        ]);

        $medication->update($validated);

        return response()->json(['data' => $medication->load(['patient', 'nurse'])]);
    }

    public function apiDestroy($id)
    {
        $medication = MedicationAdministration::whereNull('deleted_at')->find($id);

        if (!$medication) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $medication->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function apiTrash()
    {
        return response()->json([
            'data' => MedicationAdministration::whereNotNull('deleted_at')->get()
        ]);
    }

    public function apiRestore($id)
    {
        $medication = MedicationAdministration::whereNotNull('deleted_at')->find($id);

        if (!$medication) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $medication->restore();

        return response()->json(['message' => 'Restored successfully']);
    }

    public function apiForceDelete($id)
    {
        $medication = MedicationAdministration::withTrashed()->find($id);

        if (!$medication) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $medication->forceDelete();

        return response()->json(['message' => 'Permanently deleted']);
    }

    public function apiGetByPatient($patientId)
    {
        return response()->json([
            'data' => MedicationAdministration::where('patient_id', $patientId)
                ->with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    public function apiGetByNurse($nurseId)
    {
        return response()->json([
            'data' => MedicationAdministration::where('nurse_id', $nurseId)
                ->with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    public function apiGetByStatus($status)
    {
        return response()->json([
            'data' => MedicationAdministration::where('status', $status)
                ->with(['patient', 'nurse'])
                ->whereNull('deleted_at')
                ->get()
        ]);
    }

    // 🔷 GET PRESCRIPTIONS FOR PATIENT (Mobile App Workflow)
    public function apiPrescriptionsByPatient($patientId)
    {
        $patient = DB::table('patients')
            ->where('id', $patientId)
            ->first();

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $fullName = trim($patient->first_name . ' ' . $patient->last_name);

        $prescriptions = DB::table('offline_prescription_items as items')
            ->join('offline_prescriptions as p', 'items.offline_prescription_id', '=', 'p.id')
            ->leftJoin('medication_administration as m', function ($join) {
                $join->on('items.id', '=', 'm.prescription_item_id')
                    ->whereNull('m.deleted_at');
            })
            ->where('p.patient_name', $fullName)
            ->select(
                'items.id as prescription_item_id',
                'items.medicine_name',
                'items.dosage',
                'items.frequency',
                'items.duration',
                'items.instructions',
                'm.id as medication_id',
                'm.status',
                'm.administered_time',
                'm.notes'
            )
            ->get();

        return response()->json([
            'data' => $prescriptions,
            'patient' => $patient
        ]);
    }

    // 🔷 GET ALL PATIENTS
    public function apiGetPatients()
    {
        $patients = DB::table('patients')
            ->whereNull('deleted_at')
            ->select('id', 'first_name', 'last_name', 'patient_code')
            ->get()
            ->map(function ($patient) {
                $patient->name = trim($patient->first_name . ' ' . $patient->last_name);
                return $patient;
            });

        return response()->json(['data' => $patients]);
    }
}
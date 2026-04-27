<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\IpdAdmission;
use App\Models\IpdNote;
use App\Models\IpdTreatment;
use App\Models\IpdPrescription;
use App\Models\IpdPrescriptionItem;
use App\Models\IpdDischarge;
use App\Models\Medicine;
use App\Models\ScanType;

class IpdController extends Controller
{
    // ✅ 1. INDEX
    public function index()
    {
        $patients = IpdAdmission::with(['patient', 'ward', 'bed'])->get();

        return view('doctor.ipd.index', compact('patients'));
    }

    // ✅ 2. SHOW
 public function show($id)
{
    $ipd = IpdAdmission::with(['patient','ward','bed'])->findOrFail($id);

    $notes = IpdNote::where('ipd_id', $id)->latest()->get();

    $treatment = IpdTreatment::where('ipd_id', $id)->first();

    // ✅ FIXED (NO MIXING ISSUE)
    $prescriptionItems = DB::table('ipd_prescription_items')
        ->join('ipd_prescriptions', 'ipd_prescription_items.prescription_id', '=', 'ipd_prescriptions.id')
        ->where('ipd_prescriptions.ipd_id', $id)
        ->select('ipd_prescription_items.*')
        ->get();

    $labTests = DB::table('lab_requests')
        ->where('consultation_id', $id)
        ->get();

    $scans = DB::table('scan_requests')
        ->join('scan_types', 'scan_requests.scan_type_id', '=', 'scan_types.id')
        ->where('scan_requests.patient_id', $ipd->patient_id)
        ->select('scan_types.name', 'scan_requests.status')
        ->get();

    $medicines = Medicine::where('status', 1)->get();

    $scanTypes = ScanType::where('status', 'Active')->get();

    return view('doctor.ipd.show', compact(
        'ipd',
        'notes',
        'treatment',
        'prescriptionItems',
        'labTests',
        'scans',
        'medicines',
        'scanTypes'
    ));
}

    // ✅ 3. STORE NOTE
    public function storeNote(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string'
        ]);

        IpdNote::create([
            'ipd_id' => $id,
            'doctor_id' => auth()->id(),
            'notes' => $request->notes
        ]);

        return back()->with('success', 'Note added');
    }

    // ✅ 4. UPDATE TREATMENT
    public function updateTreatment(Request $request, $id)
    {
        $request->validate([
            'treatment' => 'nullable|string'
        ]);

        IpdTreatment::updateOrCreate(
            ['ipd_id' => $id],
            ['treatment' => $request->treatment]
        );

        return back()->with('success', 'Treatment updated');
    }

    // ✅ 5. STORE PRESCRIPTION
public function storePrescription(Request $request, $id)
{
    $request->validate([
        'medicine_id' => 'required|array',
        'medicine_id.*' => 'required'
    ]);

    $ipd = IpdAdmission::findOrFail($id);

    // ✅ INSERT PRESCRIPTION
    $prescriptionId = (string) Str::uuid();

    DB::table('ipd_prescriptions')->insert([
        'id' => $prescriptionId,
        'ipd_id' => $id,
        'patient_id' => $ipd->patient_id,
        'doctor_id' => auth()->id(),
        'prescription_date' => now(),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // ✅ INSERT ITEMS
    foreach ($request->medicine_id as $key => $medicineId) {

        if (!$medicineId) continue;

        $medicine = Medicine::find($medicineId);
        if (!$medicine) continue;

        DB::table('ipd_prescription_items')->insert([
            'id' => (string) Str::uuid(), // 🔥 MUST
            'prescription_id' => $prescriptionId, // 🔥 MUST MATCH
            'medicine_name' => $medicine->medicine_name,
            'dosage' => $request->dosage[$key] ?? null,
            'frequency' => $request->frequency[$key] ?? null,
            'duration' => $request->duration[$key] ?? null,
            'instructions' => $request->instructions[$key] ?? null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    return back()->with('success', 'Prescription added successfully');
}

    // ✅ 6. LAB + RADIOLOGY (COMBINED)
    public function storeLabRadiology(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:lab,radiology'
        ]);

        if ($request->type == 'lab') {

            DB::table('lab_requests')->insert([
                'id' => (string) Str::uuid(),
                'patient_id' => $request->patient_id,
                'consultation_id' => $id,
                'test_name' => $request->test_name,
                'priority' => $request->lab_priority ?? 'routine',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

        } elseif ($request->type == 'radiology') {

            DB::table('scan_requests')->insert([
                'id' => (string) Str::uuid(),
                'patient_id' => $request->patient_id,
                'doctor_id' => auth()->id(),
                'scan_type_id' => $request->scan_type_id,
                'body_part' => $request->body_part,
                'reason' => $request->reason,
                'priority' => $request->scan_priority ?? 'Normal',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return back()->with('success', 'Request added successfully');
    }

    // ✅ 7. DISCHARGE FORM
    public function dischargeForm($id)
    {
        $ipd = IpdAdmission::with('patient')->findOrFail($id);

        $discharge = IpdDischarge::where('ipd_id', $id)->first();

        return view('doctor.ipd.discharge', compact('ipd', 'discharge'));
    }

    // ✅ 8. SUBMIT DISCHARGE
    public function dischargeSubmit(Request $request, $id)
    {
        $ipd = IpdAdmission::findOrFail($id);

        // 🔒 Prevent double discharge
        if ($ipd->status == 'discharged') {
            return back()->with('error', 'Patient already discharged');
        }

        $request->validate([
            'diagnosis' => 'nullable|string',
            'treatment_given' => 'nullable|string',
            'medication_advice' => 'nullable|string',
            'follow_up' => 'nullable|string',
            'doctor_name' => 'nullable|string',
            'date' => 'nullable|date'
        ]);

        IpdDischarge::create([
            'ipd_id' => $id,
            'diagnosis' => $request->diagnosis,
            'treatment_given' => $request->treatment_given,
            'medication_advice' => $request->medication_advice,
            'follow_up' => $request->follow_up,
            'doctor_name' => $request->doctor_name,
            'date' => $request->date
        ]);

        $ipd->update([
            'status' => 'discharged',
            'discharge_date' => now()
        ]);

        return redirect()->route('doctor.ipd.index')
            ->with('success', 'Patient discharged successfully');
    }


//API Functions
// ======================================
// API 1. IPD LIST
// ======================================
public function apiIndex()
{
    $patients = IpdAdmission::with(['patient', 'ward', 'bed'])->get();

    return response()->json([
        'status' => true,
        'message' => 'IPD patient list fetched successfully',
        'data' => $patients
    ]);
}


// ======================================
// API 2. IPD DETAILS
// ======================================
public function apiShow($id)
{
    $ipd = IpdAdmission::with(['patient', 'ward', 'bed'])->find($id);

    if (!$ipd) {
        return response()->json([
            'status' => false,
            'message' => 'IPD patient not found'
        ], 404);
    }

    $notes = IpdNote::where('ipd_id', $id)->latest()->get();

    $treatment = IpdTreatment::where('ipd_id', $id)->first();

    // ✅ FIXED PRESCRIPTION
    $prescriptionIds = IpdPrescription::where('ipd_id', $id)->pluck('id');

   $prescriptionItems = DB::table('ipd_prescription_items')
    ->join('ipd_prescriptions', 'ipd_prescription_items.prescription_id', '=', 'ipd_prescriptions.id')
    ->where('ipd_prescriptions.ipd_id', $id) // 🔥 IMPORTANT
    ->select('ipd_prescription_items.*')
    ->get();

    // ✅ LAB
    $labTests = DB::table('lab_requests')
        ->where('consultation_id', $id)
        ->get();

    // ✅ RADIOLOGY
    $scans = DB::table('scan_requests')
        ->where('patient_id', $ipd->patient_id)
        ->get();

    return response()->json([
        'status' => true,
        'message' => 'IPD details fetched successfully',
        'data' => [
            'ipd' => $ipd,
            'notes' => $notes,
            'treatment' => $treatment,
            'prescription' => $prescriptionItems, // ✅ correct
            'lab_tests' => $labTests,
            'radiology' => $scans
        ]
    ]);
}

//
// ======================================
// API 3. ADD NOTE
// ======================================
public function apiStoreNote(Request $request, $id)
{
    $request->validate([
        'notes' => 'required|string'
    ]);

    IpdNote::create([
        'ipd_id' => $id,
        'doctor_id' => $request->doctor_id,
        'notes' => $request->notes
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Note added successfully'
    ]);
}

//
// ======================================
// API 4. UPDATE TREATMENT
// ======================================
public function apiUpdateTreatment(Request $request, $id)
{
    IpdTreatment::updateOrCreate(
        ['ipd_id' => $id],
        ['treatment' => $request->treatment]
    );

    return response()->json([
        'status' => true,
        'message' => 'Treatment updated successfully'
    ]);
}

//
// ======================================
// API 5. ADD PRESCRIPTION
// ======================================
public function apiStorePrescription(Request $request, $id)
{
    // ✅ VALIDATION
    $request->validate([
        'medicine_id' => 'required|array',
        'medicine_id.*' => 'required'
    ]);

    // ✅ GET IPD
    $ipd = DB::table('ipd_admissions')->where('id', $id)->first();

    if (!$ipd) {
        return response()->json([
            'status' => false,
            'message' => 'IPD not found'
        ], 404);
    }

    // ✅ GET DOCTOR FROM STAFF TABLE
    $staff = DB::table('staff')->where('id', $ipd->doctor_id)->first();
    $doctorId = $staff->user_id ?? null;

    // ✅ CREATE PRESCRIPTION
    $prescription = IpdPrescription::create([
        'id' => (string) Str::uuid(),
        'ipd_id' => $id,
        'patient_id' => $ipd->patient_id,
        'doctor_id' => $doctorId,
        'prescription_date' => now()
    ]);

    // ✅ STORE ITEMS
    foreach ($request->medicine_id as $key => $medicineId) {

        // 🚫 skip empty
        if (!$medicineId) continue;

        $medicine = Medicine::find($medicineId);

        // 🚫 skip invalid
        if (!$medicine) continue;

        IpdPrescriptionItem::create([
            'prescription_id' => $prescription->id,
            'medicine_name' => $medicine->medicine_name,
            'dosage' => $request->dosage[$key] ?? null,
            'frequency' => $request->frequency[$key] ?? null,
            'duration' => $request->duration[$key] ?? null,
            'instructions' => $request->instructions[$key] ?? null,
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Prescription added successfully'
    ]);
}

//
// ======================================
// API 6. LAB + RADIOLOGY
// ======================================
public function apiStoreLabRadiology(Request $request, $id)
{
    $ipd = DB::table('ipd_admissions')->where('id', $id)->first();

    if (!$ipd) {
        return response()->json([
            'status' => false,
            'message' => 'IPD not found'
        ], 404);
    }

    // ================= LAB =================
    if ($request->type == 'lab') {

        DB::table('lab_requests')->insert([
            'id' => (string) Str::uuid(),
            'patient_id' => $ipd->patient_id,
            'consultation_id' => $id, // ✅ IMPORTANT
            'test_name' => $request->test_name,
            'priority' => $request->priority ?? 'routine',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Lab test added successfully'
        ]);
    }

    // ================= RADIOLOGY =================
    if ($request->type == 'radiology') {

        $staff = DB::table('staff')->where('id', $ipd->doctor_id)->first();

        if (!$staff) {
            return response()->json([
                'status' => false,
                'message' => 'Doctor staff not found'
            ], 400);
        }

        $userId = $staff->user_id;

        DB::table('scan_requests')->insert([
            'id' => (string) Str::uuid(),
            'patient_id' => $ipd->patient_id,
            'doctor_id' => $userId,
            'scan_type_id' => $request->scan_type_id,
            'body_part' => $request->body_part,
            'reason' => $request->reason,
            'priority' => $request->priority ?? 'Normal',
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Radiology request added successfully'
        ]);
    }
}

//
// ======================================
// API 7. DISCHARGE DETAILS
// ======================================
public function apiDischargeDetails($id)
{
    $discharge = IpdDischarge::where('ipd_id', $id)->first();

    return response()->json([
        'status' => true,
        'message' => 'Discharge details fetched successfully',
        'data' => $discharge
    ]);
}

//
// ======================================
// API 8. SUBMIT DISCHARGE
// ======================================
public function apiDischargeSubmit(Request $request, $id)
{
    // ✅ Get IPD record
    $ipd = DB::table('ipd_admissions')->where('id', $id)->first();

    if (!$ipd) {
        return response()->json([
            'status' => false,
            'message' => 'IPD not found'
        ], 404);
    }

    // ✅ Get doctor from IPD
    $doctor = DB::table('users')->where('id', $ipd->doctor_id)->first();

    // ✅ Insert discharge summary
   DB::table('ipd_discharges')->insert([
    'id' => (string) Str::uuid(),
    'ipd_id' => $id, // ✅ IMPORTANT (use this instead of patient_id)
    'diagnosis' => $request->diagnosis,
    'treatment_given' => $request->treatment_given,
    'medication_advice' => $request->medication_advice,
    'follow_up' => $request->follow_up,
    'doctor_name' => $doctor->name ?? 'Doctor',
    'date' => now(),
    'created_at' => now(),
    'updated_at' => now(),
]);

    // ✅ Update IPD status
    DB::table('ipd_admissions')
        ->where('id', $id)
        ->update([
            'status' => 'discharged',
            'discharge_date' => now()
        ]);

    return response()->json([
        'status' => true,
        'message' => 'Patient discharged successfully'
    ]);
}
public function apiMedicines()
{
    return response()->json([
        'status' => true,
        'data' => \App\Models\Medicine::where('status', 1)->get(),
    ]);
}
public function apiScanTypes()
{
    return response()->json([
        'status' => true,
        'data' => \App\Models\ScanType::where('status', 1)->get()
    ]);
}
public function apiLabTests()
{
    return response()->json([
        'status' => true,
        'data' => \App\Models\LabTest::where('status', 1)->get()
    ]);
}
}
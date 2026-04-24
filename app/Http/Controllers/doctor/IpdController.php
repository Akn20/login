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

        $prescription = IpdPrescription::where('ipd_id', $id)->latest()->first();

        $prescriptionItems = $prescription
            ? IpdPrescriptionItem::where('prescription_id', $prescription->id)->get()
            : collect();

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
            'ipd','notes','treatment','prescription','prescriptionItems',
            'labTests','scans','medicines','scanTypes'
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
            'medicine_id' => 'required|array'
        ]);

        $prescription = IpdPrescription::create([
            'ipd_id' => $id,
            'patient_id' => $request->patient_id,
            'doctor_id' => auth()->id(),
            'prescription_date' => now()
        ]);

        foreach ($request->medicine_id as $key => $medicineId) {

            $medicine = Medicine::find($medicineId);

            IpdPrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medicine_name' => $medicine->medicine_name ?? 'Unknown',
                'dosage' => $request->dosage[$key] ?? null,
                'frequency' => $request->frequency[$key] ?? null,
                'duration' => $request->duration[$key] ?? null,
                'instructions' => $request->instructions[$key] ?? null,
            ]);
        }

        return back()->with('success', 'Prescription added');
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

    $prescription = IpdPrescription::where('ipd_id', $id)->latest()->first();

    $prescriptionItems = $prescription
        ? IpdPrescriptionItem::where('prescription_id', $prescription->id)->get()
        : [];

    $labTests = DB::table('lab_requests')
        ->where('consultation_id', $id)
        ->get();

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
            'prescription' => $prescriptionItems,
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
    $prescription = IpdPrescription::create([
        'ipd_id' => $id,
        'patient_id' => $request->patient_id,
        'doctor_id' => $request->doctor_id,
        'prescription_date' => now()
    ]);

    foreach ($request->medicine_id as $key => $medicineId) {

        $medicine = Medicine::find($medicineId);

        IpdPrescriptionItem::create([
            'prescription_id' => $prescription->id,
            'medicine_name' => $medicine->medicine_name ?? 'Unknown',
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
            'doctor_id' => $request->doctor_id,
            'scan_type_id' => $request->scan_type_id,
            'body_part' => $request->body_part,
            'reason' => $request->reason,
            'priority' => $request->scan_priority ?? 'Normal',
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Lab/Radiology request added successfully'
    ]);
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
    $ipd = IpdAdmission::find($id);

    if (!$ipd) {
        return response()->json([
            'status' => false,
            'message' => 'IPD patient not found'
        ], 404);
    }

    if ($ipd->status == 'discharged') {
        return response()->json([
            'status' => false,
            'message' => 'Patient already discharged'
        ]);
    }

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

    return response()->json([
        'status' => true,
        'message' => 'Patient discharged successfully'
    ]);
}

}
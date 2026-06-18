<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseSheet;
use App\Models\Patient;
use App\Models\Staff;

class CaseSheetApiController extends Controller
{
    // LIST
    public function index()
    {
        $caseSheets = CaseSheet::with([
            'patient',
            'doctor'
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $caseSheets
        ]);
    }

    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'visit_type' => 'required',
        ]);

        $caseSheet = CaseSheet::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'opd_id' => $request->opd_id,
            'ipd_id' => $request->ipd_id,
            'visit_type' => $request->visit_type,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'clinical_notes' => $request->clinical_notes,
            'status' => 'Active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Case Sheet Created Successfully',
            'data' => $caseSheet
        ]);
    }

    // SHOW SINGLE
    public function show($id)
    {
        $caseSheet = CaseSheet::with([
            'patient',
            'doctor'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $caseSheet
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $caseSheet = CaseSheet::findOrFail($id);

        $caseSheet->update([
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'clinical_notes' => $request->clinical_notes,
            'status' => $request->status ?? $caseSheet->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Case Sheet Updated Successfully',
            'data' => $caseSheet
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $caseSheet = CaseSheet::findOrFail($id);

        $caseSheet->delete();

        return response()->json([
            'success' => true,
            'message' => 'Case Sheet Deleted Successfully'
        ]);
    }

    // PATIENT DROPDOWN
    public function patients()
{
    $patients = Patient::where('status', 1)
        ->select(
            'id',
            'patient_code',
            'first_name',
            'last_name'
        )
        ->get();

    return response()->json([
        'success' => true,
        'data' => $patients
    ]);
}

public function doctors()
{
    $doctors = Staff::whereHas('designation', function ($query) {

        $query->where(
            'designation_name',
            'Doctor'
        );

    })
    ->where('status', 'Active')
    ->select('id', 'name')
    ->get();

    return response()->json([
        'success' => true,
        'data' => $doctors
    ]);
}
}
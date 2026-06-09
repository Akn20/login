<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\PrescriptionFormatSetting;
use Illuminate\Http\Request;

class PrescriptionFormatApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => PrescriptionFormatSetting::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paper_size' => 'required|in:A4,A5,Letter',
            'orientation' => 'required|in:Portrait,Landscape',
            'margins' => 'nullable|integer|min:0',
            'status' => 'nullable|in:Active,Inactive',
        ]);

        $format = PrescriptionFormatSetting::create([
            'hospital_id' => $request->hospital_id ?? 1,
            'hospital_logo' => $request->hospital_logo,
            'header_text' => $request->header_text,
            'footer_text' => $request->footer_text,

            'show_doctor_name' =>
                $request->boolean('show_doctor_name'),

            'show_doctor_qualification' =>
                $request->boolean('show_doctor_qualification'),

            'show_registration_number' =>
                $request->boolean('show_registration_number'),

            'show_patient_age' =>
                $request->boolean('show_patient_age'),

            'show_patient_gender' =>
                $request->boolean('show_patient_gender'),

            'show_date' =>
                $request->boolean('show_date'),

            'paper_size' => $request->paper_size,
            'orientation' => $request->orientation,
            'margins' => $request->margins ?? 10,
            'status' => $request->status ?? 'Active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Prescription Format Added Successfully',
            'data' => $format
        ], 201);
    }

    public function show($id)
    {
        $format = PrescriptionFormatSetting::find($id);

        if (!$format) {
            return response()->json([
                'success' => false,
                'message' => 'Prescription Format Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $format
        ]);
    }

    public function update(Request $request, $id)
    {
        $format = PrescriptionFormatSetting::find($id);

        if (!$format) {
            return response()->json([
                'success' => false,
                'message' => 'Prescription Format Not Found'
            ], 404);
        }

        $validated = $request->validate([
            'paper_size' => 'required|in:A4,A5,Letter',
            'orientation' => 'required|in:Portrait,Landscape',
            'margins' => 'nullable|integer|min:0',
            'status' => 'nullable|in:Active,Inactive',
        ]);

        $format->update([
            'hospital_logo' => $request->hospital_logo,
            'header_text' => $request->header_text,
            'footer_text' => $request->footer_text,

            'show_doctor_name' =>
                $request->boolean('show_doctor_name'),

            'show_doctor_qualification' =>
                $request->boolean('show_doctor_qualification'),

            'show_registration_number' =>
                $request->boolean('show_registration_number'),

            'show_patient_age' =>
                $request->boolean('show_patient_age'),

            'show_patient_gender' =>
                $request->boolean('show_patient_gender'),

            'show_date' =>
                $request->boolean('show_date'),

            'paper_size' => $request->paper_size,
            'orientation' => $request->orientation,
            'margins' => $request->margins,
            'status' => $request->status ?? 'Active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Prescription Format Updated Successfully',
            'data' => $format->fresh()
        ]);
    }

    public function destroy($id)
    {
        $format = PrescriptionFormatSetting::find($id);

        if (!$format) {
            return response()->json([
                'success' => false,
                'message' => 'Prescription Format Not Found'
            ], 404);
        }

        $format->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prescription Format Deleted Successfully'
        ]);
    }
}
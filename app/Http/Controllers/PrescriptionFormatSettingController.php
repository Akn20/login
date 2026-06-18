<?php

namespace App\Http\Controllers;

use App\Models\PrescriptionFormatSetting;
use Illuminate\Http\Request;

class PrescriptionFormatSettingController extends Controller
{
    public function index()
    {
        $formats = PrescriptionFormatSetting::all();

        return view(
            'admin.prescription_format_settings.index',
            compact('formats')
        );
    }

    public function create()
    {
        return view('admin.prescription_format_settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'paper_size' => 'required',
            'orientation' => 'required'
        ]);

        PrescriptionFormatSetting::create([
            'hospital_id' => 1,
            'hospital_logo' => $request->hospital_logo,
            'header_text' => $request->header_text,
            'footer_text' => $request->footer_text,
            'show_doctor_name' => $request->has('show_doctor_name'),
            'show_doctor_qualification' => $request->has('show_doctor_qualification'),
            'show_registration_number' => $request->has('show_registration_number'),
            'show_patient_age' => $request->has('show_patient_age'),
            'show_patient_gender' => $request->has('show_patient_gender'),
            'show_date' => $request->has('show_date'),
            'paper_size' => $request->paper_size,
            'orientation' => $request->orientation,
            'margins' => $request->margins,
            'status' => $request->status
        ]);

        return redirect()
            ->route('prescription-format-settings.index')
            ->with('success', 'Prescription Format Added Successfully');
    }

    public function show($id)
    {
        $format = PrescriptionFormatSetting::findOrFail($id);

        return view(
            'admin.prescription_format_settings.show',
            compact('format')
        );
    }

    public function edit($id)
    {
        $format = PrescriptionFormatSetting::findOrFail($id);

        return view(
            'admin.prescription_format_settings.edit',
            compact('format')
        );
    }

    public function update(Request $request, $id)
    {
        $format = PrescriptionFormatSetting::findOrFail($id);

        $request->validate([
            'paper_size' => 'required',
            'orientation' => 'required'
        ]);

        $format->update([
            'hospital_logo' => $request->hospital_logo,
            'header_text' => $request->header_text,
            'footer_text' => $request->footer_text,
            'show_doctor_name' => $request->has('show_doctor_name'),
            'show_doctor_qualification' => $request->has('show_doctor_qualification'),
            'show_registration_number' => $request->has('show_registration_number'),
            'show_patient_age' => $request->has('show_patient_age'),
            'show_patient_gender' => $request->has('show_patient_gender'),
            'show_date' => $request->has('show_date'),
            'paper_size' => $request->paper_size,
            'orientation' => $request->orientation,
            'margins' => $request->margins,
            'status' => $request->status
        ]);

        return redirect()
            ->route('prescription-format-settings.index')
            ->with('success', 'Prescription Format Updated Successfully');
    }

    public function destroy($id)
    {
        $format = PrescriptionFormatSetting::findOrFail($id);

        $format->delete();

        return redirect()
            ->route('prescription-format-settings.index')
            ->with('success', 'Prescription Format Deleted Successfully');
    }
}
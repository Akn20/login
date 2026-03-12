<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use App\Models\Vital;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Institution;

class PatientMonitoringController extends Controller
{

    public function index()
    {
        $vitals = Vital::with('patient')->latest()->get();

        return view(
            'admin.nurse.patientMonitoring.index',
            compact('vitals')
        );
    }


    public function create()
    {
        $patients = Patient::select('id', 'first_name', 'last_name')->get();

        return view(
            'admin.nurse.patientMonitoring.create',
            compact('patients')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required'
        ]);

        // Same pattern as Appointment module
        $institution = Institution::first();

        Vital::create([

            'institution_id' => $institution->id,

            'patient_id' => $request->patient_id,

            // nurse_id stores staff_id
            'nurse_id' => auth()->user()->staff_id,

            'temperature' => $request->temperature,
            'blood_pressure_systolic' => $request->blood_pressure_systolic,
            'blood_pressure_diastolic' => $request->blood_pressure_diastolic,
            'pulse_rate' => $request->pulse_rate,
            'respiratory_rate' => $request->respiratory_rate,
            'spo2' => $request->spo2,
            'blood_sugar' => $request->blood_sugar,
            'weight' => $request->weight,
            'recorded_at' => now(),
        ]);

        return redirect()
            ->route('admin.patientMonitoring.index')
            ->with('success', 'Vitals recorded successfully');
    }

    public function show($id)
    {
        $vital = Vital::findOrFail($id);
        return view('admin.nurse.patientMonitoring.show', compact('vital'));
    }

    public function edit($id)
    {
        $vital = Vital::findOrFail($id);
        return view('admin.nurse.patientMonitoring.edit', compact('vital'));
    }

    public function update(Request $request, $id)
    {
        $vital = Vital::findOrFail($id);

        $vital->update($request->all());

        return redirect()
            ->route('admin.patientMonitoring.index')
            ->with('success', 'Vitals updated successfully');
    }

    public function delete($id)
    {
        Vital::findOrFail($id)->delete();

        return redirect()
            ->route('admin.patientMonitoring.index')
            ->with('success', 'Record deleted');
    }

    public function trash()
    {
        $vitals = Vital::onlyTrashed()->get();
        return view('admin.nurse.patientMonitoring.trash', compact('vitals'));
    }

    public function restore($id)
    {
        Vital::withTrashed()->find($id)->restore();

        return redirect()
            ->route('admin.patientMonitoring.trash')
            ->with('success', 'Record restored');
    }

    public function forceDelete($id)
    {
        Vital::withTrashed()->find($id)->forceDelete();

        return redirect()
            ->route('admin.patientMonitoring.trash')
            ->with('success', 'Record permanently deleted');
    }
}

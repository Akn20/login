<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use App\Models\Vital;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Institution;
use App\Models\Staff;
use App\Helpers\ApiResponse;

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
        $patients = Patient::whereNull('deleted_at')->get();

        $nurses = Staff::join('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'Nurse')
            ->whereNull('staff.deleted_at')
            ->select('staff.id', 'staff.name')
            ->get();

        return view(
            'admin.nurse.patientMonitoring.create',
            compact('patients', 'nurses')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'nurse_id' => 'required'
        ]);

        $institution = Institution::first();

        Vital::create([
            'institution_id' => $institution->id,
            'patient_id' => $request->patient_id,
            'nurse_id' => $request->nurse_id,
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

        $patients = Patient::get();

        $nurses = Staff::join('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'Nurse')
            ->select('staff.id', 'staff.name')
            ->get();

        return view(
            'admin.nurse.patientMonitoring.edit',
            compact('vital', 'patients', 'nurses')
        );
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


    // API endpoint to fetch vitals for a specific patient

    public function apiIndex()
    {
        $vitals = Vital::with(['patient', 'nurse'])->latest()->get();

        return ApiResponse::success($vitals, 'Vitals retrieved successfully');
    }

    public function apiShow($id)
    {
        $vital = Vital::with(['patient', 'nurse'])->find($id);

        if (!$vital) {
            return ApiResponse::error('Vital record not found');
        }

        return ApiResponse::success($vital, 'Vital record retrieved successfully');
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'nurse_id' => 'required',
            'temperature' => 'required'
        ]);

        $institution = \App\Models\Institution::first();

        $vital = Vital::create([
            'institution_id' => $institution->id,
            'patient_id' => $request->patient_id,
            'nurse_id' => $request->nurse_id,
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

        return ApiResponse::success($vital, 'Vitals recorded successfully');
    }

    public function apiUpdate(Request $request, $id)
    {
        $vital = Vital::find($id);

        if (!$vital) {
            return ApiResponse::error('Vital record not found');
        }

        $vital->update($request->all());

        return ApiResponse::success($vital, 'Vitals updated successfully');
    }

    public function apiDestroy($id)
    {
        $vital = Vital::find($id);

        if (!$vital) {
            return ApiResponse::error('Vital record not found');
        }

        $vital->delete();

        return ApiResponse::success(null, 'Vital record deleted successfully');
    }

    public function apiTrash()
    {
        $vitals = Vital::onlyTrashed()
            ->with(['patient', 'nurse'])
            ->get();

        return ApiResponse::success($vitals, 'Deleted vitals retrieved successfully');
    }

    public function apiRestore($id)
    {
        $vital = Vital::withTrashed()->find($id);

        if (!$vital) {
            return ApiResponse::error('Vital record not found');
        }

        $vital->restore();

        return ApiResponse::success($vital, 'Vital record restored successfully');
    }

    public function apiForceDelete($id)
    {
        $vital = Vital::withTrashed()->find($id);

        if (!$vital) {
            return ApiResponse::error('Vital record not found');
        }

        $vital->forceDelete();

        return ApiResponse::success(null, 'Vital record permanently deleted');
    }

    public function apiGetPatients()
    {
        $patients = Patient::select(
            'id',
            'patient_code',
            'first_name',
            'last_name',
            'gender',
            'blood_group',
            'mobile'
        )->whereNull('deleted_at')
            ->get();

        return ApiResponse::success($patients, 'Patients retrieved successfully');
    }
}

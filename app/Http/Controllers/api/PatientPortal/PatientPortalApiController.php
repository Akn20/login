<?php

namespace App\Http\Controllers\Api\PatientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\LabReport;
use App\Models\RadiologyReport;

class PatientPortalApiController extends Controller
{
    // 🔹 Dashboard
    public function dashboard()
    {
        $patient = Patient::first(); // later use auth

        return response()->json([
            'status' => true,
            'data' => [
                'patient' => $patient,
                'appointments' => Appointment::where('patient_id', $patient->id)->latest()->take(5)->get(),

                'lab_reports' => LabReport::withoutGlobalScopes()
                    ->whereHas('sample', function ($q) use ($patient) {
                        $q->where('patient_id', $patient->id);
                    })
                    ->latest()->take(5)->get(),

                'radiology_reports' => RadiologyReport::withoutGlobalScopes()
                    ->whereHas('request', function ($q) use ($patient) {
                        $q->where('patient_id', $patient->id);
                    })
                    ->latest()->take(5)->get(),
            ]
        ]);
    }

    // 🔹 Appointments
    public function appointments()
    {
        $patient = Patient::first();

        $appointments = Appointment::where('patient_id', $patient->id)->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $appointments
        ]);
    }

    // 🔹 Lab Reports
    public function labReports()
    {
        $patient = Patient::first();

        $reports = LabReport::withoutGlobalScopes()
            ->with('sample')
            ->whereHas('sample', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }

    // 🔹 Radiology Reports
    public function radiology()
    {
        $patient = Patient::first();

        $reports = RadiologyReport::withoutGlobalScopes()
            ->with('request.patient')
            ->whereHas('request', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }

    // 🔹 Profile
    public function profile()
    {
        $patient = Patient::first();

        return response()->json([
            'status' => true,
            'data' => $patient
        ]);
    }

    // 🔹 Update Profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'email' => 'nullable|email',
            'address' => 'required|min:5',
            'emergency_contact' => 'required|digits:10',
        ]);

        $patient = Patient::first();

        $patient->update($request->only([
            'mobile',
            'email',
            'address',
            'emergency_contact'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully'
        ]);
    }
}
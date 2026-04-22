<?php

namespace App\Http\Controllers\Admin\PatientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\LabReport;
use App\Models\RadiologyReport;

class PatientPortalController extends Controller
{
    // 🔹 Dashboard
    public function dashboard()
    {
        $patient = Patient::first(); // TODO: replace with auth

        $appointments = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        // ✅ FIXED: remove soft delete + filter by patient
        $labReports = LabReport::withoutGlobalScopes()
            ->whereHas('sample', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
            ->latest()
            ->take(5)
            ->get();

        // ✅ FIXED: filter radiology by patient
        $radiologyReports = RadiologyReport::withoutGlobalScopes()
            ->whereHas('request', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('admin.patient-portal.dashboard', compact(
            'patient',
            'appointments',
            'labReports',
            'radiologyReports'
        ));
    }

    // 🔹 Appointments
    public function appointments()
    {
        $patient = Patient::first();

        $appointments = Appointment::where('patient_id', $patient->id)
            ->latest()
            ->get();

        return view('admin.patient-portal.appointments', compact('appointments'));
    }

    // 🔹 Lab Reports
    public function labReports()
    {
        $patient = Patient::first();

        // ✅ FIXED: remove soft delete + filter by patient
        $reports = LabReport::withoutGlobalScopes()
            ->whereHas('sample', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
            ->with('sample')
            ->latest()
            ->get();

        return view('admin.patient-portal.lab-reports', compact('reports'));
    }

    // 🔹 Radiology
    public function radiology()
    {
        $patient = Patient::first();

        // ✅ FIXED: filter by patient
        $reports = RadiologyReport::withoutGlobalScopes()
            ->whereHas('request', function ($q) use ($patient) {
                    $q->where('patient_id', $patient->id);
                })
            ->latest()
            ->get();

        return view('admin.patient-portal.radiology-reports', compact('reports'));
    }

    // 🔹 Profile
    public function profile()
    {
        $patient = Patient::first();

        return view('admin.patient-portal.profile', compact('patient'));
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

        $patient->update([
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
        ]);

        return back()->with('success', 'Profile updated successfully');
    }
}
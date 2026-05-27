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
    // ✅ COUNTS (ALL DATA)
    $appointmentsCount = Appointment::count();

    $labReportsCount = LabReport::withoutGlobalScopes()->count();

    $radiologyCount = RadiologyReport::withoutGlobalScopes()->count();

    // ✅ RECENT DATA
    $appointments = Appointment::with('patient')
        ->orderBy('appointment_date', 'desc')
        ->take(5)
        ->get();

    $labReports = LabReport::withoutGlobalScopes()
        ->with('sample')
        ->latest()
        ->take(5)
        ->get();

    $radiologyReports = RadiologyReport::withoutGlobalScopes()
        ->with('request.patient')
        ->latest()
        ->take(5)
        ->get();

    return view('admin.patient-portal.dashboard', compact(
        'appointments',
        'labReports',
        'radiologyReports',
        'appointmentsCount',
        'labReportsCount',
        'radiologyCount'
    ));
}
    // 🔹 Appointments
public function appointments()
{
    $appointments = Appointment::with(['patient', 'doctor', 'department'])
        ->orderBy('appointment_date', 'desc')
        ->orderBy('appointment_time', 'desc')
        ->get();

    return view('admin.patient-portal.appointments', compact('appointments'));
}

    // 🔹 Lab Reports
    public function labReports()
{
    $reports = LabReport::withoutGlobalScopes()
        ->with('sample')
        ->latest()
        ->get();

    return view('admin.patient-portal.lab-reports', compact('reports'));
}

    // 🔹 Radiology
    public function radiology()
{
    $reports = RadiologyReport::with('request.patient') // eager load
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
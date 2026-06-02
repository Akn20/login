<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\IPDAdmission;
use App\Models\LabRequest;
use App\Models\Patient;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $todayAppointments = Appointment::whereDate('appointment_date',today())->take(10)->count();

        $totalConsultations = Consultation::count();

        $admittedPatients = IPDAdmission::count();

        $pendingLabRequests = LabRequest::where('status','Pending')->count();

        $totalPatients = Patient::count();

        $totalLabRequests = LabRequest::count();

        $appointments = Appointment::with(['patient','doctor'])->latest()->get();

        $consultations = Consultation::with(['patient','doctor'])->latest()->take(10)->get();

        $labRequests = LabRequest::with('patient')->latest()->get();

        $ipdAdmissions = IPDAdmission::with(['patient','doctor'])->latest()->get();

        return view('doctor.dashboard',
            compact(
                'todayAppointments',
                'totalConsultations',
                'admittedPatients',
                'pendingLabRequests',
                'totalPatients',
                'totalLabRequests',
                'appointments',
                'consultations',
                'labRequests',
                'ipdAdmissions'
            )
        );
    }
}

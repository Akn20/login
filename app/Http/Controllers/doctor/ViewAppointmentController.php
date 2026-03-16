<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment; 
class ViewAppointmentController extends Controller
{
    public function index()
    {
         $appointments = Appointment::with('patient')
        ->whereDate('appointment_date', today())
        ->orderBy('appointment_time')
        ->get();

        return view('doctor.opd.view-appointment', compact('appointments'));
    }
}
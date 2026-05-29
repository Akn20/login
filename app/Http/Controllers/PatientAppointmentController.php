<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{

    // ================= INDEX =================

    public function index()
    {
$appointments = Appointment::with([
        'doctor',
        'department',
        'patient'
    ])
    ->latest()
    ->get();

        return view(
            'admin.patients.appointment-tracking.index',
            compact('appointments')
        );
    }



    // ================= SHOW =================

    public function show($id)
    {

        $appointment = Appointment::with([
                'doctor',
                'department',
                'patient'
            ])
            ->findOrFail($id);

        return view(
            'admin.patients.appointment-tracking.show',
            compact('appointment')
        );
    }



    // ================= CANCEL =================

    public function cancel($id)
    {

        $appointment = Appointment::findOrFail($id);


        if (
            $appointment->appointment_status == 'Completed'
        ) {

            return back()->with(
                'error',
                'Completed appointment cannot be cancelled'
            );
        }


        $appointment->update([

            'appointment_status' => 'Cancelled'

        ]);


        return back()->with(
            'success',
            'Appointment cancelled successfully'
        );
    }

}
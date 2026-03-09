<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewAppointmentController extends Controller
{
    public function index()
    {
        $appointments = [

            (object) [
                'token_number' => 101,
                'patient_name' => 'Ramesh Kumar',
                'appointment_time' => '10:00 AM',
                'status' => 'Waiting'
            ],

            (object) [
                'token_number' => 102,
                'patient_name' => 'Anita Sharma',
                'appointment_time' => '10:15 AM',
                'status' => 'Waiting'
            ],

            (object) [
                'token_number' => 103,
                'patient_name' => 'Rahul Verma',
                'appointment_time' => '10:30 AM',
                'status' => 'Completed'
            ]

        ];

        return view('doctor.opd.view-appointment', compact('appointments'));
    }
}
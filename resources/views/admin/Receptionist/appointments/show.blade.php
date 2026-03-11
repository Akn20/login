@extends('layouts.admin')

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-title">
                <h5>Appointment Details</h5>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <p><strong>Patient:</strong>
                    {{ $appointment->patient->first_name }}
                    {{ $appointment->patient->last_name }}
                </p>

                <p><strong>Doctor:</strong>
                    {{ $appointment->doctor->name }}</p>

                <p><strong>Department:</strong>
                    {{ $appointment->department->department_name }}</p>

                <p><strong>Date:</strong>
                    {{ $appointment->appointment_date }}</p>

                <p><strong>Time:</strong>
                    {{ $appointment->appointment_time }}</p>

                <p><strong>Fee:</strong>
                    ₹ {{ $appointment->consultation_fee }}</p>

                <p><strong>Status:</strong>
                    {{ $appointment->appointment_status }}</p>

            </div>
        </div>

    </div>

@endsection
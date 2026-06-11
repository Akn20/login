@extends('layouts.admin')

@section('content')

<div class="page-header">

    <div class="page-header-left d-flex align-items-center">

        <div class="page-header-title">

            <h5 class="m-b-10">

                Appointment Details

            </h5>

        </div>

        <ul class="breadcrumb">

            <li class="breadcrumb-item">

                <a href="#">

                    Patient

                </a>

            </li>

            <li class="breadcrumb-item">

                Appointment Tracking

            </li>

        </ul>

    </div>

</div>



<div class="card">

<div class="card-body">


<div class="d-flex justify-content-between align-items-center mb-4">

    <h5 class="mb-0">

        Appointment Information

    </h5>


    <a href="{{ route('admin.patient.appointments.index') }}"
       class="btn btn-secondary btn-sm">

        <i class="feather-arrow-left me-1"></i>

        Back

    </a>

</div>



<div class="row">


    {{-- PATIENT --}}
    <div class="col-md-4 mb-3">

        <label class="fw-bold">

            Patient Name

        </label>

        <div>

            {{ $appointment->patient->first_name ?? '' }}
            {{ $appointment->patient->last_name ?? '' }}

        </div>

    </div>



    {{-- DOCTOR --}}
    <div class="col-md-4 mb-3">

        <label class="fw-bold">

            Doctor

        </label>

        <div>

            {{ $appointment->doctor->name ?? '-' }}

        </div>

    </div>



    {{-- DEPARTMENT --}}
    <div class="col-md-4 mb-3">

        <label class="fw-bold">

            Department

        </label>

        <div>

            {{ $appointment->department->department_name ?? '-' }}

        </div>

    </div>



    {{-- DATE --}}
    <div class="col-md-4 mb-3">

        <label class="fw-bold">

            Appointment Date

        </label>

        <div>

            {{ \Carbon\Carbon::parse(
                $appointment->appointment_date
            )->format('d M Y') }}

        </div>

    </div>



    {{-- TIME --}}
    <div class="col-md-4 mb-3">

        <label class="fw-bold">

            Appointment Time

        </label>

        <div>

            {{ $appointment->appointment_time }}

        </div>

    </div>



    {{-- STATUS --}}
    <div class="col-md-4 mb-3">

        <label class="fw-bold">

            Appointment Status

        </label>

        <div>

            @if($appointment->appointment_status == 'Completed')

                <span class="badge bg-success">

                    Completed

                </span>

            @elseif($appointment->appointment_status == 'Cancelled')

                <span class="badge bg-danger">

                    Cancelled

                </span>

            @elseif($appointment->appointment_status == 'Confirmed')

                <span class="badge bg-primary">

                    Confirmed

                </span>

            @elseif($appointment->appointment_status == 'No Show')

                <span class="badge bg-dark">

                    No Show

                </span>

            @else

                <span class="badge bg-warning">

                    Scheduled

                </span>

            @endif

        </div>

    </div>



    {{-- REMINDER STATUS --}}
    <div class="col-md-4 mb-3">

        <label class="fw-bold">

            Reminder Status

        </label>

        <div>

            @if($appointment->reminder_status == 'Sent')

                <span class="badge bg-success">

                    Reminder Sent

                </span>

            @else

                <span class="badge bg-warning">

                    Pending

                </span>

            @endif

        </div>

    </div>



    {{-- REMINDER TIME --}}
    <div class="col-md-4 mb-3">

        <label class="fw-bold">

            Reminder Sent At

        </label>

        <div>

            {{ $appointment->reminder_sent_at ?? '-' }}

        </div>

    </div>



    {{-- CONSULTATION FEE --}}
    <div class="col-md-4 mb-3">

        <label class="fw-bold">

            Consultation Fee

        </label>

        <div>

            ₹ {{ $appointment->consultation_fee ?? 0 }}

        </div>

    </div>

</div>



<hr>



<h5 class="mb-3">

    Appointment Timeline

</h5>


<div class="timeline">


    <div class="mb-3">

        <span class="badge bg-primary">

            Appointment Booked

        </span>

    </div>


    @if($appointment->reminder_status == 'Sent')

    <div class="mb-3">

        <span class="badge bg-info">

            Reminder Sent

        </span>

    </div>

    @endif


    @if($appointment->appointment_status == 'Confirmed')

    <div class="mb-3">

        <span class="badge bg-primary">

            Appointment Confirmed

        </span>

    </div>

    @endif


    @if($appointment->appointment_status == 'Completed')

    <div class="mb-3">

        <span class="badge bg-success">

            Consultation Completed

        </span>

    </div>

    @endif


    @if($appointment->appointment_status == 'Cancelled')

    <div class="mb-3">

        <span class="badge bg-danger">

            Appointment Cancelled

        </span>

    </div>

    @endif

</div>



</div>
</div>

@endsection
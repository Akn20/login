@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left d-flex align-items-center">

        <div class="page-header-title">
            <h5 class="m-b-10">

                My Appointments

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


<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-light">

<tr>

    <th>#</th>

    <th>Appointment Date</th>

    <th>Time</th>

    <th>Doctor</th>

    <th>Department</th>

    <th>Status</th>

    <th>Reminder</th>

    <th class="text-end">Actions</th>

</tr>

</thead>

<tbody>

@forelse($appointments as $appointment)

<tr>

    <td>

        {{ $loop->iteration }}

    </td>


    <td>

        {{ \Carbon\Carbon::parse(
            $appointment->appointment_date
        )->format('d M Y') }}

    </td>


    <td>

        {{ $appointment->appointment_time }}

    </td>


    <td>

        {{ $appointment->doctor->name ?? '-' }}

    </td>


    <td>

        {{ $appointment->department->department_name ?? '-' }}

    </td>


    {{-- STATUS --}}
    <td>

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

    </td>



    {{-- REMINDER --}}
    <td>

        @if($appointment->reminder_status == 'Sent')

            <span class="badge bg-success">

                Sent

            </span>

        @else

            <span class="badge bg-warning">

                Pending

            </span>

        @endif

    </td>



    {{-- ACTIONS --}}
    <td class="text-end">

        <div class="d-flex gap-2 justify-content-end">

            {{-- VIEW --}}
            <a href="{{ route(
                    'admin.patient.appointments.show',
                    $appointment->id
                ) }}"
               class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
               title="View">

                <i class="feather-eye"></i>

            </a>



            {{-- CANCEL --}}
            @if(
                $appointment->appointment_status != 'Completed'
                &&
                $appointment->appointment_status != 'Cancelled'
            )

            <form action="{{ route(
                    'admin.patient.appointments.cancel',
                    $appointment->id
                ) }}"
                  method="POST">

                @csrf

                <button type="submit"
                        class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                        title="Cancel Appointment">

                    <i class="feather-x"></i>

                </button>

            </form>

            @endif

        </div>

    </td>

</tr>

@empty

<tr>

    <td colspan="8" class="text-center text-muted">

        No appointments found

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>
</div>

@endsection
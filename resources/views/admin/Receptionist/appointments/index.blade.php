@extends('layouts.admin')

@section('page-title', 'Appointments | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Appointment Management</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Receptionist</li>
                    <li class="breadcrumb-item">Appointments</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">

                <a href="{{ route('admin.appointments.trash') }}" class="btn btn-neutral">
                    Deleted Records
                </a>

                <a href="{{ route('admin.appointments.create') }}" class="btn btn-neutral">
                    Add Appointment
                </a>

            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-hover">

                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Department</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($appointments as $index => $appointment)

                                            <tr>

                                                <td>{{ $index + 1 }}</td>

                                                <td>
                                                    {{ $appointment->patient->first_name ?? '' }}
                                                    {{ $appointment->patient->last_name ?? '' }}
                                                </td>

                                                <td>{{ $appointment->doctor->name ?? '-' }}</td>

                                                <td>{{ $appointment->department->department_name ?? '-' }}</td>

                                                <td>{{ $appointment->appointment_date }}</td>

                                                <td>{{ $appointment->appointment_time }}</td>

                                                <td>

                                                    @if($appointment->appointment_status == 'Scheduled')
                                                        <span class="badge bg-soft-primary text-primary">Scheduled</span>

                                                    @elseif($appointment->appointment_status == 'Completed')
                                                        <span class="badge bg-soft-success text-success">Completed</span>

                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Cancelled</span>
                                                    @endif

                                                </td>

                                                <td class="text-end">

                                                    <div class="hstack gap-2 justify-content-end">

                                                        <a href="{{ route('admin.appointments.show', $appointment->id) }}"
                                                            class="avatar-text avatar-md action-icon">
                                                            <i class="feather-eye"></i>
                                                        </a>

                                                        <a href="{{ route('admin.appointments.edit', $appointment->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        <form
                                                            action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                                                            method="POST" onsubmit="return confirm('Delete this appointment?')">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete">
                                                                <i class="feather-trash-2"></i>
                                                            </button>

                                                        </form>

                                                    </div>

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
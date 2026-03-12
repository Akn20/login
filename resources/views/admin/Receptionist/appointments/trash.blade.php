@extends('layouts.admin')

@section('page-title', 'Deleted Appointments')

@section('content')

    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5>Deleted Appointments</h5>
                </div>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-neutral">
                    Back
                </a>
            </div>
        </div>



        <div class="card">
            <div class="card-body">

                <table class="table">

                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($appointments as $appointment)
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

                                    <td class="text-end">
                                        <div class="hstack gap-2 justify-content-end">

                                            {{-- Restore --}}
                                            <a href="{{ route('admin.appointments.restore', $appointment->id) }}"
                                                class="avatar-text avatar-md action-icon action-restore">
                                                <i class="feather-refresh-ccw"></i>
                                            </a>

                                            {{-- Permanent Delete --}}
                                            <a href="{{ route('admin.appointments.forceDelete', $appointment->id) }}"
                                                class="avatar-text avatar-md action-icon action-delete"
                                                onclick="return confirm('This will permanently delete the appointment. Continue?')">
                                                <i class="feather-trash"></i>
                                            </a>

                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>

    </div>

@endsection
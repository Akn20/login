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
                                            <form action="{{ route('admin.appointments.restore', $appointment->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                    class="avatar-text avatar-md action-icon action-restore border-0">
                                                    <i class="feather-refresh-ccw"></i>
                                                </button>
                                            </form>

                                            {{-- Permanent Delete --}}
                                            <form action="{{ route('admin.appointments.forceDelete', $appointment->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('This will permanently delete the appointment. Continue?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md action-icon action-delete border-0">
                                                    <i class="feather-trash"></i>
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

@endsection

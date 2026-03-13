@extends('layouts.admin')

@section('content')

    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4>Today's OPD Appointments</h4>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th class="text-center">Token</th>
                            <th class="text-center">Patient Name</th>
                            <th class="text-center">Appointment Time</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($appointments as $appointment)

                            <tr>

                                {{-- Token Number --}}
                                <td class="text-center">
                                    {{ 100 + $loop->iteration }}
                                </td>

                                {{-- Patient Name from patients table --}}
                                <td class="text-center">
                                    {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                </td>

                                {{-- Appointment Time --}}
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </td>

                                {{-- Status --}}
                                <td class="text-center">

                                    @if($appointment->appointment_status == 'Scheduled')
                                        <span class="badge bg-warning">Waiting</span>

                                    @elseif($appointment->appointment_status == 'Completed')
                                        <span class="badge bg-success">Completed</span>

                                    @elseif($appointment->appointment_status == 'Cancelled')
                                        <span class="badge bg-danger">Cancelled</span>

                                    @endif

                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">

                                        @if($appointment->appointment_status === 'Completed')

                                            <button class="btn btn-secondary btn-sm" disabled>
                                                Consultation Completed
                                            </button>

                                        @else

                                            <a href="{{ route('doctor.consultation', $appointment->patient_id) }}"
                                                class="btn btn-success btn-sm">
                                                Start Consultation
                                            </a>

                                        @endif

                                        <a href="{{ route('doctor.view-patient-profile', $appointment->patient_id) }}"
                                            class="btn btn-primary btn-sm">
                                            View Patient Profile
                                        </a>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    No Appointments Available
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>

@endsection
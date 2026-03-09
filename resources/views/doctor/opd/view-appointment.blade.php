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

                                <td class="text-center">{{ $appointment->token_number }}</td>
                                <td class="text-center">{{ $appointment->patient_name }}</td>
                                <td class="text-center">{{ $appointment->appointment_time }}</td>

                                <td class="text-center">

                                    @if($appointment->status == 'Waiting')
                                        <span class="badge bg-warning">Waiting</span>

                                    @elseif($appointment->status == 'Completed')
                                        <span class="badge bg-success">Completed</span>

                                    @else
                                        <span class="badge bg-primary">{{ $appointment->status }}</span>
                                    @endif

                                </td>

                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                       <a href="{{ route('doctor.consultation', $appointment->token_number) }}" class="btn btn-success btn-sm">
    Start Consultation
</a>

                                       <a href="{{ route('doctor.view-patient-profile', $appointment->token_number) }}" class="btn btn-primary btn-sm">
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
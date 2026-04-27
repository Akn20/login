@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4>Appointments</h4>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($appointments as $a)

                        @php
                            $statusColors = [
                                'Scheduled' => 'primary',
                                'Completed' => 'success',
                                'Cancelled' => 'danger',
                            ];
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>
                                    {{ $a->patient->first_name ?? '' }} 
                                    {{ $a->patient->last_name ?? '' }}
                                </strong>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($a->appointment_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($a->appointment_time)->format('h:i A') }}
                            </td>

                            <td>
                                <span class="badge bg-{{ $statusColors[$a->appointment_status] ?? 'secondary' }}">
                                    {{ $a->appointment_status }}
                                </span>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No appointments available
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
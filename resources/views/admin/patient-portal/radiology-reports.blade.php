@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4>Radiology Reports</h4>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Scan Type</th>
                        <th>Status</th>
                        <th>Findings</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reports as $report)

                        @php
                            $statusColors = [
                                'Pending' => 'warning',
                                'Approved' => 'success',
                                'Rejected' => 'danger',
                            ];
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <!-- Patient Name -->
                            <td>
                                <strong>
                                    {{ $report->request->patient->first_name ?? '-' }}
                                </strong>
                            </td>

                            <!-- Scan Type -->
                            <td>
                                {{ $report->request->scanType->name ?? 'N/A' }}
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="badge bg-{{ $statusColors[$report->status] ?? 'secondary' }}">
                                    {{ $report->status }}
                                </span>
                            </td>

                            <!-- Findings -->
                            <td style="max-width: 250px;">
                                {{ \Illuminate\Support\Str::limit($report->findings, 50) }}
                            </td>

                            <!-- Date -->
                            <td>
                                {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No radiology reports available
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
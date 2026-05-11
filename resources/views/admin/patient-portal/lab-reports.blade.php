@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4>Lab Reports</h4>

    <!-- Search -->
    <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2"
               placeholder="Search by Sample ID"
               value="{{ request('search') }}">
        <button class="btn btn-light">
            <i class="feather-search"></i>
        </button>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Sample ID</th>
                        <th>Status</th>
                        <th>Result</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reports as $report)

                        @php
                            $statusColors = [
                                'Draft' => 'secondary',
                                'In Progress' => 'warning',
                                'Completed' => 'success',
                            ];
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <!-- Patient Name -->
                            <td>
                                {{ $report->sample->patient->first_name ?? '-' }}
                                {{ $report->sample->patient->last_name ?? '' }}
                            </td>

                            <!-- Sample ID -->
                            <td>
                                <strong>{{ $report->sample->sample_id ?? '-' }}</strong>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="badge bg-{{ $statusColors[$report->status] ?? 'secondary' }}">
                                    {{ $report->status }}
                                </span>
                            </td>

                            <!-- Result -->
                            <td>
                                @if($report->status === 'Completed')
                                    <span class="text-success fw-semibold">Available</span>
                                @else
                                    <span class="text-muted">Pending</span>
                                @endif
                            </td>

                            <!-- Date -->
                            <td>
                                {{ $report->created_at ? $report->created_at->format('d M Y') : '-' }}
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No lab reports available
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
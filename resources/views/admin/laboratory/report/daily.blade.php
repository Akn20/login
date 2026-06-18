@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Daily Test Report</h5>
        <small class="text-muted">Summary of laboratory tests performed on {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</small>
    </div>

    <div class="d-flex gap-2">
        {{-- FILTER (DATE) --}}
        <form method="GET" class="d-flex gap-2">
            <input type="date" name="date" class="form-control form-control-sm"
                value="{{ request('date', $date) }}">
            <button type="submit" class="btn btn-light-brand btn-sm">
                <i class="feather-search"></i>
            </button>
        </form>
        
        {{-- EXPORT BUTTON --}}
        <a href="{{ route('admin.laboratory.reports.daily.export', ['date' => $date]) }}" 
           class="btn btn-outline-secondary btn-sm">
            <i class="feather-download"></i> Export
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- SUMMARY --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="border rounded p-3 text-center">
                    <h6 class="text-muted">Tests Completed</h6>
                    <h4 class="fw-bold text-success">{{ $total }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-3 text-center">
                    <h6 class="text-muted">Selected Date</h6>
                    <h4 class="fw-bold">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-3 text-center">
                    <h6 class="text-muted">Report Date</h6>
                    <h4 class="fw-bold">{{ now()->format('d M Y') }}</h4>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dailyReportTable">

                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Test Name</th>
                        <th>Sample ID</th>
                        <th>Test Status</th>
                        <th>Completion Time</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse($reports as $report)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            {{-- PATIENT NAME --}}
                            <td>
                                @php
                                    $patient = $report->sample->labRequest->patient ?? null;
                                @endphp
                                {{ $patient ? $patient->first_name . ' ' . $patient->last_name : 'N/A' }}
                            </td>

                            {{-- TEST NAME --}}
                            <td>
                                {{ $report->sample->labRequest->labTest->test_name ?? ($report->sample->labRequest->test_name ?? 'N/A') }}
                            </td>

                            {{-- SAMPLE ID --}}
                            <td>
                                {{ $report->sample->barcode ?? $report->sample_id ?? '-' }}
                            </td>

                            {{-- TEST STATUS --}}
                            <td>
                                @if($report->status == 'Completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($report->status == 'Pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-secondary">{{ $report->status }}</span>
                                @endif
                            </td>

                            {{-- COMPLETION TIME --}}
                            <td>
                                @if($report->status == 'Completed' && $report->created_at)
                                    {{ $report->created_at->format('h:i A') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No reports found for selected date
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
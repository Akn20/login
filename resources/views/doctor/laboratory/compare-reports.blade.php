@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h3 class="mb-1">Historical Report Comparison</h3>
                <p class="text-muted mb-0">
                    Compare previous laboratory reports and result trends
                </p>
            </div>

            <a href="{{ url()->previous() }}"
               class="btn btn-outline-secondary">
                Back
            </a>

        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">

                    <h5>Total Reports</h5>

                    <h2 class="text-primary">
                        {{ $reports->count() }}
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">

                    <h5>Latest Report</h5>

                    <h4 class="text-success">
                        @if($reports->count() > 0)
                            {{ $reports->first()->created_at->format('d M Y') }}
                        @else
                            N/A
                        @endif
                    </h4>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">

                    <h5>Patient</h5>

                    <h4 class="text-dark">

                        @php
                            $firstReport = $reports->first();
                            $patient = optional(optional($firstReport?->sample)->labRequest)->patient;
                        @endphp

                        {{ $patient->first_name ?? 'N/A' }}
                        {{ $patient->last_name ?? '' }}

                    </h4>

                </div>
            </div>
        </div>

    </div>

    {{-- REPORT COMPARISON TABLE --}}
    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">Report Comparison Table</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Report Date</th>
                            <th>Test Name</th>
                            <th>Sample ID</th>
                            <th>Status</th>
                            <th>Result Values</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($reports as $report)

                            @php
                                $labRequest = optional($report->sample)->labRequest;
                            @endphp

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $report->created_at->format('d M Y h:i A') }}
                                </td>

                                <td>
                                    {{ $labRequest->test_name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $report->sample->barcode ?? '-' }}
                                </td>

                                <td>

                                    @if($report->status == 'Completed')

                                        <span class="badge bg-success">
                                            Completed
                                        </span>

                                    @elseif($report->status == 'Pending')

                                        <span class="badge bg-warning">
                                            Pending
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $report->status }}
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if(is_array($report->result_data))

                                        <table class="table table-sm table-bordered mb-0">

                                            <thead>
                                                <tr>
                                                    <th>Parameter</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach($report->result_data as $key => $value)

                                                    @if($key != 'attachments')

                                                        <tr>

                                                            <td>
                                                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                            </td>

                                                            <td>

                                                                @if(is_array($value))
                                                                    {{ json_encode($value) }}
                                                                @else
                                                                    {{ $value }}
                                                                @endif

                                                            </td>

                                                        </tr>

                                                    @endif

                                                @endforeach

                                            </tbody>

                                        </table>

                                    @else

                                        <span class="text-muted">
                                            No result data available
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted">

                                    No comparison reports available

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    
    

</div>

@endsection
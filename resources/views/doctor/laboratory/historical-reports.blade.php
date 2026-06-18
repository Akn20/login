@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="card mb-4">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>

                <h3 class="mb-1">
                    Historical Laboratory Reports
                </h3>

                <p class="text-muted mb-0">
                    Compare previous laboratory reports and monitor patient trends
                </p>

            </div>

            <div>

                <a href="{{ route('doctor.laboratory.reports') }}"
                   class="btn btn-primary">

                    <i class="feather-file-text me-1"></i>
                    Laboratory Reports

                </a>

            </div>

        </div>

    </div>



    {{-- SUMMARY CARDS --}}
    <div class="row mb-4">

        {{-- TOTAL REPORTS --}}
        <div class="col-md-4">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Total Historical Reports
                    </h6>

                    <h2 class="fw-bold text-primary">

                        {{ $reports->count() }}

                    </h2>

                </div>

            </div>

        </div>


        {{-- COMPLETED --}}
        <div class="col-md-4">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Completed Reports
                    </h6>

                    <h2 class="fw-bold text-success">

                        {{ $reports->where('status', 'Completed')->count() }}

                    </h2>

                </div>

            </div>

        </div>


        {{-- UNIQUE PATIENTS --}}
        <div class="col-md-4">

            <div class="card h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Patients Covered
                    </h6>

                    <h2 class="fw-bold text-info">

                        {{
                            $reports
                            ->pluck('sample.labRequest.patient_id')
                            ->unique()
                            ->count()
                        }}

                    </h2>

                </div>

            </div>

        </div>

    </div>



    {{-- SEARCH + FILTER --}}
    <div class="card mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    {{-- SEARCH --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Search Patient/Test
                        </label>

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Enter patient or test name"
                               value="{{ request('search') }}">

                    </div>


                    {{-- DATE FROM --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               name="from_date"
                               class="form-control"
                               value="{{ request('from_date') }}">

                    </div>


                    {{-- DATE TO --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                               name="to_date"
                               class="form-control"
                               value="{{ request('to_date') }}">

                    </div>


                    {{-- BUTTON --}}
                    <div class="col-md-2 d-flex align-items-end">

                        <button class="btn btn-primary w-100">

                            <i class="feather-search me-1"></i>
                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    {{-- REPORT TABLE --}}
    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Historical Report List
            </h5>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Patient Name</th>

                            <th>Test Name</th>

                            <th>Sample ID</th>

                            <th>Status</th>

                            <th>Report Date</th>

                            <th>Comparison</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($reports as $report)

                            @php

                                $sample = $report->sample;

                                $labRequest = optional($sample)->labRequest;

                                $patient = optional($labRequest)->patient;

                            @endphp


                            <tr>

                                {{-- SERIAL --}}
                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                {{-- PATIENT --}}
                                <td>

                                    @if($patient)

                                        <div class="fw-bold">

                                            {{ $patient->first_name ?? '' }}
                                            {{ $patient->last_name ?? '' }}

                                        </div>

                                    @else

                                        <span class="text-muted">

                                            N/A

                                        </span>

                                    @endif

                                </td>


                                {{-- TEST --}}
                                <td>

                                    {{ $labRequest->test_name ?? 'N/A' }}

                                </td>


                                {{-- SAMPLE --}}
                                <td>

                                    {{ $sample->barcode ?? '-' }}

                                </td>


                                {{-- STATUS --}}
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

                                        <span class="badge bg-info">

                                            {{ $report->status }}

                                        </span>

                                    @endif

                                </td>


                                {{-- DATE --}}
                                <td>

                                    {{ $report->created_at->format('d M Y') }}

                                    <br>

                                    <small class="text-muted">

                                        {{ $report->created_at->format('h:i A') }}

                                    </small>

                                </td>


                                {{-- COMPARE --}}
                                <td>

                                    @if($patient && $labRequest)

                                        <a href="{{ route(
                                            'doctor.laboratory.compare',
                                            [
                                                'patientId' => $patient->id,
                                                'testName' => $labRequest->test_name
                                            ]
                                        ) }}"
                                           class="btn btn-info btn-sm">

                                            <i class="feather-bar-chart-2 me-1"></i>

                                            Compare

                                        </a>

                                    @else

                                        <button class="btn btn-secondary btn-sm"
                                                disabled>

                                            Unavailable

                                        </button>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center text-muted py-4">

                                    No historical reports found

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
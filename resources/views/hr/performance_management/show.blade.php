@extends('layouts.admin')

@section(
    'page-title',
    'View Performance Review | ' . config('app.name')
)

@section('content')

<div class="nxl-content">

    <div class="page-header mb-4 d-flex align-items-center justify-content-between">

        <div class="page-header-title">

            <h5 class="m-b-10 mb-1">
                Performance Review Details
            </h5>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('hr.performance-management.edit', $record->id) }}"
                class="btn btn-primary"
            >
                Edit
            </a>

            <a
                href="{{ route('hr.performance-management.index') }}"
                class="btn btn-light"
            >
                Back
            </a>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            {{-- Employee Information --}}
            <h5 class="mb-3 text-primary">
                Employee Information
            </h5>

            <hr>

            <div class="row">

                {{-- Employee ID --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        Employee ID
                    </label>

                    <div class="fw-bold">
                        {{ $record->employee_id }}
                    </div>

                </div>

                {{-- Employee Name --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        Employee Name
                    </label>

                    <div class="fw-bold">
                        {{ $record->employee_name }}
                    </div>

                </div>

                {{-- Department --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        Department
                    </label>

                    <div class="fw-bold">
                        {{ $record->department }}
                    </div>

                </div>

            </div>

            {{-- Performance Review --}}
            <h5 class="mb-3 text-primary mt-4">
                Performance Review
            </h5>

            <hr>

            <div class="row">

                {{-- Reviewer Name --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        Reviewer Name
                    </label>

                    <div>
                        {{ $record->reviewer_name }}
                    </div>

                </div>

                {{-- Review Date --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        Review Date
                    </label>

                    <div>
                        {{ \Carbon\Carbon::parse($record->review_date)->format('d-m-Y') }}
                    </div>

                </div>

                {{-- Rating --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        Rating
                    </label>

                    <div>
                        {{ $record->rating }}/5
                    </div>

                </div>

                {{-- Review Status --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        Review Status
                    </label>

                    <div>

                        @if($record->review_status == 'Pending')

                            <span class="badge bg-soft-warning text-warning">
                                Pending
                            </span>

                        @elseif($record->review_status == 'Reviewed')

                            <span class="badge bg-soft-info text-info">
                                Reviewed
                            </span>

                        @elseif($record->review_status == 'Approved')

                            <span class="badge bg-soft-success text-success">
                                Approved
                            </span>

                        @endif

                    </div>

                </div>

                {{-- Review Comments --}}
                <div class="col-md-12 mb-3">

                    <label class="text-muted">
                        Review Comments
                    </label>

                    <div>
                        {{ $record->review_comments ?? '-' }}
                    </div>

                </div>

            </div>

            {{-- KPI Tracking --}}
            <h5 class="mb-3 text-primary mt-4">
                KPI Tracking
            </h5>

            <hr>

            <div class="row">

                {{-- KPI Name --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        KPI Name
                    </label>

                    <div>
                        {{ $record->kpi_name ?? '-' }}
                    </div>

                </div>

                {{-- KPI Score --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        KPI Score
                    </label>

                    <div>
                        {{ $record->kpi_score ?? '-' }}
                    </div>

                </div>

                {{-- Target Value --}}
                <div class="col-md-4 mb-3">

                    <label class="text-muted">
                        Target Value
                    </label>

                    <div>
                        {{ $record->target_value ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
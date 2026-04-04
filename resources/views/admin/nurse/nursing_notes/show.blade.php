@extends('layouts.admin')

@section('content')
<div class="nxl-content">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">View Nursing Note</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Nurse</li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.nursing-notes.index') }}">Nursing Notes</a>
                </li>
                <li class="breadcrumb-item">View</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.nursing-notes.edit', $note->id) }}" class="btn btn-primary">
                Edit
            </a>
            <a href="{{ route('admin.nursing-notes.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">

                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h6 class="mb-0">Nursing Note Details</h6>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Patient Name</label>
                                <p class="mb-0">
                                    {{ $note->patient->first_name ?? '-' }}
                                    {{ $note->patient->last_name ?? '' }}
                                </p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Patient Code</label>
                                <p class="mb-0">{{ $note->patient->patient_code ?? '-' }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nurse Name</label>
                                <p class="mb-0">{{ $note->nurse->name ?? '-' }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Shift</label>
                                <p class="mb-0">{{ $note->shift ?? '-' }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Patient Condition</label>
                                <p class="mb-0">{{ $note->patient_condition ?? '-' }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Intake Details</label>
                                <p class="mb-0">{{ $note->intake_details ?? '-' }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Output Details</label>
                                <p class="mb-0">{{ $note->output_details ?? '-' }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Wound Care Notes</label>
                                <p class="mb-0">{{ $note->wound_care_notes ?? '-' }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Created At</label>
                                <p class="mb-0">
                                    {{ $note->created_at ? $note->created_at->format('d-m-Y h:i A') : '-' }}
                                </p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Updated At</label>
                                <p class="mb-0">
                                    {{ $note->updated_at ? $note->updated_at->format('d-m-Y h:i A') : '-' }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
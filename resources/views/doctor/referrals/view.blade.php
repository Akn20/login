@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Referral Details
            </h3>

            <p class="text-muted mb-0">
                View complete referral information
            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('doctor.referrals.edit', $referral->id) }}"
               class="btn btn-warning text-white">

                <i class="fa fa-edit me-1"></i>
                Edit

            </a>

            <a href="{{ route('doctor.referrals.index') }}"
               class="btn btn-secondary">

                <i class="fa fa-arrow-left me-1"></i>
                Back

            </a>

        </div>

    </div>

    <div class="row">

        <!-- Left Section -->
        <div class="col-lg-8">

            <!-- Patient Details -->
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Patient Details
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <small class="text-muted">
                                Patient Name
                            </small>

                            <h6 class="mb-0">
                               {{ $referral->patient->first_name ?? '' }}
                                {{ $referral->patient->last_name ?? '' }}
                            </h6>

                        </div>

                        <div class="col-md-4 mb-3">

                            <small class="text-muted">
                                Doctor ID
                            </small>

                            <h6 class="mb-0">
                                {{ $referral->doctor->name ?? '-' }}
                            </h6>

                        </div>

                        <div class="col-md-4 mb-3">

                            <small class="text-muted">
                                Referral Type
                            </small>

                            <h6 class="mb-0">
                                {{ $referral->referral_type }}
                            </h6>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Referral Information -->
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Referral Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <small class="text-muted">
                                Referral ID
                            </small>

                            <h6 class="mb-0">
                                {{ $referral->id }}
                            </h6>

                        </div>

                        <div class="col-md-4 mb-3">

                            <small class="text-muted">
                                Referred Doctor
                            </small>

                            <h6 class="mb-0">
                                {{ $referral->referredDoctor->name ?? '-' }}
                            </h6>

                        </div>

                        <div class="col-md-4 mb-3">

                            <small class="text-muted">
                                Department
                            </small>

                            <h6 class="mb-0">
                                {{ $referral->department->department_name ?? '-' }}
                            </h6>

                        </div>

                        <div class="col-md-4 mb-3">

                            <small class="text-muted">
                                Priority
                            </small>

                            <h6 class="mb-0">
                                {{ $referral->priority }}
                            </h6>

                        </div>

                        <div class="col-md-4 mb-3">

                            <small class="text-muted">
                                Status
                            </small>

                            <h6 class="mb-0">
                                {{ $referral->status }}
                            </h6>

                        </div>

                        <div class="col-md-4 mb-3">

                            <small class="text-muted">
                                Follow-up Date
                            </small>

                            <h6 class="mb-0">

                                {{ $referral->followup_date
                                    ? date('d-M-Y', strtotime($referral->followup_date))
                                    : '-' }}

                            </h6>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Referral Reason -->
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Referral Reason
                    </h5>

                </div>

                <div class="card-body">

                    <p class="mb-0">

                        {{ $referral->referral_reason }}

                    </p>

                </div>

            </div>

            <!-- Clinical Notes -->
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Clinical Notes
                    </h5>

                </div>

                <div class="card-body">

                    <p class="mb-0">

                        {{ $referral->clinical_notes ?? 'No Notes Available' }}

                    </p>

                </div>

            </div>

        </div>

        <!-- Right Section -->
        <div class="col-lg-4">

            <!-- Status Card -->
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Referral Status
                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <small class="text-muted">
                            Current Status
                        </small><br>

                        @if($referral->status == 'Pending')

                            <span class="badge bg-warning text-dark px-3 py-2">
                                Pending
                            </span>

                        @elseif($referral->status == 'Accepted')

                            <span class="badge bg-primary px-3 py-2">
                                Accepted
                            </span>

                        @elseif($referral->status == 'Completed')

                            <span class="badge bg-success px-3 py-2">
                                Completed
                            </span>

                        @elseif($referral->status == 'Rejected')

                            <span class="badge bg-danger px-3 py-2">
                                Rejected
                            </span>

                        @else

                            <span class="badge bg-info px-3 py-2">
                                {{ $referral->status }}
                            </span>

                        @endif

                    </div>

                    <div class="mb-4">

                        <small class="text-muted">
                            Priority
                        </small><br>

                        @if($referral->priority == 'Emergency')

                            <span class="badge bg-danger px-3 py-2">
                                Emergency
                            </span>

                        @elseif($referral->priority == 'Urgent')

                            <span class="badge bg-warning text-dark px-3 py-2">
                                Urgent
                            </span>

                        @else

                            <span class="badge bg-secondary px-3 py-2">
                                Normal
                            </span>

                        @endif

                    </div>

                    <div>

                        <small class="text-muted">
                            Created Date
                        </small>

                        <h6 class="mb-0">

                            {{ date('d-M-Y', strtotime($referral->created_at)) }}

                        </h6>

                    </div>

                </div>

            </div>

            <!-- Actions -->
            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Actions
                    </h5>

                </div>

                <div class="card-body">

                    <!-- Complete -->
                    <form action="{{ route('doctor.referrals.complete', $referral->id) }}"
                        method="POST"
                        class="mb-2">

                        @csrf

                        <button class="btn btn-success w-100">

                            <i class="fa fa-check me-1"></i>
                            Mark as Completed

                        </button>

                    </form>

                    <!-- Reject -->
                    <form action="{{ route('doctor.referrals.reject', $referral->id) }}"
                        method="POST"
                        class="mb-2">

                        @csrf

                        <button class="btn btn-danger w-100">

                            <i class="fa fa-times me-1"></i>
                            Reject Referral

                        </button>

                    </form>

                    <!-- Print -->
                    <button type="button"
                            onclick="window.print()"
                            class="btn btn-primary w-100">

                        <i class="fa fa-print me-1"></i>
                        Print Referral

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>
<style>

@media print {

    /* Hide sidebar/navbar/footer/buttons */
    .nxl-navigation,
    .nxl-header,
    .footer,
    .btn,
    .card-header,
    .d-flex.gap-2 {
        display: none !important;
    }

    /* Remove margins/padding */
    body {
        background: #fff !important;
    }

    .container-fluid {
        padding: 0 !important;
        margin: 0 !important;
    }

    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        margin-bottom: 15px !important;
    }

    /* Full width print */
    .col-lg-8,
    .col-lg-4 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }
}

</style>

@endsection
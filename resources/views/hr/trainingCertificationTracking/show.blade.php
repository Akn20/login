@extends('layouts.admin')

@section('page-title', 'View Training & Certification | ' . config('app.name'))

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div class="page-header-title">

        <h5 class="m-b-10 mb-1">

            <i class="feather-eye me-2"></i>
            Training & Certification Details

        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                HR
            </li>

            <li class="breadcrumb-item">

                <a
                    href="{{ route('hr.training-certification-tracking.index') }}"
                >
                    Training & Certification Tracking
                </a>

            </li>

            <li class="breadcrumb-item">
                View
            </li>

        </ul>

    </div>

    <div class="d-flex gap-2">

        <a
            href="{{ route('hr.training-certification-tracking.edit', $record->id) }}"
            class="btn btn-primary"
        >

            <i class="feather-edit me-1"></i>
            Edit

        </a>

        <a
            href="{{ route('hr.training-certification-tracking.index') }}"
            class="btn btn-light"
        >

            <i class="feather-arrow-left me-1"></i>
            Back

        </a>

    </div>

</div>

<div class="card">

    <div class="card-body">

        {{-- Employee Details --}}
        <h6 class="mb-3">
            Employee Details
        </h6>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Employee ID
                </label>

                <div class="fw-bold">
                    {{ $record->employee_id }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Employee Name
                </label>

                <div class="fw-bold">
                    {{ $record->employee_name }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Department
                </label>

                <div>
                    {{ $record->department ?? '-' }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Designation
                </label>

                <div>
                    {{ $record->designation ?? '-' }}
                </div>

            </div>

        </div>

        <hr>

        {{-- Training Details --}}
        <h6 class="mb-3">
            Training Details
        </h6>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Training Code
                </label>

                <div>
                    {{ $record->training_code }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Training Name
                </label>

                <div>
                    {{ $record->training_name }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Training Type
                </label>

                <div>
                    {{ $record->training_type ?? '-' }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Training Provider
                </label>

                <div>
                    {{ $record->training_provider ?? '-' }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Training Location
                </label>

                <div>
                    {{ $record->training_location ?? '-' }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Training Start Date
                </label>

           <div>
    {{ $record->training_start_date
        ? \Carbon\Carbon::parse($record->training_start_date)->format('d-m-Y')
        : '-' }}
</div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Training End Date
                </label>

        <div>
    {{ $record->training_end_date
        ? \Carbon\Carbon::parse($record->training_end_date)->format('d-m-Y')
        : '-' }}
</div>

            </div>

        </div>

        <hr>

        {{-- Certification Details --}}
        <h6 class="mb-3">
            Certification Details
        </h6>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Certification Name
                </label>

                <div>
                    {{ $record->certification_name ?? '-' }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Certification Number
                </label>

                <div>
                    {{ $record->certification_number ?? '-' }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Certification Authority
                </label>

                <div>
                    {{ $record->certification_authority ?? '-' }}
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Issue Date
                </label>

             <dd class="col-md-9">
    {{ \Carbon\Carbon::parse($record->issue_date)->format('d-m-Y') }}
</dd>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Expiry Date
                </label>

           <dd class="col-md-9">
    {{ \Carbon\Carbon::parse($record->expiry_date)->format('d-m-Y') }}
</dd>

            </div>

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Status
                </label>

                <div>

                    @if($record->status == 'Active')

                        <span class="badge bg-success">
                            Active
                        </span>

                    @elseif($record->status == 'Expired')

                        <span class="badge bg-danger">
                            Expired
                        </span>

                    @elseif($record->status == 'Expiring Soon')

                        <span class="badge bg-warning text-dark">
                            Expiring Soon
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            {{ $record->status }}
                        </span>

                    @endif

                </div>

            </div>

        </div>

        <hr>

        {{-- Reminder Details --}}
        <h6 class="mb-3">
            Reminder Details
        </h6>

        <div class="row">

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    Renewal Required
                </label>

                <div>
                    <strong>
                        {{ $record->renewal_required ? 'Yes' : 'No' }}
                    </strong>
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    Reminder Enabled
                </label>

                <div>
                    <strong>
                        {{ $record->reminder_enabled ? 'Yes' : 'No' }}
                    </strong>
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    Reminder Days
                </label>

                <div>
                    {{ $record->reminder_days ?? '-' }}
                </div>

            </div>

        </div>

        <hr>

        {{-- Remarks --}}
        <div class="mb-4">

            <label class="text-muted">
                Remarks
            </label>

            <div>
                {{ $record->remarks ?? '-' }}
            </div>

        </div>

        {{-- Attachment --}}
        <div>

            <label class="text-muted d-block mb-2">
                Attachment
            </label>

            @if($record->attachment)

                <div class="d-flex gap-2">

                    {{-- View --}}
                    <a
                        href="{{ asset('storage/'.$record->attachment) }}"
                        target="_blank"
                        class="btn btn-primary btn-sm"
                    >

                        <i class="feather-eye me-1"></i>
                        View

                    </a>

                    {{-- Download --}}
                    <a
                        href="{{ asset('storage/'.$record->attachment) }}"
                        download
                        class="btn btn-success btn-sm"
                    >

                        <i class="feather-download me-1"></i>
                        Download

                    </a>

                </div>

            @else

                <span class="text-muted">
                    No Attachment
                </span>

            @endif

        </div>

    </div>

</div>

@endsection
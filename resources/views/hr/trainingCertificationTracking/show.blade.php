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

<div class="card stretch">

    <div class="card-body">

        <dl class="row mb-0">

            {{-- Employee Details --}}
            <dt class="col-md-3">
                Employee ID
            </dt>

            <dd class="col-md-9">
                {{ $record->employee_id }}
            </dd>

            <dt class="col-md-3">
                Employee Name
            </dt>

            <dd class="col-md-9">
                {{ $record->employee_name }}
            </dd>

            <dt class="col-md-3">
                Department
            </dt>

            <dd class="col-md-9">
                {{ $record->department }}
            </dd>

            <dt class="col-md-3">
                Designation
            </dt>

            <dd class="col-md-9">
                {{ $record->designation }}
            </dd>

            {{-- Training Details --}}
            <dt class="col-md-3">
                Training Code
            </dt>

            <dd class="col-md-9">
                {{ $record->training_code }}
            </dd>

            <dt class="col-md-3">
                Training Name
            </dt>

            <dd class="col-md-9">
                {{ $record->training_name }}
            </dd>

            <dt class="col-md-3">
                Training Type
            </dt>

            <dd class="col-md-9">
                {{ $record->training_type ?? '-' }}
            </dd>

            <dt class="col-md-3">
                Training Provider
            </dt>

            <dd class="col-md-9">
                {{ $record->training_provider ?? '-' }}
            </dd>

            <dt class="col-md-3">
                Training Location
            </dt>

            <dd class="col-md-9">
                {{ $record->training_location ?? '-' }}
            </dd>

            <dt class="col-md-3">
                Training Start Date
            </dt>

            <dd class="col-md-9">
                {{ $record->training_start_date ?? '-' }}
            </dd>

            <dt class="col-md-3">
                Training End Date
            </dt>

            <dd class="col-md-9">
                {{ $record->training_end_date ?? '-' }}
            </dd>

            {{-- Certification Details --}}
            <dt class="col-md-3">
                Certification Name
            </dt>

            <dd class="col-md-9">
                {{ $record->certification_name ?? '-' }}
            </dd>

            <dt class="col-md-3">
                Certification Number
            </dt>

            <dd class="col-md-9">
                {{ $record->certification_number ?? '-' }}
            </dd>

            <dt class="col-md-3">
                Certification Authority
            </dt>

            <dd class="col-md-9">
                {{ $record->certification_authority ?? '-' }}
            </dd>

            <dt class="col-md-3">
                Issue Date
            </dt>

            <dd class="col-md-9">
                {{ $record->issue_date }}
            </dd>

            <dt class="col-md-3">
                Expiry Date
            </dt>

            <dd class="col-md-9">
                {{ $record->expiry_date }}
            </dd>

            {{-- Status --}}
            <dt class="col-md-3">
                Status
            </dt>

            <dd class="col-md-9">

                @if($record->status == 'Active')

                    <span class="badge bg-success">
                        Active
                    </span>

                @elseif($record->status == 'Expired')

                    <span class="badge bg-danger">
                        Expired
                    </span>

                @else

                    <span class="badge bg-warning">
                        {{ $record->status }}
                    </span>

                @endif

            </dd>

            {{-- Renewal --}}
            <dt class="col-md-3">
                Renewal Required
            </dt>

            <dd class="col-md-9">
                {{ $record->renewal_required ? 'Yes' : 'No' }}
            </dd>

            <dt class="col-md-3">
                Reminder Enabled
            </dt>

            <dd class="col-md-9">
                {{ $record->reminder_enabled ? 'Yes' : 'No' }}
            </dd>

            <dt class="col-md-3">
                Reminder Days
            </dt>

            <dd class="col-md-9">
                {{ $record->reminder_days ?? '-' }}
            </dd>

            {{-- Remarks --}}
            <dt class="col-md-3">
                Remarks
            </dt>

            <dd class="col-md-9">
                {{ $record->remarks ?? '-' }}
            </dd>

            {{-- Attachment --}}
            <dt class="col-md-3">
                Attachment
            </dt>

            <dd class="col-md-9">

               @if($record->attachment)

    <div class="d-flex gap-2">

        {{-- View --}}
        <a
            href="{{ asset('storage/'.$record->attachment) }}"
            target="_blank"
            class="btn btn-sm btn-primary"
        >
            <i class="feather-eye me-1"></i>
            View
        </a>

        {{-- Download --}}
        <a
            href="{{ asset('storage/'.$record->attachment) }}"
            download
            class="btn btn-sm btn-success"
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

            </dd>

        </dl>

    </div>

</div>

@endsection
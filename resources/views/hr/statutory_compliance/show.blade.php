@extends('layouts.admin')

@section(
    'page-title',
    'View Statutory Compliance | ' . config('app.name')
)

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div class="page-header-title">

        <h5 class="m-b-10 mb-1">

            <i class="feather-eye me-2"></i>
            Statutory Compliance Details

        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                HR
            </li>

            <li class="breadcrumb-item">

                <a
                    href="{{ route('hr.statutory-compliance.index') }}"
                >
                    Statutory Compliance
                </a>

            </li>

            <li class="breadcrumb-item">
                View
            </li>

        </ul>

    </div>

    <div class="d-flex gap-2">

        <a
            href="{{ route('hr.statutory-compliance.edit', $record->id) }}"
            class="btn btn-primary"
        >

            <i class="feather-edit me-1"></i>
            Edit

        </a>

        <a
            href="{{ route('hr.statutory-compliance.index') }}"
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

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    Employee ID
                </label>

                <div class="fw-bold">
                    {{ $record->employee_id }}
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    Employee Name
                </label>

                <div class="fw-bold">
                    {{ $record->employee_name }}
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    Department
                </label>

                <div>
                    {{ $record->department ?? '-' }}
                </div>

            </div>

        </div>

        <hr>

        {{-- PF Details --}}
        <h6 class="mb-3">
            PF Details
        </h6>

        <div class="row">

            <div class="col-md-3 mb-3">

                <label class="text-muted">
                    PF Applicable
                </label>

                <div>
                    {{ $record->pf_applicable ?? '-' }}
                </div>

            </div>

            <div class="col-md-3 mb-3">

                <label class="text-muted">
                    PF Number
                </label>

                <div>
                    {{ $record->pf_number ?? '-' }}
                </div>

            </div>

            <div class="col-md-3 mb-3">

                <label class="text-muted">
                    PF Amount
                </label>

                <div>
                    {{ $record->pf_amount ?? '-' }}
                </div>

            </div>

            <div class="col-md-3 mb-3">

                <label class="text-muted">
                    PF Start Date
                </label>

                <div>

                    {{ $record->pf_start_date
                        ? \Carbon\Carbon::parse($record->pf_start_date)->format('d-m-Y')
                        : '-' }}

                </div>

            </div>

        </div>

        <hr>

        {{-- ESI Details --}}
        <h6 class="mb-3">
            ESI Details
        </h6>

        <div class="row">

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    ESI Applicable
                </label>

                <div>
                    {{ $record->esi_applicable ?? '-' }}
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    ESI Number
                </label>

                <div>
                    {{ $record->esi_number ?? '-' }}
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    ESI Amount
                </label>

                <div>
                    {{ $record->esi_amount ?? '-' }}
                </div>

            </div>

        </div>

        <hr>

        {{-- Professional Tax --}}
        <h6 class="mb-3">
            Professional Tax Details
        </h6>

        <div class="row">

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    PT Applicable
                </label>

                <div>
                    {{ $record->pt_applicable ?? '-' }}
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    PT Amount
                </label>

                <div>
                    {{ $record->pt_amount ?? '-' }}
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    State Applicable
                </label>

                <div>
                    {{ $record->state_applicable ?? '-' }}
                </div>

            </div>

        </div>

        <hr>

        {{-- TDS Details --}}
        <h6 class="mb-3">
            TDS Details
        </h6>

        <div class="row">

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    TDS Applicable
                </label>

                <div>
                    {{ $record->tds_applicable ?? '-' }}
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    PAN Number
                </label>

                <div>
                    {{ $record->pan_number ?? '-' }}
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    TDS Percentage
                </label>

                <div>
                    {{ $record->tds_percentage ?? '-' }}
                </div>

            </div>

        </div>

        <hr>

        {{-- Contract Details --}}
        <h6 class="mb-3">
            Contract Details
        </h6>

        <div class="row">

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    Contract Start Date
                </label>

                <div>

                    {{ $record->contract_start_date
                        ? \Carbon\Carbon::parse($record->contract_start_date)->format('d-m-Y')
                        : '-' }}

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    Contract End Date
                </label>

                <div>

                    {{ $record->contract_end_date
                        ? \Carbon\Carbon::parse($record->contract_end_date)->format('d-m-Y')
                        : '-' }}

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <label class="text-muted">
                    Contract Status
                </label>

                <div>
                    {{ $record->contract_status ?? '-' }}
                </div>

            </div>

        </div>

        <hr>

        {{-- Medical License Details --}}
        <h6 class="mb-3">
            Medical License Details
        </h6>

        <div class="row">

            <div class="col-md-3 mb-3">

                <label class="text-muted">
                    License Number
                </label>

                <div>
                    {{ $record->license_number ?? '-' }}
                </div>

            </div>

            <div class="col-md-3 mb-3">

                <label class="text-muted">
                    License Issue Date
                </label>

                <div>

                    {{ $record->license_issue_date
                        ? \Carbon\Carbon::parse($record->license_issue_date)->format('d-m-Y')
                        : '-' }}

                </div>

            </div>

            <div class="col-md-3 mb-3">

                <label class="text-muted">
                    License Expiry Date
                </label>

                <div>

                    {{ $record->license_expiry_date
                        ? \Carbon\Carbon::parse($record->license_expiry_date)->format('d-m-Y')
                        : '-' }}

                </div>

            </div>

            <div class="col-md-3 mb-3">

                <label class="text-muted">
                    License Status
                </label>

                <div>
                    {{ $record->license_status ?? '-' }}
                </div>

            </div>

        </div>

        <hr>

        {{-- Additional Information --}}
        <h6 class="mb-3">
            Additional Information
        </h6>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="text-muted">
                    Remarks
                </label>

                <div>
                    {{ $record->remarks ?? '-' }}
                </div>

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

                    @else

                        <span class="badge bg-danger">
                            Inactive
                        </span>

                    @endif

                </div>

            </div>

        </div>

        <hr>

        {{-- License Upload --}}
        <div>

            <label class="text-muted d-block mb-2">
                License Upload
            </label>

            @if($record->license_upload)

                <div class="d-flex gap-2">

                    <a
                        href="{{ asset('storage/'.$record->license_upload) }}"
                        target="_blank"
                        class="btn btn-primary btn-sm"
                    >

                        <i class="feather-eye me-1"></i>
                        View

                    </a>

                    <a
                        href="{{ asset('storage/'.$record->license_upload) }}"
                        download
                        class="btn btn-success btn-sm"
                    >

                        <i class="feather-download me-1"></i>
                        Download

                    </a>

                </div>

            @else

                <span class="text-muted">
                    No License Uploaded
                </span>

            @endif

        </div>

    </div>

</div>

@endsection
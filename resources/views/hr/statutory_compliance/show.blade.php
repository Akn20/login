@extends('layouts.admin')

@section(
    'page-title',
    'View Statutory Compliance | ' . config('app.name')
)

@section('content')

<div class="nxl-content">

    {{-- Page Header --}}
    <div class="page-header">

        <div class="page-header d-flex align-items-center">

            <div class="page-header-title">

                <h5 class="m-b-10">
                    Statutory Compliance Details
                </h5>

            </div>

            <ul class="breadcrumb">

                <li class="breadcrumb-item">
                    HR
                </li>

                <li class="breadcrumb-item">
                    Statutory Compliance
                </li>

            </ul>

        </div>

        <div class="page-header-right ms-auto d-flex gap-2">

            <a
                href="{{ route('hr.statutory-compliance.edit', $record->id) }}"
                class="btn btn-primary"
            >
                Edit
            </a>

            <a
                href="{{ route('hr.statutory-compliance.index') }}"
                class="btn btn-light"
            >
                Back
            </a>

        </div>

    </div>

    {{-- Main Content --}}
    <div class="main-content">

        <div class="row">

            <div class="col-lg-12">

                <div class="card stretch stretch-full">

                    <div class="card-body">

                        <div class="row">

                            {{-- Employee ID --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    Employee ID
                                </label>

                                <div class="fw-semibold">
                                    {{ $record->employee_id }}
                                </div>

                            </div>

                            {{-- Employee Name --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    Employee Name
                                </label>

                                <div class="fw-semibold">
                                    {{ $record->employee_name }}
                                </div>

                            </div>

                            {{-- Department --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    Department
                                </label>

                                <div class="fw-semibold">
                                    {{ $record->department }}
                                </div>

                            </div>

                            {{-- PF Applicable --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    PF Applicable
                                </label>

                                <div>
                                    {{ $record->pf_applicable ?? '-' }}
                                </div>

                            </div>

                            {{-- PF Number --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    PF Number
                                </label>

                                <div>
                                    {{ $record->pf_number ?? '-' }}
                                </div>

                            </div>

                            {{-- PF Amount --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    PF Amount
                                </label>

                                <div>
                                    {{ $record->pf_amount ?? '-' }}
                                </div>

                            </div>

                            {{-- PF Start Date --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    PF Start Date
                                </label>

                                <div>
                                    {{ $record->pf_start_date ?? '-' }}
                                </div>

                            </div>

                            {{-- ESI Applicable --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    ESI Applicable
                                </label>

                                <div>
                                    {{ $record->esi_applicable ?? '-' }}
                                </div>

                            </div>

                            {{-- ESI Number --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    ESI Number
                                </label>

                                <div>
                                    {{ $record->esi_number ?? '-' }}
                                </div>

                            </div>

                            {{-- ESI Amount --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    ESI Amount
                                </label>

                                <div>
                                    {{ $record->esi_amount ?? '-' }}
                                </div>

                            </div>

                            {{-- PT Applicable --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    PT Applicable
                                </label>

                                <div>
                                    {{ $record->pt_applicable ?? '-' }}
                                </div>

                            </div>

                            {{-- PT Amount --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    PT Amount
                                </label>

                                <div>
                                    {{ $record->pt_amount ?? '-' }}
                                </div>

                            </div>

                            {{-- State Applicable --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    State Applicable
                                </label>

                                <div>
                                    {{ $record->state_applicable ?? '-' }}
                                </div>

                            </div>

                            {{-- TDS Applicable --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    TDS Applicable
                                </label>

                                <div>
                                    {{ $record->tds_applicable ?? '-' }}
                                </div>

                            </div>

                            {{-- PAN Number --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    PAN Number
                                </label>

                                <div>
                                    {{ $record->pan_number ?? '-' }}
                                </div>

                            </div>

                            {{-- TDS Percentage --}}
                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    TDS Percentage
                                </label>

                                <div>
                                    {{ $record->tds_percentage ?? '-' }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
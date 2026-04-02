@extends('layouts.admin')

@section('page-title', 'Hourly Pay Details')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5 class="mb-1">Work Type Details</h5>

    <a href="{{ route('hr.payroll.hourly-pay.index') }}" class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <div class="row">
<div class="col-md-6 mb-3">
    <label class="text-muted">Work Type Code</label>
    <div class="fw-bold">{{ $hourlyPay->code }}</div>
</div>
            <div class="col-md-6 mb-3">
                <label class="text-muted">Work Type</label>
                <div class="fw-bold">{{ $hourlyPay->name }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Category</label>
                <div>
                    <span class="badge bg-soft-primary text-primary">
                        {{ $hourlyPay->category }}
                    </span>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Earnings Type</label>
                <div>
                    <span class="badge bg-soft-info text-info">
                        {{ ucfirst($hourlyPay->earning_type) }}
                    </span>
                </div>
            </div>

        </div>

        <hr>

        <h6>Payroll Configuration</h6>

        <div class="row">

            <div class="col-md-4 mb-2">
                Taxable:
                <strong class="{{ $hourlyPay->is_taxable ? 'text-success' : 'text-danger' }}">
                    {{ $hourlyPay->is_taxable ? 'Yes' : 'No' }}
                </strong>
            </div>

            <div class="col-md-4 mb-2">
                PF:
                <strong class="{{ $hourlyPay->pf_applicable ? 'text-success' : 'text-danger' }}">
                    {{ $hourlyPay->pf_applicable ? 'Yes' : 'No' }}
                </strong>
            </div>

            <div class="col-md-4 mb-2">
                ESI:
                <strong class="{{ $hourlyPay->esi_applicable ? 'text-success' : 'text-danger' }}">
                    {{ $hourlyPay->esi_applicable ? 'Yes' : 'No' }}
                </strong>
            </div>

            <div class="col-md-4 mb-2">
                PT:
                <strong class="{{ $hourlyPay->pt_applicable ? 'text-success' : 'text-danger' }}">
                    {{ $hourlyPay->pt_applicable ? 'Yes' : 'No' }}
                </strong>
            </div>

            <div class="col-md-4 mb-2">
                Prorata:
                <strong class="{{ $hourlyPay->is_prorata ? 'text-success' : 'text-danger' }}">
                    {{ $hourlyPay->is_prorata ? 'Yes' : 'No' }}
                </strong>
            </div>

            <div class="col-md-4 mb-2">
                LOP Impact:
                <strong class="{{ $hourlyPay->lop_impact ? 'text-success' : 'text-danger' }}">
                    {{ $hourlyPay->lop_impact ? 'Yes' : 'No' }}
                </strong>
            </div>

        </div>

        <hr>

        <h6>Payslip Configuration</h6>

        <div class="row">

            <div class="col-md-4 mb-2">
                Show in Payslip:
                <strong>{{ $hourlyPay->show_in_payslip ? 'Yes' : 'No' }}</strong>
            </div>

            <div class="col-md-4 mb-2">
                Label:
                <strong>{{ $hourlyPay->payslip_label ?? '-' }}</strong>
            </div>

            <div class="col-md-4 mb-2">
                Display Order:
                <strong>{{ $hourlyPay->display_order }}</strong>
            </div>

        </div>

    </div>
</div>

@endsection
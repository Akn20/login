@extends('layouts.admin')

@section('page-title', 'Payroll Earnings')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>View Earning</h5>

    <a href="{{ route('hr.payroll.payroll-result-earnings.index') }}"
       class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <h6 class="mb-3">Earning Details</h6>

        <div class="row mb-3">

            <div class="col-md-4">
                <label class="text-muted">Code</label>
                <div>{{ $record->earning_code }}</div>
            </div>

            <div class="col-md-4">
                <label class="text-muted">Name</label>
                <div>{{ $record->earning_name }}</div>
            </div>

            <div class="col-md-4">
                <label class="text-muted">Type</label>
                <div>{{ $record->earning_type }}</div>
            </div>

            <div class="col-md-4 mt-3">
                <label class="text-muted">Amount</label>
                <div>₹ {{ $record->amount }}</div>
            </div>

            <div class="col-md-4 mt-3">
                <label class="text-muted">Calculation Base</label>
                <div>{{ $record->calculation_base ?? '-' }}</div>
            </div>

            <div class="col-md-4 mt-3">
                <label class="text-muted">Calculation Value</label>
                <div>{{ $record->calculation_value ?? '-' }}</div>
            </div>

        </div>

        <hr>

        <h6 class="mb-3">Statutory</h6>

        <div class="row">

            <div class="col-md-4">
                <label class="text-muted">Taxable</label>
                <div>{{ $record->taxable ? 'Yes' : 'No' }}</div>
            </div>

            <div class="col-md-4">
                <label class="text-muted">PF</label>
                <div>{{ $record->pf_applicable ? 'Yes' : 'No' }}</div>
            </div>

            <div class="col-md-4">
                <label class="text-muted">ESI</label>
                <div>{{ $record->esi_applicable ? 'Yes' : 'No' }}</div>
            </div>

        </div>

    </div>
</div>

@endsection
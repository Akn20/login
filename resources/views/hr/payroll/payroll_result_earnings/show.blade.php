@extends('layouts.admin')

@section('page-title', 'Payroll Earnings')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>
        <h5 class="mb-1">View Earning</h5>
    </div>

    <a href="{{ route('hr.payroll.payroll-result-earnings.index') }}"
       class="btn btn-secondary btn-sm">
        Back
    </a>

</div>

<div class="card">
<div class="card-body">

    {{-- PAYROLL RESULT DETAILS --}}
    <h6 class="mb-3">Payroll Result Information</h6>

    <div class="row mb-4">

        

        <div class="col-md-4">
            <label class="text-muted">Payroll Month</label>

            <div>
                {{ $record->payrollResult->payroll_month ?? '-' }}
            </div>
        </div>

        <div class="col-md-4">
            <label class="text-muted">Payroll Run</label>

            <div>
                {{ $record->payrollResult->payroll_run_id ?? '-' }}
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <label class="text-muted">Employee</label>

            <div>
                {{ $record->payrollResult->staff_id ?? '-' }}
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <label class="text-muted">Payroll Status</label>

            <div>

                @if(($record->payrollResult->status ?? '') == 'Locked')

                    <span class="badge bg-soft-danger text-danger">
                        Locked
                    </span>

                @else

                    <span class="badge bg-soft-success text-success">
                        {{ $record->payrollResult->status ?? '-' }}
                    </span>

                @endif

            </div>
        </div>

    </div>

    <hr>

    {{-- EARNING DETAILS --}}
    <h6 class="mb-3">Earning Details</h6>

    <div class="row mb-4">

        <div class="col-md-4">
            <label class="text-muted">Earning Code</label>

            <div>
                {{ $record->earning_code }}
            </div>
        </div>

        <div class="col-md-4">
            <label class="text-muted">Earning Name</label>

            <div>
                {{ $record->earning_name }}
            </div>
        </div>

        <div class="col-md-4">
            <label class="text-muted">Earning Type</label>

            <div>
                {{ $record->earning_type }}
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <label class="text-muted">Amount</label>

            <div>
                ₹ {{ number_format($record->amount, 2) }}
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <label class="text-muted">Calculation Base</label>

            <div>
                {{ $record->calculation_base ?? '-' }}
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <label class="text-muted">Calculation Value</label>

            <div>
                {{ $record->calculation_value ?? '-' }}
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <label class="text-muted">Display Order</label>

            <div>
                {{ $record->display_order ?? '-' }}
            </div>
        </div>

    </div>

    <hr>

    {{-- STATUTORY --}}
    <h6 class="mb-3">Statutory Flags</h6>

    <div class="row mb-4">

        <div class="col-md-4">
            <label class="text-muted">Taxable</label>

            <div>
                {{ $record->taxable ? 'Yes' : 'No' }}
            </div>
        </div>

        <div class="col-md-4">
            <label class="text-muted">PF Applicable</label>

            <div>
                {{ $record->pf_applicable ? 'Yes' : 'No' }}
            </div>
        </div>

        <div class="col-md-4">
            <label class="text-muted">ESI Applicable</label>

            <div>
                {{ $record->esi_applicable ? 'Yes' : 'No' }}
            </div>
        </div>

    </div>

    <hr>

    {{-- AUDIT --}}
    <h6 class="mb-3">Audit Information</h6>

    <div class="row">

        <div class="col-md-4">
            <label class="text-muted">Created At</label>

            <div>
                {{ $record->created_at }}
            </div>
        </div>

        <div class="col-md-4">
            <label class="text-muted">Updated At</label>

            <div>
                {{ $record->updated_at }}
            </div>
        </div>

        <div class="col-md-4">
          
        </div>

    </div>

</div>
</div>

@endsection
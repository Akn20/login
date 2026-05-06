@extends('layouts.admin')

@section('page-title', 'Payroll Deductions')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">

    <h5 class="mb-0">View Deduction</h5>

    <a href="{{ route('hr.payroll.payroll-result-deductions.index') }}"
       class="btn btn-secondary btn-sm">

        Back

    </a>

</div>


@if(session('error'))

<div class="alert alert-danger">
    {{ session('error') }}
</div>

@endif


<div class="card">

    <div class="card-body">

        {{-- PAYROLL DETAILS --}}
        <h6 class="mb-3">Payroll Details</h6>

        <div class="row mb-4">

            {{-- PAYROLL MONTH --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Payroll Month</label>

                <div>

                    <span class="badge bg-soft-dark text-dark">

                        {{ optional($record->payrollResult)->payroll_month ?? '-' }}

                    </span>

                </div>

            </div>


            {{-- EMPLOYEE --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Employee</label>

                <div>

                    <span class="badge bg-soft-primary text-primary">

                        {{ optional(optional($record->payrollResult)->employee)->name ?? optional($record->payrollResult)->staff_id ?? '-' }}

                    </span>

                </div>

            </div>


            {{-- PAYROLL STATUS --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Payroll Status</label>

                <div>

                    @if(optional($record->payrollResult)->status == 'finalized')

                        <span class="badge bg-soft-success text-success">
                            Finalized
                        </span>

                    @else

                        <span class="badge bg-soft-warning text-warning">

                            {{ ucfirst(optional($record->payrollResult)->status ?? 'Draft') }}

                        </span>

                    @endif

                </div>

            </div>

        </div>

        <hr>


        {{-- DEDUCTION DETAILS --}}
        <h6 class="mb-3">Deduction Details</h6>

        <div class="row mb-4">

            {{-- CODE --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Deduction Code</label>

                <div>

                    <span class="badge bg-soft-info text-info">

                        {{ $record->deduction_code }}

                    </span>

                </div>

            </div>


            {{-- NAME --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Deduction Name</label>

                <div>

                    {{ $record->deduction_name }}

                </div>

            </div>


            {{-- TYPE --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Deduction Type</label>

                <div>

                    @if($record->deduction_type == 'Fixed')

                        <span class="badge bg-soft-success text-success">
                            Fixed
                        </span>

                    @elseif($record->deduction_type == 'Variable')

                        <span class="badge bg-soft-warning text-warning">
                            Variable
                        </span>

                    @else

                        <span class="badge bg-soft-danger text-danger">
                            Statutory
                        </span>

                    @endif

                </div>

            </div>

        </div>

        <hr>


        {{-- CALCULATION DETAILS --}}
        <h6 class="mb-3">Calculation Details</h6>

        <div class="row mb-4">

            {{-- RULE SET --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Rule Set Code</label>

                <div>

                    {{ $record->rule_set_code ?? '-' }}

                </div>

            </div>


            {{-- CALCULATION LOGIC --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Calculation Logic</label>

                <div>

                    {{ $record->calculation_logic ?? '-' }}

                </div>

            </div>


            {{-- DISPLAY ORDER --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Display Order</label>

                <div>

                    {{ $record->display_order ?? '-' }}

                </div>

            </div>

        </div>

        <hr>


        {{-- AMOUNT DETAILS --}}
        <h6 class="mb-3">Amount Details</h6>

        <div class="row">

            {{-- AMOUNT --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Amount</label>

                <div>

                    ₹ {{ number_format($record->amount, 2) }}

                </div>

            </div>


            {{-- EDITABLE --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Editable</label>

                <div>

                    @if($record->editable_flag)

                        <span class="badge bg-soft-success text-success">
                            Yes
                        </span>

                    @else

                        <span class="badge bg-soft-danger text-danger">
                            No
                        </span>

                    @endif

                </div>

            </div>


            {{-- CREATED DATE --}}
            <div class="col-md-4 mb-3">

                <label class="text-muted">Created Date</label>

                <div>

                    {{ optional($record->created_at)->format('d-m-Y') ?? '-' }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Payroll Deductions')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    
    <h5>View Deduction</h5>

    <a href="{{ route('hr.payroll.payroll-result-deductions.index') }}"
       class="btn btn-secondary btn-sm">
        Back
    </a>

</div>

<div class="card">

    <div class="card-body">

        <!-- BASIC DETAILS -->
        <h6 class="mb-3">Deduction Details</h6>

        <div class="row mb-3">

            <!-- CODE -->
            <div class="col-md-4">
                <label class="text-muted">Deduction Code</label>

                <div>
                    {{ $record->deduction_code }}
                </div>
            </div>

            <!-- NAME -->
            <div class="col-md-4">
                <label class="text-muted">Deduction Name</label>

                <div>
                    {{ $record->deduction_name }}
                </div>
            </div>

            <!-- TYPE -->
            <div class="col-md-4">
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

        <!-- RULE SECTION -->
        <h6 class="mb-3">Rule Details</h6>

        <div class="row mb-3">

            <!-- RULE SET -->
            <div class="col-md-4">
                <label class="text-muted">Rule Set Code</label>

                <div>
                    {{ $record->rule_set_code ?? '-' }}
                </div>
            </div>

            <!-- CALCULATION LOGIC -->
            <div class="col-md-4">
                <label class="text-muted">Calculation Logic</label>

                <div>
                    {{ $record->calculation_logic }}
                </div>
            </div>

            <!-- DISPLAY ORDER -->
            <div class="col-md-4">
                <label class="text-muted">Display Order</label>

                <div>
                    {{ $record->display_order ?? '-' }}
                </div>
            </div>

        </div>

        <hr>

        <!-- AMOUNT SECTION -->
        <h6 class="mb-3">Amount Details</h6>

        <div class="row mb-3">

            <!-- AMOUNT -->
            <div class="col-md-4">
                <label class="text-muted">Amount</label>

                <div>
                    ₹ {{ $record->amount }}
                </div>
            </div>

            <!-- EDITABLE -->
            <div class="col-md-4">
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

            <!-- CREATED DATE -->
            <div class="col-md-4">
                <label class="text-muted">Created Date</label>

                <div>
                    {{ $record->created_at->format('d-m-Y') }}
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
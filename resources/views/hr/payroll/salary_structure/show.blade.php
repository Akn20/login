@extends('layouts.admin')

@section('page-title', 'Salary Structure Details')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5 class="mb-1">Salary Structure Details</h5>

    <a href="{{ route('hr.payroll.salary-structure.index') }}" class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <!-- BASIC DETAILS -->
        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="text-muted">Structure Code</label>
                <div class="fw-bold">{{ $record->salary_structure_code }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Structure Name</label>
                <div class="fw-bold">{{ $record->salary_structure_name }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Category</label>
                <div>{{ ucfirst($record->structure_category) }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Status</label>
                <div>
                    @if($record->status == 'active')
                        <span class="text-success">Active</span>
                    @else
                        <span class="text-danger">Inactive</span>
                    @endif
                </div>
            </div>

            <!-- Effective Dates -->
            <div class="col-md-6 mb-3">
                <label class="text-muted">Effective From</label>
                <div>
                    {{ $record->effective_from ? \Carbon\Carbon::parse($record->effective_from)->format('d-m-Y') : '-' }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Effective To</label>
                <div>
                    {{ $record->effective_to ? \Carbon\Carbon::parse($record->effective_to)->format('d-m-Y') : '-' }}
                </div>
            </div>

        </div>

        <hr>

        <!-- EARNINGS -->
        <h6>Earnings Setup</h6>

        <div class="row">

            <!-- Fixed Allowances -->
            <div class="col-md-6 mb-3">
                <label class="text-muted">Fixed Allowances</label>
                <div>
                    @php
                        $allowances = \App\Models\Allowance::whereIn('id', $record->fixed_allowance_components ?? [])->pluck('display_name');
                    @endphp
                    {{ $allowances->isNotEmpty() ? implode(', ', $allowances->toArray()) : '-' }}
                </div>
            </div>

            <!-- Residual -->
            <div class="col-md-6 mb-3">
                <label class="text-muted">Residual Component</label>
                <div>
                    {{ optional(\App\Models\Allowance::find($record->residual_component_id))->display_name ?? '-' }}
                </div>
            </div>

            <!-- Variable Allowance -->
            <div class="col-md-6 mb-3">
                <label class="text-muted">Variable Allowance</label>
                <div>
                    <strong>{{ $record->variable_allowance_allowed ? 'Yes' : 'No' }}</strong>
                </div>
            </div>

        </div>

        <hr>

        <!-- DEDUCTIONS -->
        <h6>Deductions Setup</h6>

        <div class="row">

            <!-- Fixed Deductions -->
            <div class="col-md-6 mb-3">
                <label class="text-muted">Fixed Deductions</label>
                <div>
                    @php
                        $deductions = \App\Models\PayrollDeduction::whereIn('id', $record->fixed_deduction_components ?? [])->pluck('display_name');
                    @endphp
                    {{ $deductions->isNotEmpty() ? implode(', ', $deductions->toArray()) : '-' }}
                </div>
            </div>

            <!-- Variable Deduction -->
            <div class="col-md-6 mb-3">
                <label class="text-muted">Variable Deduction</label>
                <div>
                    <strong>{{ $record->variable_deduction_allowed ? 'Yes' : 'No' }}</strong>
                </div>
            </div>

        </div>

        <hr>

        <!-- TIME BASED -->
        <h6>Time Based</h6>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="text-muted">Hourly Pay</label>
                <div>
                    <strong>{{ $record->hourly_pay_eligible ? 'Yes' : 'No' }}</strong>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Overtime</label>
                <div>
                    <strong>{{ $record->overtime_eligible ? 'Yes' : 'No' }}</strong>
                </div>
            </div>
        <div class="col-md-6 mb-3">
    <label class="text-muted">Allowed Work Types</label>
    <div>
        @php
            $workTypes = \App\Models\HourlyPay::whereIn('id', $record->allowed_work_types ?? [])
                            ->pluck('name');
        @endphp

        {{ $workTypes->isNotEmpty() ? implode(', ', $workTypes->toArray()) : '-' }}
    </div>
</div>
        </div>

        <hr>

        <!-- STATUTORY -->
        <h6>Statutory</h6>

        <div class="row">

            <div class="col-md-3">
                PF: <strong>{{ $record->pf_applicable ? 'Yes' : 'No' }}</strong>
            </div>

            <div class="col-md-3">
                ESI: <strong>{{ $record->esi_applicable ? 'Yes' : 'No' }}</strong>
            </div>

            <div class="col-md-3">
                PT: <strong>{{ $record->pt_applicable ? 'Yes' : 'No' }}</strong>
            </div>

            <div class="col-md-3">
                TDS: <strong>{{ $record->tds_applicable ? 'Yes' : 'No' }}</strong>
            </div>

        </div>

    </div>
</div>

@endsection
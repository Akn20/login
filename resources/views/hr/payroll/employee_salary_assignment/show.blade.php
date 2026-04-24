@extends('layouts.admin')

@section('page-title', 'Employee Salary Assignment')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>View Salary Assignment</h5>

    <a href="{{ route('hr.payroll.employee-salary-assignment.index') }}"
       class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <!-- BASIC INFO -->
        <h6 class="mb-3">Basic Information</h6>

        <div class="row mb-3">

            <div class="col-md-6">
                <label class="text-muted">Employee</label>
                <div>{{ $record->employee->name ?? '-' }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted">Salary Structure</label>
                <div>{{ $record->structure->salary_structure_name ?? '-' }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted">Salary Amount</label>
                <div>₹ {{ $record->salary_amount }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted">Currency</label>
                <div>{{ $record->currency }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted">Salary Basis</label>
                <div>{{ $record->salary_basis }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted">Pay Frequency</label>
                <div>{{ $record->pay_frequency }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted">Status</label>
                <div>
                    @if($record->status == 'active')
                        <span class="badge bg-soft-success text-success">Active</span>
                    @else
                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                    @endif
                </div>
            </div>

        </div>

        <hr>

        <!-- DATE -->
        <h6 class="mb-3">Date Range</h6>

        <div class="row mb-3">

            <div class="col-md-6">
                <label class="text-muted">Effective From</label>
                <div>{{ $record->effective_from }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted">Effective To</label>
                <div>{{ $record->effective_to ?? '-' }}</div>
            </div>

        </div>

        <hr>

        <!-- WORK -->
        <h6 class="mb-3">Work Conditions</h6>

        <div class="row">

            <div class="col-md-4">
                <label class="text-muted">Hourly Pay</label>
                <div>{{ (int)$record->hourly_pay_eligible === 1 ? 'Yes' : 'No' }}</div>
            </div>

            <div class="col-md-4">
                <label class="text-muted">Overtime</label>
               <div>{{ (int)$record->overtime_eligible === 1 ? 'Yes' : 'No' }}</div>
            </div>
<div class="col-md-12 mt-3">
    <label class="text-muted">Work Types</label>
    <div>

        @php
            $workTypeIds = is_array($record->allowed_work_types)
                ? $record->allowed_work_types
                : json_decode($record->allowed_work_types ?? '[]', true);

            $workTypeNames = \App\Models\HourlyPay::whereIn('id', $workTypeIds ?? [])
                ->pluck('name')
                ->toArray();
        @endphp

        @if(!empty($workTypeNames))
            @foreach($workTypeNames as $name)
                <span class="badge bg-soft-info text-info me-1">
                    {{ $name }}
                </span>
            @endforeach
        @else
            <span class="text-muted">-</span>
        @endif

    </div>
</div>

        </div>

    </div>
</div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Deduction Rule Details')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5 class="mb-1">Deduction Rule Details</h5>

    <a href="{{ route('hr.payroll.deduction-rule-set.index') }}" class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="text-muted">Rule Code</label>
                <div class="fw-bold">{{ $rule->rule_set_code }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Rule Name</label>
                <div class="fw-bold">{{ $rule->rule_set_name }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Category</label>
                <div>{{ $rule->rule_category }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Calculation Type</label>
                <div>{{ $rule->calculation_type }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Calculation Base</label>
                <div>{{ $rule->calculation_base }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Calculation Value</label>
                <div>{{ $rule->calculation_value }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Applies On</label>
                <div>{{ $rule->calculation_applies_on }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Max Limit</label>
                <div>{{ $rule->maximum_limit }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="text-muted">Min Limit</label>
                <div>{{ $rule->minimum_limit }}</div>
            </div>

        </div>

        <hr>

        <h6>Payroll Behaviour</h6>

        <div class="row">

            <div class="col-md-4 mb-2">
                Prorata:
                <strong>{{ $rule->prorata_applicable ? 'Yes' : 'No' }}</strong>
            </div>

            <div class="col-md-4 mb-2">
                LOP Impact:
                <strong>{{ $rule->lop_impact ? 'Yes' : 'No' }}</strong>
            </div>

            <div class="col-md-4 mb-2">
                Editable:
                <strong>{{ $rule->editable_at_payroll ? 'Yes' : 'No' }}</strong>
            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-4 mb-3">
                <label class="text-muted">Priority</label>
                <div>{{ $rule->priority }}</div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="text-muted">Max % of Net Salary</label>
                <div>{{ $rule->max_percent_net_salary }}</div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="text-muted">Status</label>
                <div>
                    @if($rule->status == 'active')
                        <span class="text-success">Active</span>
                    @else
                        <span class="text-danger">Inactive</span>
                    @endif
                </div>
            </div>

        </div>

        <hr>

        <div>
            <label class="text-muted">Remarks</label>
            <div>{{ $rule->remarks }}</div>
        </div>

    </div>
</div>

@endsection
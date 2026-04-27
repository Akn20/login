@extends('layouts.admin')

@section('page-title', 'Edit Deduction Rule')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <h5 class="mb-1">Edit Deduction Rule</h5>

    <a href="{{ route('hr.payroll.deduction-rule-set.index') }}" class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.deduction-rule-set.update', $rule->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('hr.payroll.deduction_rule_set.form')

        </form>

    </div>
</div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Add Deduction Rule')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>Add Deduction Rule</h5>

    <a href="{{ route('hr.payroll.deduction-rule-set.index') }}" class="btn btn-light">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.deduction-rule-set.store') }}" method="POST">
            @csrf

            @include('hr.payroll.deduction_rule_set.form')

        </form>

    </div>
</div>

@endsection
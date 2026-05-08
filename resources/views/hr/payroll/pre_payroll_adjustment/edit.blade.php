@extends('layouts.admin')

@section('page-title', 'Edit Pre Payroll Adjustment')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>Edit Pre Payroll Adjustment</h5>

    <a href="{{ route('hr.payroll.pre-payroll.index') }}" class="btn btn-light">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.pre-payroll.update', $record->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('hr.payroll.pre_payroll_adjustment.form')

        </form>

    </div>
</div>

@endsection
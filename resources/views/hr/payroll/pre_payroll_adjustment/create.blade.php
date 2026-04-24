@extends('layouts.admin')

@section('page-title', 'Add Pre Payroll Adjustment')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>Add Pre Payroll Adjustment</h5>
<a href="{{ route('hr.pre-payroll.index') }}" class="btn btn-light">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

    <form action="{{ route('hr.pre-payroll.store') }}" method="POST">
            @csrf

            @include('hr.payroll.pre_payroll_adjustment.form')

        </form>

    </div>
</div>

@endsection
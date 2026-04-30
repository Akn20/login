@extends('layouts.admin')

@section('page-title', 'Payroll Deductions')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>Add Deduction</h5>

    <a href="{{ route('hr.payroll.payroll-result-deductions.index') }}"
       class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.payroll-result-deductions.store') }}"
              method="POST">

            @csrf

            @include('hr.payroll.payroll_result_deductions.form')

        </form>

    </div>
</div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Payroll Deductions')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>Edit Deduction</h5>

    <a href="{{ route('hr.payroll.payroll-result-deductions.index') }}"
       class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.payroll-result-deductions.update', $record->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            @include('hr.payroll.payroll_result_deductions.form')

        </form>

    </div>
</div>

@endsection
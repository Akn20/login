@extends('layouts.admin')

@section('page-title', 'Add Statutory Deduction')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5>Add Statutory Deduction</h5>

    <a href="{{ route('hr.payroll.statutory-deduction.index') }}" class="btn btn-light">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.statutory-deduction.store') }}" method="POST">
            @csrf

            @include('hr.payroll.statutory_deduction.form', [
                'record' => null
            ])

        </form>

    </div>
</div>

@endsection
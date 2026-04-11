@extends('layouts.admin')

@section('page-title', 'Edit Statutory Deduction')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5>Edit Statutory Deduction</h5>

    <a href="{{ route('hr.payroll.statutory-deduction.index') }}" class="btn btn-light">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.statutory-deduction.update', $record->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('hr.payroll.statutory_deduction.form', [
                'record' => $record
            ])

        </form>

    </div>
</div>

@endsection
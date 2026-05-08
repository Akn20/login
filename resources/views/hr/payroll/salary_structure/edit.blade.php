@extends('layouts.admin')

@section('page-title', 'Edit Salary Structure')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <h5 class="mb-1">Edit Salary Structure</h5>

    <a href="{{ route('hr.payroll.salary-structure.index') }}" class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.salary-structure.update', $record->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('hr.payroll.salary_structure.form')

        </form>

    </div>
</div>

@endsection
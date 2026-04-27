@extends('layouts.admin')

@section('page-title', 'Add Salary Structure')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between">
    <h5>Add Salary Structure</h5>

    <a href="{{ route('hr.payroll.salary-structure.index') }}" class="btn btn-light">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.salary-structure.store') }}" method="POST">
            @csrf

            @include('hr.payroll.salary_structure.form')

        </form>

    </div>
</div>

@endsection
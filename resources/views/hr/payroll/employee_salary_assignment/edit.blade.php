@extends('layouts.admin')

@section('page-title', 'Edit Employee Salary Assignment')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.employee-salary-assignment.update', $record->id) }}" method="POST">
    @csrf
    @method('PUT')

    @include('hr.payroll.employee_salary_assignment.form')

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('hr.payroll.employee-salary-assignment.index') }}" class="btn btn-light ms-2">Cancel</a>
    </div>
</form>

@endsection
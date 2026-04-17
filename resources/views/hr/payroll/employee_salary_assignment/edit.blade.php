@extends('layouts.admin')

@section('page-title', 'Add Employee Salary Assignment')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('hr.payroll.employee-salary-assignment.store') }}" method="POST">
            @csrf

            @include('hr.payroll.employee_salary_assignment.form')

        </form>

    </div>
</div>

@endsection
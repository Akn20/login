@extends('layouts.admin')

@section('page-title', 'View Salary Assignment')

@section('content')

<div class="card">
    <div class="card-body">

        <p><strong>Employee:</strong> {{ $record->employee->name ?? '' }}</p>
        <p><strong>Structure:</strong> {{ $record->salaryStructure->salary_structure_name ?? '' }}</p>
        <p><strong>Salary:</strong> {{ $record->salary_amount }}</p>
        <p><strong>Frequency:</strong> {{ $record->pay_frequency }}</p>
        <p><strong>Status:</strong> {{ $record->status }}</p>

        <a href="{{ route('hr.payroll.employee-salary-assignment.index') }}" class="btn btn-secondary btn-sm">Back</a>

    </div>
</div>

@endsection
@extends('layouts.admin')

@section('content')

<div class="container">
    <h3 class="mb-4">HR Reports Dashboard</h3>

    <div class="row">

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.reports.staff-strength') }}" class="card p-3 text-center">
                <h5>Staff Strength</h5>
                <p>View total employees</p>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.reports.attendance') }}" class="card p-3 text-center">
                <h5>Attendance Report</h5>
                <p>Track attendance</p>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.reports.leave') }}" class="card p-3 text-center">
                <h5>Leave Report</h5>
                <p>Manage leaves</p>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.reports.payroll') }}" class="card p-3 text-center">
                <h5>Payroll Report</h5>
                <p>Salary details</p>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.reports.overtime') }}" class="card p-3 text-center">
                <h5>Overtime Report</h5>
                <p>Extra working hours</p>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.reports.department-salary') }}" class="card p-3 text-center">
                <h5>Department Salary</h5>
                <p>Department-wise salary</p>
            </a>
        </div>

    </div>
</div>

@endsection
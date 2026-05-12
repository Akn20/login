@extends('layouts.admin')

@section('content')

<div class="container">
    <h3>Staff Strength Report</h3>

    <div class="row mb-3">
        <div class="col-md-3">Total Staff: {{ $totalStaff }}</div>
        <div class="col-md-3">Active: {{ $activeStaff }}</div>
        <div class="col-md-3">Inactive: {{ $inactiveStaff }}</div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $s)
            <tr>
                <td>{{ $s->employee_id }}</td>
                <td>{{ $s->name }}</td>
                <td>{{ $s->department->department_name ?? '-' }}</td>
                <td>{{ $s->designation->designation_name ?? '-' }}</td>
                <td>{{ $s->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
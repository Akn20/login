@extends('layouts.admin')

@section('content')

<div class="container">
    <h3 class="mb-3">Attendance Report</h3>

    {{-- 🔍 FILTERS --}}
    <form method="GET" class="row mb-3">

        <div class="col-md-3">
            <input type="date" name="from_date" class="form-control" placeholder="From Date">
        </div>

        <div class="col-md-3">
            <input type="date" name="to_date" class="form-control" placeholder="To Date">
        </div>

        <div class="col-md-3">
            <select name="department_id" class="form-control">
                <option value="">All Departments</option>
                @foreach($departments as $d)
                    <option value="{{ $d->id }}">{{ $d->department_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
                <option value="Late">Late</option>
            </select>
        </div>

        <div class="col-md-1">
            <button class="btn btn-primary">Go</button>
        </div>

    </form>

    {{-- 📊 SUMMARY --}}
    <div class="row mb-3">
        <div class="col-md-3">Total Days: {{ $totalDays }}</div>
        <div class="col-md-3">Present: {{ $presentDays }}</div>
        <div class="col-md-3">Absent: {{ $absentDays }}</div>
        <div class="col-md-3">Attendance %: {{ $attendancePercentage }}%</div>
    </div>

    <div class="d-flex justify-content-end mb-3">
    <div class="dropdown">
        <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="feather-download me-1"></i> Export
        </button>

        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item text-success"
                   href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}">
                    <i class="feather-file-text me-2"></i> Excel
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger"
                   href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}">
                    <i class="feather-file me-2"></i> PDF
                </a>
            </li>
        </ul>
    </div>
</div>

    {{-- 📋 TABLE --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Department</th>
                <th>Date</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Working Hours</th>
                <th>Status</th>
                <th>Late (min)</th>
                <th>Overtime (min)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendance as $a)

            @php
                $workingHours = '-';

                if($a->check_in && $a->check_out){
                    $start = \Carbon\Carbon::parse($a->check_in);
                    $end = \Carbon\Carbon::parse($a->check_out);
                    $workingHours = $end->diff($start)->format('%H:%I');
                }
            @endphp

            <tr>
                <td>{{ $a->staff->name ?? '-' }}</td>
                <td>{{ $a->department->department_name ?? '-' }}</td>
                <td>{{ $a->attendance_date }}</td>
                <td>{{ $a->check_in }}</td>
                <td>{{ $a->check_out }}</td>
                <td>{{ $workingHours }}</td>
                <td>
                    <span class="badge bg-{{ $a->status == 'Present' ? 'success' : 'danger' }}">
                        {{ $a->status }}
                    </span>
                </td>
                <td>{{ $a->late_minutes }}</td>
                <td>{{ $a->overtime_minutes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $attendance->links() }}

</div>

@endsection
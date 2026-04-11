@extends('layouts.admin')

@section('content')

<div class="container">
    <h3 class="mb-3">Overtime Report</h3>

    {{-- 🔍 FILTER --}}
    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <input type="text" name="employee" class="form-control" placeholder="Employee">
        </div>

        <div class="col-md-3">
            <select name="department_id" class="form-control">
                <option value="">Department</option>
                @foreach($departments as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="date" name="from_date" class="form-control">
        </div>

        <div class="col-md-3">
            <input type="date" name="to_date" class="form-control">
        </div>

        <div class="col-md-2 mt-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- 📊 SUMMARY --}}
    <div class="row mb-3">
        <div class="col-md-4">Total OT Hours: {{ $totalHours }}</div>
        <div class="col-md-4">Total OT Amount: ₹{{ $totalAmount }}</div>
    </div>

    {{-- 📋 TABLE --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Emp ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Shift</th>
                <th>Date</th>
                <th>OT Hours</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>

        <tbody>
            @foreach($records as $r)
            <tr>
                <td>{{ $r->staff->employee_id }}</td>
                <td>{{ $r->staff->name }}</td>
                <td>{{ $r->department->department_name ?? '-' }}</td>
                <td>{{ $r->shift->shift_name ?? '-' }}</td>
                <td>{{ $r->attendance_date }}</td>
                <td>{{ $r->overtime_hours }}</td>
                <td>₹100</td>
                <td>₹{{ $r->overtime_amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $records->links() }}

</div>

@endsection
@extends('layouts.admin')

@section('content')

<div class="container">
    <h3 class="mb-3">Leave Report</h3>

    {{-- 🔍 FILTERS --}}
    <form method="GET" class="row mb-3">

        <div class="col-md-2">
            <input type="text" name="employee" class="form-control" placeholder="Employee">
        </div>

        <div class="col-md-2">
            <select name="department_id" class="form-control">
                <option value="">Department</option>
                @foreach($departments as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="leave_type_id" class="form-control">
                <option value="">Leave Type</option>
                @foreach($leaveTypes as $lt)
                    <option value="{{ $lt->id }}">{{ $lt->display_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-control">
                <option value="">Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <div class="col-md-2">
            <input type="date" name="from_date" class="form-control">
        </div>

        <div class="col-md-2">
            <input type="date" name="to_date" class="form-control">
        </div>

        <div class="col-md-2 mt-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>

    </form>
    <div class="d-flex justify-content-end mb-3">
    <div class="dropdown">
        <button class="btn btn-light border dropdown-toggle" data-bs-toggle="dropdown">
            <i class="feather-download me-1"></i> Export
        </button>

        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item text-success"
                   href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}">
                    Excel
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger"
                   href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}">
                    PDF
                </a>
            </li>
        </ul>
    </div>
</div>

    {{-- 📋 TABLE --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Emp ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Leave Type</th>
                <th>From</th>
                <th>To</th>
                <th>Days</th>
                <th>Status</th>
                <th>Approved By</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>

            @foreach($leaves as $l)

            <tr>
                <td>{{ $l->staff->employee_id }}</td>
                <td>{{ $l->staff->name }}</td>
                <td>{{ $l->staff->department->name ?? '-' }}</td>
                <td>{{ $l->leaveType->display_name }}</td>
                <td>{{ $l->from_date }}</td>
                <td>{{ $l->to_date }}</td>
                <td>{{ $l->leave_days }}</td>

                <td>
                    <span class="badge bg-{{ $l->status == 'approved' ? 'success' : ($l->status == 'pending' ? 'warning' : 'danger') }}">
                        {{ $l->status }}
                    </span>
                </td>

                <td>
                    {{ optional($l->approvals->last())->approver->name ?? '-' }}
                </td>

                <td>{{ $l->remaining_balance }}</td>
            </tr>

            @endforeach

        </tbody>
    </table>

    {{ $leaves->links() }}

</div>

@endsection
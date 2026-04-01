@extends('layouts.admin')

@section('page-title', 'Leave Report | ' . config('app.name'))
@section('title', 'Leave Report')

@section('content')

{{-- Alerts --}}
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div class="page-header-title">
        <h5><i class="feather-bar-chart-2 me-2"></i>Leave Report</h5>
    </div>

    {{-- FILTER --}}
 <form method="GET" class="d-flex gap-2">

    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control form-control-sm">

    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control form-control-sm">

    {{--  Department Filter --}}
    <select name="department" class="form-control form-control-sm">
        <option value="">All Departments</option>
        @foreach($departments as $dept)
            <option value="{{ $dept->id }}"
                {{ request('department') == $dept->id ? 'selected' : '' }}>
                {{ $dept->department_name }}
            </option>
        @endforeach
    </select>

    <input type="text" name="employee" value="{{ request('employee') }}" placeholder="Employee"
        class="form-control form-control-sm">

    <select name="status" class="form-control form-control-sm">
        <option value="">All</option>
        <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
    </select>

    <button class="btn btn-sm btn-primary">
        <i class="feather-search"></i>
    </button>

</form>

</div>

{{--  LEAVE REPORT TABLE --}}
<div class="card">
<div class="card-body p-0">

<table class="table table-hover">

<thead>
<tr>
    <th>#</th>
    <th>Employee</th>
    <th>Department</th>
    <th>Leave Type</th>
    <th>From Date</th>
    <th>To Date</th>
    <th>Status</th>
    <th>Approved By</th>
    <th>Days</th>
</tr>
</thead>

<tbody>

@forelse($reports as $index => $leave)

<tr>

<td>{{ $reports->firstItem() + $index }}</td>

<td>{{ $leave->staff->name ?? '-' }}</td>

<td>{{ $leave->staff->department->department_name ?? '-' }}</td>

<td>{{ $leave->leaveType->display_name ?? '-' }}</td>

<td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}</td>

<td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}</td>

<td>
@if($leave->status=='approved')
<span class="badge bg-success">Approved</span>
@elseif($leave->status=='pending')
<span class="badge bg-warning">Pending</span>
@else
<span class="badge bg-danger">Rejected</span>
@endif
</td>

<td>
{{ optional($leave->approvals->last())->user->name ?? '-' }}
</td>

<td>{{ $leave->leave_days }}</td>

</tr>

@empty

<tr>
<td colspan="9" class="text-center">No records found</td>
</tr>

@endforelse

</tbody>

</table>

<div class="p-3">
{{ $reports->links() }}
</div>

</div>
</div>

{{--  COMPOFF SECTION --}}
<div class="card mt-4">
<div class="card-body">

<h5><i class="feather-calendar me-2"></i>Comp-Off Report</h5>

<table class="table table-bordered mt-3">

<thead>
<tr>
    <th>Employee</th>
    <th>Date of Work on Holiday</th>
    <th>comp off applied  date</th>
</tr>
</thead>

<tbody>

@forelse($compoffs as $comp)

<tr>
    <td>{{ $comp->employee->name ?? '-' }}</td>
   <td>{{ \Carbon\Carbon::parse($comp->worked_on)->format('d-m-Y') }}</td>
   <td>
    {{ $comp->applied_date 
        ? \Carbon\Carbon::parse($comp->applied_date)->format('d-m-Y') 
        : '-' }}
</td>
</tr>

@empty

<tr>
    <td colspan="3" class="text-center">No Comp-Off Records</td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

@endsection
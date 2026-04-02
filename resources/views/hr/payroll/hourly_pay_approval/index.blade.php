@extends('layouts.admin')

@section('page-title', 'Hourly Pay Approval | ' . config('app.name'))
@section('title', 'Hourly Pay Approval')

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div class="page-header-title">
        <h5 class="m-b-10 mb-1">
            <i class="feather-clock me-2"></i>Hourly Pay Approval
        </h5>

        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">Payroll</li>
            <li class="breadcrumb-item">Hourly Pay Approval</li>
        </ul>
    </div>

    <div class="d-flex gap-2 align-items-center">

        {{-- Search --}}
        <form method="GET"
              action="{{ route('hr.payroll.hourly-pay-approval.index') }}"
              class="d-flex">

            <input type="text"
                   name="search"
                   class="form-control form-control-sm me-2"
                   placeholder="Search Employee"
                   value="{{ request('search') }}">

            <button class="btn btn-light-brand btn-sm">
                <i class="feather-search"></i>
            </button>

        </form>

        {{-- Add Button --}}
        <a href="{{ route('hr.payroll.hourly-pay-approval.create') }}"
           class="btn btn-primary">

            <i class="feather-plus me-1"></i>
            Add Hourly Entry

        </a>

    </div>

</div>

<div class="card stretch stretch-full">

<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead>
<tr>

<th>#</th>
<th>Employee</th>
<th>Work Type</th>
<th>Payroll Month</th>
<th>Date</th>
<th>Hours</th>
<th>Status</th>
<th>Locked</th>
<th class="text-end">Actions</th>

</tr>
</thead>

<tbody>

@if ($entries->count())

@foreach ($entries as $index => $entry)

<tr>

<td>
{{ $entries->firstItem()
? $entries->firstItem() + $index
: $index + 1 }}
</td>

<td>{{ $entry->employee_id }}</td>

<td>{{ $entry->work_type_code }}</td>

<td>{{ $entry->payroll_month }}</td>

<td>{{ $entry->attendance_date }}</td>

<td>{{ $entry->approved_hours }}</td>

<td>

@if ($entry->approval_status == 'Approved')

<span class="badge bg-soft-success text-success">
Approved
</span>

@elseif ($entry->approval_status == 'Rejected')

<span class="badge bg-soft-danger text-danger">
Rejected
</span>

@else

<span class="badge bg-soft-warning text-warning">
Pending
</span>

@endif

</td>

<td>

@if ($entry->locked_for_payroll)

<span class="badge bg-soft-danger text-danger">
Locked
</span>

@else

<span class="badge bg-soft-success text-success">
Open
</span>

@endif

</td>

<td class="text-end">

<div class="d-flex justify-content-end gap-2">

<a href="{{ route('hr.payroll.hourly-pay-approval.edit',$entry->id) }}"
class="btn btn-outline-secondary btn-icon rounded-circle"
title="Edit">

<i class="feather-edit-2"></i>

</a>

<form action="{{ route('hr.payroll.hourly-pay-approval.destroy',$entry->id) }}"
method="POST"
onsubmit="return confirm('Move to trash?')">

@csrf
@method('DELETE')

<button type="submit"
class="btn btn-outline-secondary btn-icon rounded-circle"
title="Delete">

<i class="feather-trash-2"></i>

</button>

</form>

</div>

</td>

</tr>

@endforeach

@else

<tr>

<td colspan="9" class="text-center">
No Hourly Entries Found
</td>

</tr>

@endif

</tbody>

</table>

</div>

@if ($entries->hasPages())

<div class="mt-3 px-3 pb-3">
{{ $entries->links() }}
</div>

@endif

</div>

</div>

@endsection
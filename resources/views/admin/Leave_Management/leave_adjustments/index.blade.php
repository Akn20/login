@extends('layouts.admin')

@section('page-title', 'Leave Adjustment | ' . config('app.name'))

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1">Leave Adjustment</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Adjustment List</li>
        </ul>
    </div>

    <div>
        <a href="{{ route('admin.leave-adjustments.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Adjustment
        </a>
    </div>
</div>

<div class="row">
<div class="col-12">

<div class="card stretch stretch-full">
<div class="card-body p-0">


<!-- filter -->
<div class="p-3 border-bottom">
<form method="GET" action="{{ route('admin.leave-adjustments.index') }}">
<div class="row align-items-end">

<div class="col-md-4">
<label class="form-label">Filter by Staff</label>
<select name="staff_id" class="form-control">
<option value="">Select Staff</option>
@foreach($staff as $s)
<option value="{{ $s->id }}"
{{ request('staff_id') == $s->id ? 'selected' : '' }}>
{{ $s->name }}
</option>
@endforeach
</select>
</div>

<div class="col-md-4 d-flex gap-2">
<button type="submit" class="btn btn-primary btn-sm px-4">
<i class="feather-search"></i> Filter
</button>

<a href="{{ route('admin.leave-adjustments.index') }}"
class="btn btn-light btn-sm px-4">
Reset
</a>
</div>

</div>
</form>
</div>
<!-- end filter -->
<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead>
<tr>
<th>Staff</th>
<th>Leave Type</th>
<th>Credit</th>
<th>Debit</th>
<th>Year</th>
<th>Remarks</th>
<th>Date</th>
<th  class="text-center">Action</th>
</tr>
</thead>

<tbody>

@forelse($adjustments as $adj)

<tr>

<td>{{ $adj->staff->name ?? '' }}</td>

<td>
<span class="badge bg-soft-primary text-primary">
{{ $adj->leaveType->display_name ?? '' }}
</span>
</td>

<td>{{ $adj->credit }}</td>

<td>{{ $adj->debit }}</td>

<td>{{ $adj->year }}</td>

<td>{{ $adj->remarks }}</td>

<td>{{ $adj->created_at->format('d-m-Y') }}</td>

<td class="text-center">
<a href="{{ route('admin.leave-adjustments.show',$adj->id) }}">
<i class="feather-eye"></i>
</a>
</td>

</tr>

@empty

<tr>
<td colspan="8" class="text-center text-muted py-4">
No leave adjustments found
</td>
</tr>

@endforelse
</tbody>

</table>

</div>
</div>
</div>

</div>
</div>

@endsection
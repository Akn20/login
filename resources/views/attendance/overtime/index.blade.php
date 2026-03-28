@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Overtime Monitoring</h4>
</div>

<div class="card-body">

<!-- FILTER FORM -->

<form method="GET" action="{{ route('hr.attendance.overtime') }}">

<div class="row">

<div class="col-md-4">

<label>Department</label>

<select name="department_id" class="form-control">

<option value="">All Departments</option>

@foreach($departments as $id => $name)

<option value="{{ $id }}">{{ $name }}</option>

@endforeach

</select>

</div>

<div class="col-md-4">

<label>Designation</label>

<select name="designation_id" class="form-control">

<option value="">All Designations</option>

@foreach($designations as $id => $name)

<option value="{{ $id }}">{{ $name }}</option>

@endforeach

</select>

</div>

<div class="col-md-4 mt-4 d-flex align-items-end">

<div class="d-flex gap-2">

<button type="submit" class="btn btn-primary">
<i class="feather-filter me-1"></i> Filter
</button>

<a href="{{ route('hr.attendance.overtime') }}" class="btn btn-light">
<i class="feather-refresh-cw me-1"></i> Reset
</a>

</div>

</div>

</div>

</form>

<hr>

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>#</th>
<th>Employee</th>
<th>Department</th>
<th>Shift End</th>
<th>Check-out</th>
<th>Overtime</th>
<th>Extra Minutes</th>

</tr>

</thead>

<tbody>

@forelse($overtimeRecords as $key => $row)

<tr>

<td>{{ $overtimeRecords->firstItem() + $key }}</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->staff->department->department_name ?? '-' }}</td>

<td>{{ $row->shift->end_time }}</td>

<td>{{ $row->check_out }}</td>

<td>

<span class="badge bg-success">
Overtime
</span>

</td>

<td>{{ $row->overtime_minutes }}</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center">No Overtime Records</td>
</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">

{{ $overtimeRecords->links() }}

</div>

</div>
</div>
</div>

@endsection
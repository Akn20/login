@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Late Entry Monitoring</h4>
</div>

<div class="card-body">

<!-- FILTER FORM -->

<form method="GET" action="{{ route('hr.attendance.lateEntries') }}">

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

<div class="d-flex justify-content-end col-md-3 align-items-end">

<button type="submit" class="btn btn-primary">
<i class="feather-filter me-1"></i> Filter
</button>

<a href="{{ route('hr.attendance.lateEntries') }}" class="btn btn-light">
<i class="feather-refresh-cw me-1"></i> Reset
</a>

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
<th>Shift Start</th>
<th>Check-in</th>
<th>Late</th>
<th>Delay (Minutes)</th>

</tr>

</thead>

<tbody>

@forelse($lateEntries as $key => $row)

<tr>

<td>{{ $lateEntries->firstItem() + $key }}</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->staff->department->department_name ?? '-' }}</td>

<td>{{ $row->shift->start_time }}</td>

<td>{{ $row->check_in }}</td>

<td>

<span class="badge bg-danger">
Late
</span>

</td>

<td>{{ $row->late_minutes }}</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center">No Late Entries</td>
</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">

{{ $lateEntries->links() }}

</div>

</div>
</div>
</div>

@endsection
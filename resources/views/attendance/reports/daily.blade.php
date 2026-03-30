@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Daily Attendance Report</h4>
</div>

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-3">

<label>Date</label>
<input type="date" name="date" class="form-control">

</div>

<div class="col-md-3">

<label>Department</label>
<select name="department_id" class="form-control">

<option value="">All</option>

@foreach($departments as $id => $name)

<option value="{{ $id }}">{{ $name }}</option>

@endforeach

</select>

</div>

<div class="col-md-3">

<label>Designation</label>
<select name="designation_id" class="form-control">

<option value="">All</option>

@foreach($designations as $id => $name)

<option value="{{ $id }}">{{ $name }}</option>

@endforeach

</select>

</div>

<div class="col-md-3 mt-4">

<button class="btn btn-primary">
Generate
</button>

</div>

</div>

</form>

<hr>

<table class="table table-bordered">

<thead>

<tr>

<th>Employee</th>
<th>Shift</th>
<th>Check-in</th>
<th>Check-out</th>
<th>Status</th>
<th>Late</th>
<th>Overtime</th>

</tr>

</thead>

<tbody>

@foreach($records as $row)

<tr>

<td>{{ $row->staff->name }}</td>

<td>{{ $row->shift->shift_name }}</td>

<td>{{ $row->check_in }}</td>

<td>{{ $row->check_out }}</td>

<td>{{ $row->status }}</td>

<td>{{ $row->late_minutes }}</td>

<td>{{ $row->overtime_minutes }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>
</div>

@endsection
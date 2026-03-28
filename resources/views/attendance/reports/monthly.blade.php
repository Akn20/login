@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Monthly Attendance Report</h4>
</div>

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-4">

<label>Month</label>
<input type="month" name="month" class="form-control">

</div>

<div class="col-md-4 mt-4">

<button class="btn btn-primary">
Generate Report
</button>

</div>

</div>

</form>

<hr>

<table class="table table-bordered">

<thead>

<tr>

<th>Employee</th>
<th>Present</th>
<th>Absent</th>
<th>Leave</th>
<th>Late Entries</th>
<th>Overtime (Minutes)</th>

</tr>

</thead>

<tbody>

@foreach($records as $row)

<tr>

<td>{{ $row->staff->name }}</td>

<td>{{ $row->present_days }}</td>

<td>{{ $row->absent_days }}</td>

<td>{{ $row->leave_days }}</td>

<td>{{ $row->late_entries }}</td>

<td>{{ $row->overtime_minutes }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>
</div>

@endsection
@extends('layouts.admin')

@section('page-title','Shift Conflict Monitor')

@section('content')

<div class="page-header mb-4">

<div class="page-header-left d-flex align-items-center">

<div class="page-header-title">
<h5 class="m-b-0">Shift Conflict Monitor</h5>
</div>

</div>

</div>


<div class="card stretch stretch-full">

<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">

<tr>

<th>#</th>
<th>Employee</th>
<th>Date</th>
<th>Shift</th>
<th>Conflict Type</th>

</tr>

</thead>

<tbody>

@forelse($conflicts as $index => $row)

<tr>

<td>{{ $index+1 }}</td>

<td>{{ $row['employee'] }}</td>

<td>{{ $row['date'] }}</td>

<td>{{ $row['shift'] }}</td>

<td>

<span class="badge bg-danger">
{{ $row['type'] }}
</span>

</td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center">
No Conflicts Found
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection
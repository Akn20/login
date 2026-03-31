@extends('layouts.admin')

@section('page-title', 'Leave Adjustment Details')

@section('content')

<div class="page-header mb-4">
    <h5 class="mb-0">Leave Adjustment Details</h5>
</div>

<div class="card">
<div class="card-body">

<table class="table table-bordered">

<tr>
<th>Staff</th>
<td>{{ $adjustment->staff->name }}</td>
</tr>

<tr>
<th>Leave Type</th>
<td>{{ $adjustment->leaveType->display_name }}</td>
</tr>

<tr>
<th>Credit</th>
<td>{{ $adjustment->credit }}</td>
</tr>

<tr>
<th>Debit</th>
<td>{{ $adjustment->debit }}</td>
</tr>

<tr>
<th>Year</th>
<td>{{ $adjustment->year }}</td>
</tr>

<tr>
<th>Remarks</th>
<td>{{ $adjustment->remarks }}</td>
</tr>

<tr>
<th>Date</th>
<td>{{ $adjustment->created_at->format('d-m-Y') }}</td>
</tr>

</table>

<a href="{{ route('hr.leave-adjustments.index') }}" class="btn btn-secondary">
Back
</a>

</div>
</div>

@endsection
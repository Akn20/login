@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">

<h4>Attendance Records</h4>

<a href="{{ route('hr.attendance.create') }}" class="btn btn-primary">
Add Attendance
</a>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>#</th>
<th>Employee</th>
<th>Date</th>
<th>Shift</th>
<th>Check In</th>
<th>Check Out</th>
<th>Status</th>
<th>Late (Min)</th>
<th>Overtime (Min)</th>
<th>Action</th>

</tr>

</thead>

<tbody>

@forelse($attendance as $key => $row)

<tr>

<td>{{ $attendance->firstItem() + $key }}</td>

<td>{{ $row->staff->name ?? '-' }}</td>

<td>{{ $row->attendance_date }}</td>

<td>{{ $row->shift->shift_name ?? '-' }}</td>

<td>{{ $row->check_in }}</td>

<td>{{ $row->check_out }}</td>

<td>

@if($row->status == 'Present')
<span class="badge bg-success">Present</span>
@elseif($row->status == 'Absent')
<span class="badge bg-danger">Absent</span>
@elseif($row->status == 'Leave')
<span class="badge bg-warning">Leave</span>
@else
<span class="badge bg-info">Half Day</span>
@endif

</td>

<td>{{ $row->late_minutes }}</td>

<td>{{ $row->overtime_minutes }}</td>

<td class="text-end">

<div class="hstack gap-2 justify-content-end">

{{-- View --}}
<a href="{{ route('hr.attendance.show',$row->id) }}"
class="avatar-text avatar-md action-icon"
title="View">

<i class="feather-eye"></i>

</a>


{{-- Edit --}}
<a href="{{ route('hr.attendance.edit',$row->id) }}"
class="avatar-text avatar-md action-icon action-edit"
title="Edit">

<i class="feather-edit"></i>

</a>


{{-- Delete --}}
<form action="{{ route('hr.attendance.destroy',$row->id) }}"
method="POST"
class="d-inline"
onsubmit="return confirm('Delete this attendance?');">

@csrf
@method('DELETE')

<button type="submit"
class="avatar-text avatar-md action-icon action-delete"
title="Delete">

<i class="feather-trash-2"></i>

</button>

</form>

</div>

</td>


</tr>

@empty

<tr>
<td colspan="10" class="text-center">No Attendance Records</td>
</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">
{{ $attendance->links() }}
</div>

</div>
</div>
</div>

@endsection
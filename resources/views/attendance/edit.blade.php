@extends('layouts.admin')

@section('content')

<div class="container">
<div class="card">
<div class="card-header">
<h4>Edit Attendance</h4>
</div>

<div class="card-body">

<form action="{{ route('hr.attendance.update',$attendance->id) }}" method="POST">

@csrf
@method('PUT')

<input type="date"
name="attendance_date"
value="{{ $attendance->attendance_date }}"
class="form-control mb-2">

<input type="time"
name="check_in"
value="{{ $attendance->check_in }}"
class="form-control mb-2">

<input type="time"
name="check_out"
value="{{ $attendance->check_out }}"
class="form-control mb-2">

<select name="status" class="form-control mb-3">

<option value="Present" {{ $attendance->status=='Present'?'selected':'' }}>Present</option>
<option value="Absent" {{ $attendance->status=='Absent'?'selected':'' }}>Absent</option>
<option value="Leave" {{ $attendance->status=='Leave'?'selected':'' }}>Leave</option>

</select>
<select name="employee_id" class="form-control mb-2">

@foreach($staff as $id => $name)

<option value="{{ $id }}"
{{ $attendance->employee_id == $id ? 'selected' : '' }}>
{{ $name }}
</option>

@endforeach

</select>
<select name="department_id" class="form-control mb-2">

@foreach($departments as $id => $name)

<option value="{{ $id }}"
{{ $attendance->department_id == $id ? 'selected' : '' }}>
{{ $name }}
</option>

@endforeach

</select>
<select name="designation_id" class="form-control mb-2">

@foreach($designations as $id => $name)

<option value="{{ $id }}"
{{ $attendance->designation_id == $id ? 'selected' : '' }}>
{{ $name }}
</option>

@endforeach

</select>
<select name="shift_id" class="form-control mb-2">

@foreach($shifts as $id => $name)

<option value="{{ $id }}"
{{ $attendance->shift_id == $id ? 'selected' : '' }}>
{{ $name }}
</option>

@endforeach

</select>

<button class="btn btn-primary">
Update Attendance
</button>

</form>

</div>
</div>
</div>

@endsection
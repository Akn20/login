@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Attendance Entry</h4>
</div>

<div class="card-body">

<form action="{{ route('hr.attendance.store') }}" method="POST">
@csrf

<div class="row">

{{-- Department --}}
<div class="col-md-4 mb-3">
<label>Department</label>
<select name="department_id" id="department" class="form-control" required>
<option value="">Select Department</option>

@foreach($departments as $id => $name)
<option value="{{ $id }}">{{ $name }}</option>
@endforeach

</select>
</div>

{{-- Designation --}}
<div class="col-md-4 mb-3">
<label>Designation</label>
<select name="designation_id" id="designation" class="form-control" required>

<option value="">Select Designation</option>

</select>
</div>

{{-- Employee --}}
<div class="col-md-4 mb-3">
<label>Employee</label>
<select name="employee_id" id="employee" class="form-control" required>

<option value="">Select Employee</option>

</select>
</div>

{{-- Attendance Date --}}
<div class="col-md-4 mb-3">
<label>Attendance Date</label>
<input type="date" name="attendance_date" class="form-control" required>
</div>

{{-- Shift --}}
<div class="col-md-4 mb-3">
<label>Shift</label>

<select name="shift_id" id="shift" class="form-control" required>

<option value="">Select Shift</option>

@foreach($shifts as $id => $name)
<option value="{{ $id }}">{{ $name }}</option>
@endforeach

</select>
</div>

{{-- Shift Start --}}
<div class="col-md-4 mb-3">
<label>Shift Start Time</label>
<input type="text" id="shift_start" class="form-control" readonly>
</div>

{{-- Shift End --}}
<div class="col-md-4 mb-3">
<label>Shift End Time</label>
<input type="text" id="shift_end" class="form-control" readonly>
</div>

{{-- Check In --}}
<div class="col-md-4 mb-3">
<label>Check-in Time</label>
<input type="time" name="check_in" class="form-control">
</div>

{{-- Check Out --}}
<div class="col-md-4 mb-3">
<label>Check-out Time</label>
<input type="time" name="check_out" class="form-control">
</div>

{{-- Status --}}
<div class="col-md-4 mb-3">
<label>Status</label>

<select name="status" class="form-control" required>

<option value="">Select Status</option>
<option value="Present">Present</option>
<option value="Absent">Absent</option>
<option value="Leave">Leave</option>
<option value="Half Day">Half Day</option>

</select>

</div>

{{-- Notes --}}
<div class="col-md-12 mb-3">
<label>Notes</label>
<textarea name="notes" class="form-control"></textarea>
</div>

</div>

<div class="card-footer d-flex justify-content-end gap-2">

<a href="{{ route('hr.attendance.index') }}" class="btn btn-light">
<i class="feather-arrow-left me-1"></i> Back
</a>

<button type="submit" class="btn btn-primary" id="submitBtn">
<i class="feather-save me-1"></i> Save Attendance
</button>

</div>

</form>

</div>
</div>
</div>

@endsection


{{-- ================= SCRIPTS ================= --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function(){

/* -----------------------------
LOAD DESIGNATIONS
------------------------------*/

$('#department').change(function(){

let dept_id = $(this).val();

$('#designation').html('<option>Loading...</option>');

$.get('/hr/attendance/get-designations/' + dept_id, function(data){

let options = '<option value="">Select Designation</option>';

$.each(data,function(id,name){

options += `<option value="${id}">${name}</option>`;

});

$('#designation').html(options);

});

});


/* -----------------------------
LOAD EMPLOYEES
------------------------------*/
$('#designation').change(function(){

    let designation_id = $(this).val();

    $('#employee').html('<option>Loading...</option>');

    $.get('/hr/attendance/get-employees/' + designation_id, function(data){

        let options = '<option value="">Select Employee</option>';

        $.each(data,function(id,name){
            options += `<option value="${id}">${name}</option>`;
        });

        $('#employee').html(options);

    });

});


/* -----------------------------
LOAD SHIFT TIME
------------------------------*/

$('#shift').change(function(){

let shift_id = $(this).val();

if(shift_id){

$.get('/hr/attendance/get-shift-time/' + shift_id, function(data){

$('#shift_start').val(data.start_time);
$('#shift_end').val(data.end_time);

});

}

});

});

document.querySelector('form').addEventListener('submit', function () {
    document.getElementById('submitBtn').disabled = true;
});

</script>
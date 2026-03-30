@extends('layouts.admin')

@section('content')

<div class="container">
<div class="card">
<div class="card-header">
<h4>Attendance Details</h4>
</div>

<div class="card-body">

<p><strong>Employee:</strong> {{ $attendance->staff->name }}</p>
<p><strong>Date:</strong> {{ $attendance->attendance_date }}</p>
<p><strong>Check In:</strong> {{ $attendance->check_in }}</p>
<p><strong>Check Out:</strong> {{ $attendance->check_out }}</p>
<p><strong>Status:</strong> {{ $attendance->status }}</p>

</div>
</div>
</div>

@endsection
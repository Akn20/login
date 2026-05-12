@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h5>Edit Schedule</h5>

<form method="POST" action="{{ route('admin.radiology.schedule.update', $schedule->id) }}">
@csrf

<input type="date" name="scan_date" value="{{ $schedule->scan_date }}" class="form-control mb-2">
<input type="time" name="scan_time" value="{{ $schedule->scan_time }}" class="form-control mb-2">

<button class="btn btn-primary">Update</button>

</form>

</div>

@endsection
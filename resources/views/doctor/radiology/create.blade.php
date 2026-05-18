@extends('layouts.app')

@section('content')

<div class="container-fluid">

<div class="card">

<div class="card-header">

<h4>Request Imaging Test</h4>

</div>


<div class="card-body">

<form action="{{ route('doctor.radiology.store') }}"
      method="POST">

@csrf


<div class="row">

<div class="col-md-6 mb-3">

<label>Patient</label>

<select
name="patient_id"
class="form-control">

<option value="">

Select Patient

</option>

@foreach($patients as $patient)

<option value="{{ $patient->id }}">

{{ $patient->first_name }}
{{ $patient->last_name }}

</option>

@endforeach

</select>

</div>


<div class="col-md-6 mb-3">

<label>Scan Type</label>

<select
name="scan_type_id"
class="form-control">

<option>

Select Scan

</option>

@foreach($scanTypes as $scan)

<option value="{{ $scan->id }}">

{{ $scan->name }}

</option>

@endforeach

</select>

</div>

</div>


<div class="row">

<div class="col-md-6 mb-3">

<label>Body Part</label>

<input type="text"
name="body_part"
class="form-control"
placeholder="Chest">

</div>


<div class="col-md-6 mb-3">

<label>Priority</label>

<select
name="priority"
class="form-control">

<option value="Normal">

Normal

</option>

<option value="Urgent">

Urgent

</option>

</select>

</div>

</div>


<div class="row">

<div class="col-md-12">

<label>Clinical Notes</label>

<textarea
name="reason"
rows="4"
class="form-control">

</textarea>

</div>

</div>


<div class="mt-4">

<button
class="btn btn-success">

Submit Request

</button>

<a href="{{ route('doctor.radiology.index') }}"
class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

</div>

</div>

@endsection
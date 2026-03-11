@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Edit Surgery</h4>
</div>

<form action="{{ route('surgery.update',$surgery->id) }}" method="POST">

@csrf
@method('PUT')

<div class="card-body">

<h5>Surgery Details</h5>

<div class="row">

<div class="col-md-6 mb-3">
<label>Patient</label>

<select name="patient_id" class="form-control">

@foreach($patients as $patient)

<option value="{{ $patient->id }}"
{{ $surgery->patient_id == $patient->id ? 'selected' : '' }}>

{{ $patient->patient_code }} - {{ $patient->first_name }}

</option>

@endforeach

</select>
</div>


<div class="col-md-6 mb-3">
<label>Surgery Type</label>

<input type="text"
name="surgery_type"
class="form-control"
value="{{ $surgery->surgery_type }}">
</div>


<div class="col-md-6 mb-3">
<label>Surgery Date</label>

<input type="date"
name="surgery_date"
class="form-control"
value="{{ $surgery->surgery_date }}">
</div>


<div class="col-md-6 mb-3">
<label>Surgery Time</label>

<input type="time"
name="surgery_time"
class="form-control"
value="{{ $surgery->surgery_time }}">
</div>


<div class="col-md-6 mb-3">
<label>OT Room</label>

<input type="text"
name="ot_room"
class="form-control"
value="{{ $surgery->ot_room }}">
</div>

</div>


<hr>

<h5>Pre Operative Notes</h5>

<div class="row">

<div class="col-md-4 mb-3">
<label>BP</label>

<input type="text"
name="bp"
class="form-control"
value="{{ $preoperative->bp ?? '' }}">
</div>


<div class="col-md-4 mb-3">
<label>Heart Rate</label>

<input type="text"
name="heart_rate"
class="form-control"
value="{{ $preoperative->heart_rate ?? '' }}">
</div>


<div class="col-md-4 mb-3">
<label>Fasting Status</label>

<input type="text"
name="fasting_status"
class="form-control"
value="{{ $preoperative->fasting_status ?? '' }}">
</div>

</div>

</div>


<div class="card-footer">

<button class="btn btn-success">
Update Surgery
</button>

<a href="{{ route('surgery.index') }}" class="btn btn-secondary">
Cancel
</a>

</div>

</form>

</div>

</div>

@endsection
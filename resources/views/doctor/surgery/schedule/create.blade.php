@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Schedule Surgery</h4>
</div>

<form action="{{ route('surgery.store') }}" method="POST">

@csrf

<div class="card-body">

<!-- ================= Surgery Details ================= -->

<h5 class="mb-3">Surgery Details</h5>

<div class="row">

<div class="col-md-6 mb-3">
<label>Patient</label>

<select name="patient_id" class="form-control" required>

<option value="">Select Patient</option>

@foreach($patients as $patient)

<option value="{{ $patient->id }}">
{{ $patient->patient_code }} - {{ $patient->first_name }} {{ $patient->last_name }}
</option>

@endforeach

</select>
</div>


<div class="col-md-6 mb-3">
<label>Surgery Type</label>
<input type="text" name="surgery_type" class="form-control" required>
</div>


<div class="col-md-6 mb-3">
<label>Surgery Date</label>
<input type="date" name="surgery_date" class="form-control" required>
</div>


<div class="col-md-6 mb-3">
<label>Surgery Time</label>
<input type="time" name="surgery_time" class="form-control" required>
</div>


<div class="col-md-6 mb-3">
<label>OT Room</label>
<input type="text" name="ot_room" class="form-control">
</div>


<div class="col-md-6 mb-3">
<label>Surgeon</label>

<select name="surgeon_id" class="form-control">
<option value="">Select Surgeon</option>

@foreach($surgeons as $doctor)

<option value="{{ $doctor->id }}">
{{ $doctor->name }}
</option>

@endforeach

</select>
</div>


<div class="col-md-6 mb-3">
<label>Assistant Doctor</label>

<select name="assistant_doctor_id" class="form-control">

@foreach($assistantDoctors as $doctor)

<option value="{{ $doctor->id }}">
{{ $doctor->name }}
</option>

@endforeach

</select>
</div>


<div class="col-md-6 mb-3">
<label>Anesthetist</label>

<select name="anesthetist_id" class="form-control">

@foreach($anesthetists as $doctor)

<option value="{{ $doctor->id }}">
{{ $doctor->name }}
</option>

@endforeach

</select>
</div>


<div class="col-md-6 mb-3">
<label>Priority</label>

<select name="priority" class="form-control">

<option value="Normal">Normal</option>
<option value="Emergency">Emergency</option>

</select>
</div>


<div class="col-md-12 mb-3">
<label>Notes</label>
<textarea name="notes" class="form-control"></textarea>
</div>

</div>


<hr>


<!-- ================= Pre Operative Notes ================= -->

<h5 class="mb-3">Pre-Operative Notes</h5>

<div class="row">

<div class="col-md-4 mb-3">
<label>BP</label>
<input type="text" name="bp" class="form-control">
</div>


<div class="col-md-4 mb-3">
<label>Heart Rate</label>
<input type="text" name="heart_rate" class="form-control">
</div>


<div class="col-md-4 mb-3">
<label>Fasting Status</label>
<input type="text" name="fasting_status" class="form-control">
</div>


<div class="col-md-6 mb-3">
<label>Allergies</label>
<textarea name="allergies" class="form-control"></textarea>
</div>


<div class="col-md-6 mb-3">
<label>Consent Obtained</label>

<select name="consent_obtained" class="form-control">

<option value="1">Yes</option>
<option value="0">No</option>

</select>

</div>


<div class="col-md-6 mb-3">
<label>Pre-Operative Instructions</label>
<textarea name="instructions" class="form-control"></textarea>
</div>


<div class="col-md-6 mb-3">
<label>Risk Factors</label>
<textarea name="risk_factors" class="form-control"></textarea>
</div>

</div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-primary">
            Save Surgery
        </button>
        <a href="{{ route('surgery.index') }}" class="btn btn-light">
            Cancel
        </a>
    </div>

</form>

</div>

</div>

@endsection
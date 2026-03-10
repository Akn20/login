@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Post Operative Notes</h4>
</div>

<form action="{{ route('post.store') }}" method="POST">

@csrf

<input type="hidden" name="surgery_id" value="{{ $surgery->id }}">

<div class="card-body">

<h5>Procedure Details</h5>

<div class="row">

<div class="col-md-12 mb-3">
<label>Procedure Performed</label>

<textarea name="procedure_performed" class="form-control">
{{ $post->procedure_performed ?? '' }}
</textarea>
</div>


<div class="col-md-4 mb-3">
<label>Duration</label>

<input type="text"
name="duration"
class="form-control"
value="{{ $post->duration ?? '' }}">
</div>


<div class="col-md-4 mb-3">
<label>Blood Loss</label>

<input type="text"
name="blood_loss"
class="form-control"
value="{{ $post->blood_loss ?? '' }}">
</div>


<div class="col-md-4 mb-3">
<label>Patient Condition</label>

<input type="text"
name="patient_condition"
class="form-control"
value="{{ $post->patient_condition ?? '' }}">
</div>


<div class="col-md-12 mb-3">
<label>Recovery Instructions</label>

<textarea name="recovery_instructions" class="form-control">
{{ $post->recovery_instructions ?? '' }}
</textarea>
</div>

</div>

<hr>

<h5>Complications</h5>

<div class="row">

<div class="col-md-6 mb-3">
<label>Complication Type</label>

<select name="complication_type" class="form-control">

<option value="">None</option>

<option>Excess Bleeding</option>

<option>Infection</option>

<option>Anesthesia Reaction</option>

<option>Organ Damage</option>

</select>

</div>


<div class="col-md-6 mb-3">
<label>Description</label>

<textarea name="complication_description" class="form-control">
{{ $post->complication_description ?? '' }}
</textarea>

</div>

</div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-primary">
            Save Post Operative
        </button>
        <a href="{{ route('surgery.index') }}" class="btn btn-light">
            Cancel
        </a>
    </div>

</form>

</div>

</div>

@endsection
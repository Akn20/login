@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Edit Post Operative Notes</h4>
</div>

<form action="{{ route('prescriptions.post.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')

<div class="card-body">

<h5>Procedure Details</h5>

<div class="row">

<div class="col-md-12 mb-3">
<label>Procedure Performed</label>

<textarea name="procedure_performed" class="form-control">
{{ $post->procedure_performed }}
</textarea>
</div>


<div class="col-md-4 mb-3">
<label>Duration</label>

<input type="text"
name="duration"
class="form-control"
value="{{ $post->duration }}">
</div>


<div class="col-md-4 mb-3">
<label>Blood Loss</label>

<input type="text"
name="blood_loss"
class="form-control"
value="{{ $post->blood_loss }}">
</div>


<div class="col-md-4 mb-3">
<label>Patient Condition</label>

<input type="text"
name="patient_condition"
class="form-control"
value="{{ $post->patient_condition }}">
</div>


<div class="col-md-12 mb-3">
<label>Recovery Instructions</label>

<textarea name="recovery_instructions" class="form-control">
{{ $post->recovery_instructions }}
</textarea>
</div>

</div>

<hr>

<h5>Complications</h5>

<div class="row">

<div class="col-md-6 mb-3">
<label>Complication Type</label>

<select name="complication_type" class="form-control">

<option value="" {{ $post->complication_type == '' ? 'selected' : '' }}>None</option>

<option {{ $post->complication_type == 'Excess Bleeding' ? 'selected' : '' }}>Excess Bleeding</option>

<option {{ $post->complication_type == 'Infection' ? 'selected' : '' }}>Infection</option>

<option {{ $post->complication_type == 'Anesthesia Reaction' ? 'selected' : '' }}>Anesthesia Reaction</option>

<option {{ $post->complication_type == 'Organ Damage' ? 'selected' : '' }}>Organ Damage</option>

</select>

</div>


<div class="col-md-6 mb-3">
<label>Description</label>

<textarea name="complication_description" class="form-control">
{{ $post->complication_description }}
</textarea>

</div>

</div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-primary">
            Update Post Operative
        </button>
        <a href="{{ route('post.index') }}" class="btn btn-light">
            Cancel
        </a>
    </div>

</div>

</form>

</div>

</div>

@endsection
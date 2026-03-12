@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>Edit OT Management</h4>
</div>

<form action="{{ route('ot.update', $ot->id) }}" method="POST">

@csrf
@method('PUT')

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">
<label>OT Room Used</label>

<input type="text"
name="ot_room_used"
class="form-control"
value="{{ $ot->ot_room_used }}">
</div>


<div class="col-md-6 mb-3">
<label>Equipment Used</label>

<input type="text"
name="equipment_used"
class="form-control"
value="{{ $ot->equipment_used }}">
</div>


<div class="col-md-6 mb-3">
<label>Start Time</label>

<input type="time"
name="start_time"
class="form-control"
value="{{ $ot->start_time }}">
</div>


<div class="col-md-6 mb-3">
<label>End Time</label>

<input type="time"
name="end_time"
class="form-control"
value="{{ $ot->end_time }}">
</div>


<div class="col-md-6 mb-3">
<label>Approval Status</label>

<select name="approval_status" class="form-control">

<option value="Approved" {{ $ot->approval_status == 'Approved' ? 'selected' : '' }}>Approved</option>

<option value="Not Approved" {{ $ot->approval_status == 'Not Approved' ? 'selected' : '' }}>Not Approved</option>

</select>

</div>


<div class="col-md-12 mb-3">
<label>Notes</label>

<textarea name="notes" class="form-control">
{{ $ot->notes }}
</textarea>

</div>

</div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-primary">
            Update OT Details
        </button>
        <a href="{{ route('ot.index') }}" class="btn btn-light">
            Cancel
        </a>
    </div>

</div>

</form>

</div>

</div>

@endsection
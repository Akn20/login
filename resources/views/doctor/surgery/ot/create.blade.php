@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
<h4>OT Management</h4>
</div>

<form action="{{ route('ot.store') }}" method="POST" id="otForm">

@csrf

<div class="card-body">

<div class="row">

<div class="col-md-12 mb-3">
<label>Select Surgery</label>

<select name="surgery_id" id="surgerySelect" class="form-control" required>

<option value="">Select Surgery</option>

@foreach($surgeries as $surgery)

<option value="{{ $surgery->id }}" 
data-type="{{ $surgery->surgery_type }}" 
data-date="{{ $surgery->surgery_date }}" 
data-time="{{ $surgery->surgery_time }}" 
data-room="{{ $surgery->ot_room }}">
{{ $surgery->patient->first_name }} {{ $surgery->patient->last_name }} - {{ $surgery->surgery_type }} ({{ $surgery->surgery_date }})
</option>

@endforeach

</select>
</div>

<div class="col-md-6 mb-3">
<label>Surgery Type</label>
<input type="text" name="surgery_type_display" id="surgeryType" class="form-control" readonly>
</div>

<div class="col-md-6 mb-3">
<label>Surgery Date</label>
<input type="date" name="surgery_date_display" id="surgeryDate" class="form-control" readonly>
</div>

<div class="col-md-6 mb-3">
<label>Surgery Time</label>
<input type="time" name="surgery_time_display" id="surgeryTime" class="form-control" readonly>
</div>

<div class="col-md-6 mb-3">
<label>OT Room</label>
<input type="text" name="ot_room_display" id="otRoom" class="form-control" readonly>
</div>

<div class="col-md-6 mb-3">
<label>OT Room Used</label>

<input type="text"
name="ot_room_used"
id="otRoomUsed"
class="form-control">
</div>


<div class="col-md-6 mb-3">
<label>Equipment Used</label>

<input type="text"
name="equipment_used"
class="form-control">
</div>


<div class="col-md-6 mb-3">
<label>Start Time</label>

<input type="time"
name="start_time"
class="form-control">
</div>


<div class="col-md-6 mb-3">
<label>End Time</label>

<input type="time"
name="end_time"
class="form-control">
</div>


<div class="col-md-6 mb-3">
<label>Approval Status</label>

<select name="approval_status" class="form-control">

<option value="Approved">Approved</option>

<option value="Not Approved">Not Approved</option>

</select>

</div>


<div class="col-md-12 mb-3">
<label>Notes</label>

<textarea name="notes" class="form-control"></textarea>

</div>

</div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-primary">
            Save OT Details
        </button>
        <a href="{{ route('ot.index') }}" class="btn btn-light">
            Cancel
        </a>
    </div>

</form>

</div>

</div>

<script>
document.getElementById('surgerySelect').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    document.getElementById('surgeryType').value = selectedOption.getAttribute('data-type') || '';
    document.getElementById('surgeryDate').value = selectedOption.getAttribute('data-date') || '';
    document.getElementById('surgeryTime').value = selectedOption.getAttribute('data-time') || '';
    document.getElementById('otRoom').value = selectedOption.getAttribute('data-room') || '';
    document.getElementById('otRoomUsed').value = selectedOption.getAttribute('data-room') || '';
});
</script>

@endsection
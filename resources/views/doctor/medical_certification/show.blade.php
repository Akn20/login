@extends('layouts.admin')

@section('content')

<div class="card">
<div class="card-body">

<h5 class="mb-4">Certificate Details</h5>

<div class="row">

<div class="col-md-4 mb-3">
<label>Certificate Number</label>
<div>{{ $record->certificate_number }}</div>
</div>

<div class="col-md-4 mb-3">
<label>Employee Name</label>
<div>{{ $record->employee_name }}</div>
</div>
<div class="col-md-4 mb-3">
<label>Certificate Type</label>
<div>{{ $record->certificate_type }}</div>
</div>

<div class="col-md-4 mb-3">
<label>Status</label>
<div>{{ $record->status }}</div>
</div>

<div class="col-md-4 mb-3">
<label>Doctor Name</label>
<div>{{ $record->doctor_name }}</div>
</div>

<div class="col-md-4 mb-3">
<label>Signed</label>
<div>
{{ $record->signature_status ? 'Yes' : 'No' }}
</div>
</div>

<div class="col-md-12 mb-3">
<label>Medical Remarks</label>
<div>{{ $record->medical_remarks }}</div>
</div>

</div>

</div>
</div>

@endsection
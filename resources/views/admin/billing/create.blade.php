@extends('layouts.admin')

@section('content')

<div class="container">
<div class="card">

<div class="card-header">
<h4>Billing Entry</h4>
</div>

<div class="card-body">

<form action="{{ route('admin.billing.store') }}" method="POST">
@csrf

<div class="row">

<div class="col-md-6 mb-3">
<label>Patient</label>
<select name="patient_id" class="form-control" required>
<option value="">Select Patient</option>
@foreach($patients as $id => $name)
<option value="{{ $id }}">{{ $name }}</option>
@endforeach
</select>
</div>

<div class="col-md-6 mb-3">
<label>Visit ID</label>
<input type="text" name="visit_id" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Amount</label>
<input type="number" name="amount" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Payment Mode</label>
<select name="payment_mode" class="form-control">
<option value="CASH">Cash</option>
<option value="CARD">Card</option>
<option value="UPI">UPI</option>
<option value="ONLINE">Online</option>
</select>
</div>

</div>

<div class="card-footer d-flex justify-content-end">
<button class="btn btn-primary">Save</button>
</div>

</form>

</div>
</div>
</div>

@endsection
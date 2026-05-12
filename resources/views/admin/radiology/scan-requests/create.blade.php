@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h5>Create Scan Request</h5>

<form method="POST" action="{{ route('admin.radiology.scan-requests.store') }}">
@csrf

<div class="mb-3">
    <label>Patient</label>
    <select name="patient_id" class="form-control">
        @foreach($patients as $p)
        <option value="{{ $p->id }}">
            {{ $p->first_name }} {{ $p->last_name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Scan Type</label>
    <select name="scan_type_id" class="form-control">
        @foreach($scanTypes as $s)
        <option value="{{ $s->id }}">{{ $s->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Body Part</label>
    <input type="text" name="body_part" class="form-control">
</div>

<div class="mb-3">
    <label>Reason</label>
    <textarea name="reason" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Priority</label>
    <select name="priority" class="form-control">
        <option value="Normal">Normal</option>
        <option value="Urgent">Urgent</option>
    </select>
</div>

<div class="mb-3">
    <label>Doctor</label>
    <select name="doctor_id" class="form-control">
        @foreach($doctors as $d)
        <option value="{{ $d->id }}">{{ $d->name }}</option>
        @endforeach
    </select>
</div>

<button class="btn btn-success">Save</button>

</form>

</div>

@endsection
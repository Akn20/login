@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h5>Scan History</h5>

<form method="GET">

<div class="row mb-3">

<div class="col-md-3">
    <select name="patient_id" class="form-control">
        <option value="">All Patients</option>
        @foreach($patients as $p)
        <option value="{{ $p->id }}">{{ $p->first_name }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-3">
    <select name="scan_type_id" class="form-control">
        <option value="">All Scan Types</option>
        @foreach($scanTypes as $s)
        <option value="{{ $s->id }}">{{ $s->name }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-3">
    <input type="date" name="date" class="form-control">
</div>

<div class="col-md-3">
    <button class="btn btn-primary">Filter</button>
</div>

</div>

</form>

<table class="table">

<thead>
<tr>
    <th>Patient</th>
    <th>Scan</th>
    <th>Status</th>
    <th>Date</th>
</tr>
</thead>

<tbody>

@foreach($history as $h)
<tr>
    <td>{{ $h->patient->first_name }}</td>
    <td>{{ $h->scanType->name }}</td>
    <td>{{ $h->status }}</td>
    <td>{{ $h->created_at }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection
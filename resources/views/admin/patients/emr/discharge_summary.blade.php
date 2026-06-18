@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">
    <h4>Discharge Summary</h4>

    <a href="{{ route('admin.patient.portal.discharge.pdf', $ipd->id) }}" 
       class="btn btn-success">
        Download PDF
    </a>
</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
    <th>Patient Name</th>
    <td>
        {{ $ipd->patient->first_name ?? '-' }} 
        {{ $ipd->patient->last_name ?? '' }}
    </td>
</tr>

<tr>
    <th>Admission ID</th>
    <td>{{ $ipd->admission_id ?? '-' }}</td>
</tr>

<tr>
    <th>Diagnosis</th>
    <td>{{ optional($discharge)->diagnosis ?? '-' }}</td>
</tr>

<tr>
    <th>Treatment Summary</th>
    <td>{{ optional($discharge)->treatment_given ?? '-' }}</td>
</tr>

<tr>
    <th>Doctor Name</th>
    <td>{{ optional($discharge)->doctor_name ?? '-' }}</td>
</tr>

<tr>
    <th>Discharge Date</th>
    <td>{{ optional($discharge)->date ?? '-' }}</td>
</tr>

</table>

</div>
</div>
</div>

@endsection
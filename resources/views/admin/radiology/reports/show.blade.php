@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h4>Radiology Report</h4>

<hr>

<h5>Patient Details</h5>
<p>Name: {{ $report->request->patient->first_name }}</p>

<h5>Scan Info</h5>
<p>Type: {{ $report->request->scanType->name }}</p>
<p>Body Part: {{ $report->request->body_part }}</p>

<hr>

<h5>Observations</h5>
<p>{{ $report->observations }}</p>

<h5>Findings</h5>
<p>{{ $report->findings }}</p>

<h5>Diagnosis</h5>
<p>{{ $report->diagnosis }}</p>

<hr>

<button onclick="window.print()" class="btn btn-success">Print</button>

</div>

@endsection
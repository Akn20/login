@extends('layouts.app')

@section('content')

<div class="container-fluid">

<div class="card mb-4">

<div class="card-header">

<h4>Radiology Report</h4>

</div>


<div class="card-body">

<div class="row">

<div class="col-md-6">

<p>

<strong>Patient :</strong>

{{ $report->request->patient->first_name }}

{{ $report->request->patient->last_name }}

</p>


<p>

<strong>Scan Type :</strong>

{{ $report->request->scanType->name }}

</p>


<p>

<strong>Status :</strong>

{{ $report->status }}

</p>

</div>


<div class="col-md-6">

<p>

<strong>Radiologist Findings :</strong>

{{ $report->findings }}

</p>

<p>

<strong>Diagnosis :</strong>

{{ $report->diagnosis }}

</p>

</div>

</div>

</div>

</div>



<div class="card mb-4">

<div class="card-header">

Uploaded Scans

</div>

<div class="card-body">

@foreach($report->request->uploads as $upload)

<div class="mb-3">

<a
href="{{ asset('storage/'.$upload->file_path) }}"
target="_blank"
class="btn btn-primary">

View Scan

</a>

</div>

@endforeach

</div>

</div>



<div class="card">

<div class="card-header">

Clinical Interpretation Notes

</div>


<div class="card-body">

<form
action="{{ route('doctor.radiology.note') }}"
method="POST">

@csrf

<input
type="hidden"
name="report_id"
value="{{ $report->id }}">


<div class="mb-3">

<textarea
name="notes"
rows="4"
class="form-control"
placeholder="Add interpretation notes">

</textarea>

</div>


<button
class="btn btn-success">

Save Note

</button>

</form>

</div>

</div>


</div>

@endsection
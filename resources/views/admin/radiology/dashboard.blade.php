@extends('layouts.admin')

@section('content')

<div class="nxl-content">

<h4>Radiology Dashboard</h4>

<div class="row">

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h6>Total Scans</h6>
            <h3>{{ $totalScans }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h6>Pending</h6>
            <h3>{{ $pending }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h6>Uploaded</h6>
            <h3>{{ $uploaded }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h6>Approved</h6>
            <h3>{{ $approved }}</h3>
        </div>
    </div>

</div>

</div>

@endsection
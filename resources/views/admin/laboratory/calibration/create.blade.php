@extends('layouts.admin')

@section('page-title', 'Add Calibration | ' . config('app.name'))

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Calibration</h5>
    </div>

    <div class="page-header-right ms-auto">
        <button type="submit" form="calibrationForm" class="btn btn-primary">
            Save
        </button>
    </div>
</div>

<div class="main-content">
    <form id="calibrationForm" method="POST" action="{{ route('admin.laboratory.calibration.store') }}">
        @include('admin.laboratory.calibration.form')
    </form>
</div>

@endsection
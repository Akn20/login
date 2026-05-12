@extends('layouts.admin')

@section('page-title', 'Emergency Patient | ' . config('app.name'))

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10">Emergency Patient Snapshot</h5>
        <small class="text-muted">Critical patient details for emergency care</small>
    </div>

    <div class="page-header-right ms-auto">
        <a href="{{ route('admin.patients.emergency.list') }}" class="btn btn-secondary btn-sm">
            <i class="feather-arrow-left me-1"></i> Back to Records
        </a>
    </div>
</div>

<div class="main-content">
    <div class="card stretch stretch-full">
        <div class="card-body">
            @include('admin.emergency-records.partials.emergency-card')
        </div>
    </div>
</div>

@endsection
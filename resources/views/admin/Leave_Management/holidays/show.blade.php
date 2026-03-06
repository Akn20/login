@extends('layouts.admin')

@section('page-title', 'View Holiday | ' . config('app.name'))

@section('content')
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-title">
        <h5 class="m-b-10 mb-1">
            <i class="feather-eye me-2"></i>Holiday Details
        </h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.holidays.index') }}">Holidays</a></li>
            <li class="breadcrumb-item">View</li>
        </ul>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.holidays.edit', $holiday->id) }}" class="btn btn-primary">
            <i class="feather-edit-2 me-1"></i> Edit
        </a>
        <a href="{{ route('admin.holidays.index') }}" class="btn btn-light">
            <i class="feather-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card stretch">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-md-3">Holiday Name</dt>
            <dd class="col-md-9">{{ $holiday->name }}</dd>

            <dt class="col-md-3">Date Range</dt>
            <dd class="col-md-9">
                {{ $holiday->start_date->format('d-m-Y') }} to {{ $holiday->end_date->format('d-m-Y') }}
            </dd>

            <dt class="col-md-3">Status</dt>
            <dd class="col-md-9">
                <span class="badge bg-{{ $holiday->status === 1 ? 'success' : 'secondary' }}">
                    {{ ucfirst($holiday->status === 1 ? 'active' : 'inactive') }}
                </span>
            </dd>

            <dt class="col-md-3">Holiday Details</dt>
            <dd class="col-md-9">{!! $holiday->details ?? '<span class="text-muted">No details provided.</span>' !!}</dd>

            <dt class="col-md-3">Attached Circular</dt>
            <dd class="col-md-9">
                @if($holiday->document)
                    <a href="{{ asset('storage/' . $holiday->document) }}" target="_blank" class="btn btn-sm btn-outline-info" style="width: 100px;">
                        <i class="feather-download me-1"></i> View Document
                    </a>
                @else
                    <span class="text-muted">No document uploaded.</span>
                @endif
            </dd>
        </dl>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('page-title', 'View Staff | ' . config('app.name'))

@section('content')
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-title">
        <h5 class="m-b-10 mb-1">
            <i class="feather-eye me-2"></i>Staff Details
        </h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">HR</li>
            <li class="breadcrumb-item">
                <a href="{{ route('hr.staff-management.index') }}">Staff Management</a>
            </li>
            <li class="breadcrumb-item">View</li>
        </ul>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('hr.staff-management.edit', $staff->id) }}" class="btn btn-primary">
            <i class="feather-edit me-1"></i> Edit
        </a>

        <a href="{{ route('hr.staff-management.index') }}" class="btn btn-light">
            <i class="feather-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card stretch">
    <div class="card-body">
        <dl class="row mb-0">

            <dt class="col-md-3">Employee ID</dt>
            <dd class="col-md-9">{{ $staff->employee_id }}</dd>

            <dt class="col-md-3">Name</dt>
            <dd class="col-md-9">{{ $staff->name }}</dd>

            <dt class="col-md-3">Department</dt>
            <dd class="col-md-9">{{ $staff->department }}</dd>

            <dt class="col-md-3">Designation</dt>
            <dd class="col-md-9">{{ $staff->designation }}</dd>

            <dt class="col-md-3">Joining Date</dt>
            <dd class="col-md-9">
                {{ \Carbon\Carbon::parse($staff->joining_date)->format('d-m-Y') }}
            </dd>

            <dt class="col-md-3">Status</dt>
            <dd class="col-md-9">
                <span class="badge bg-{{ $staff->status === 'Active' ? 'success' : 'danger' }}">
                    {{ $staff->status }}
                </span>
            </dd>

        </dl>
    </div>
</div>
@endsection
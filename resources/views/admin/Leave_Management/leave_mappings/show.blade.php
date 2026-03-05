@extends('layouts.admin')

@section('content')
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-title">
        <h5 class="m-b-10 mb-1"><i class="feather-eye me-2"></i>Mapping Details</h5>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.leave-mappings.edit', $mapping->id) }}" class="btn btn-primary">
            <i class="feather-edit-2 me-1"></i> Edit
        </a>
        <a href="{{ route('admin.leave-mappings.index') }}" class="btn btn-light">
            <i class="feather-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card stretch">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-md-3">Leave Type</dt>
            <dd class="col-md-9"><span class="badge bg-soft-primary text-primary">{{ $mapping->leaveType->name }}</span></dd>

            <dt class="col-md-3">Eligible Status</dt>
            <dd class="col-md-9">{{ is_array($mapping->employee_status) ? implode(', ', $mapping->employee_status) : $mapping->employee_status }}</dd>

            <dt class="col-md-3">Accrual Policy</dt>
            <dd class="col-md-9">{{ $mapping->accrual_value }} leaves credited {{ $mapping->accrual_frequency }}</dd>

            <dt class="col-md-3">Carry Forward</dt>
            <dd class="col-md-9">
                @if($mapping->carry_forward_allowed)
                    <span class="text-success">Allowed (Limit: {{ $mapping->carry_forward_limit }}, Expiry: {{ $mapping->carry_forward_expiry_days }} days)</span>
                @else
                    <span class="text-muted">Not Allowed</span>
                @endif
            </dd>

            <dt class="col-md-3">Status</dt>
            <dd class="col-md-9">
                {{-- Match your working active/inactive string logic --}}
                <span class="badge bg-{{ $mapping->status === 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($mapping->status) }}
                </span>
            </dd>
        </dl>
    </div>
</div>
@endsection
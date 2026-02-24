@extends('layouts.admin')

@section('page-title', 'View Weekend Configuration | ' . config('app.name'))
@section('title', 'Weekend Configurations')

@section('content')
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-eye me-2"></i>Weekend Configuration Details
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.weekends.index') }}">Weekend Configurations</a>
                </li>
                <li class="breadcrumb-item">View</li>
            </ul>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.weekends.edit', $weekend->id) }}" class="btn btn-primary">
                <i class="feather-edit-2 me-1"></i> Edit
            </a>
            <a href="{{ route('admin.weekends.index') }}" class="btn btn-light">
                <i class="feather-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card stretch">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-md-3">Configuration Name</dt>
                <dd class="col-md-9">{{ $weekend->name }}</dd>

                <dt class="col-md-3">Weekend Days</dt>
                <dd class="col-md-9">
                    @php
                        $days = is_array($weekend->days) ? $weekend->days : (json_decode($weekend->days, true) ?? []);
                    @endphp
                    {{ $days ? implode(', ', $days) : '-' }}
                </dd>

                <dt class="col-md-3">Status</dt>
                <dd class="col-md-9">
                    @if ($weekend->status === 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </dd>

                <dt class="col-md-3">Created At</dt>
                <dd class="col-md-9">{{ $weekend->created_at?->format('d-m-Y H:i') }}</dd>

                <dt class="col-md-3">Updated At</dt>
                <dd class="col-md-9">{{ $weekend->updated_at?->format('d-m-Y H:i') }}</dd>

                <dt class="col-md-3">Weekend Details</dt>
                <dd class="col-md-9">
                    @if ($weekend->details)
                        {!! $weekend->details !!}
                    @else
                        <span class="text-muted">No details provided.</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection

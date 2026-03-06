@extends('layouts.admin')

@section('page-title', 'Edit Leave Type | ' . config('app.name'))
@section('title', 'Edit Leave Type')

@section('content')

<div class="page-header mb-4">
    <div>
        <h5 class="mb-1">
            <i class="feather-edit me-2"></i>Edit Leave Type
        </h5>

        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">Leave Management</li>
            <li class="breadcrumb-item">Leave Type</li>
            <li class="breadcrumb-item active">Edit</li>
        </ul>
    </div>
</div>

{{-- Reuse same form layout --}}
@include('admin.Leave_Management.leave_type.form')

@endsection
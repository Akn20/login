{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Dashboard | ' .config('app.name'))
@section('title', 'Dashboard')
@push('styles')
    <style>
        .avatar-text {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    </style>
@endpush
@section('content')

    <h1>Admin Dashboard</h1>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="feather-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="feather-alert-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">
                    <i class="feather-airplay me-2"></i>Dashboard
                </h5>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Dashboard</li>
                </ul>
            </div>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items d-flex align-items-center gap-2">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-2"></i>
                    Add User
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="row g-3">

            {{-- Total Users --}}
            <div class="col-xl-3 col-md-6">
                <div class="card stretch stretch-full h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-uppercase text-muted fs-11 d-block">Total Users</span>
                                <h4 class="fw-bold mb-0">123</h4>
                            </div>
                            <div class="avatar-text avatar-md bg-soft-primary text-primary">
                                <i class="feather-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Active Users --}}
            <div class="col-xl-3 col-md-6">
                <div class="card stretch stretch-full h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-uppercase text-muted fs-11 d-block">Active Users</span>
                                <h4 class="fw-bold mb-0">98</h4>
                            </div>
                            <div class="avatar-text avatar-md bg-soft-success text-success">
                                <i class="feather-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- New Signups (7 days) --}}
            <div class="col-xl-3 col-md-6">
                <div class="card stretch stretch-full h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-uppercase text-muted fs-11 d-block">New Signups (7 days)</span>
                                <h4 class="fw-bold mb-0">12</h4>
                            </div>
                            <div class="avatar-text avatar-md bg-soft-info text-info">
                                <i class="feather-user-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending Approvals --}}
            <div class="col-xl-3 col-md-6">
                <div class="card stretch stretch-full h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-uppercase text-muted fs-11 d-block">Pending Approvals</span>
                                <h4 class="fw-bold mb-0">5</h4>
                            </div>
                            <div class="avatar-text avatar-md bg-soft-warning text-warning">
                                <i class="feather-user-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Roles --}}
            <div class="col-xl-3 col-md-6">
                <div class="card stretch stretch-full h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-uppercase text-muted fs-11 d-block">Total Roles</span>
                                <h4 class="fw-bold mb-0">4</h4>
                            </div>
                            <div class="avatar-text avatar-md bg-soft-secondary text-secondary">
                                <i class="feather-shield"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
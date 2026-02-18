@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">View Organization</h5>
    </div>
    <div class="page-header-right">
        <a href="{{ route('organization.index') }}" class="btn btn-secondary">
            <i class="feather-arrow-left me-2"></i> Back to List
        </a>
    </div>
</div>

<div class="main-content">
<div class="row">

    <!-- LEFT CARD -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Organization Master</h5>

                <div class="mb-3">
                    <label class="form-label">Organization Name</label>
                    <p class="form-control-plaintext">{{ $organization->name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Organization Type</label>
                    <p class="form-control-plaintext">{{ $organization->type ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Registration Number</label>
                    <p class="form-control-plaintext">{{ $organization->registration_number ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">GST / Tax ID</label>
                    <p class="form-control-plaintext">{{ $organization->gst ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <p class="form-control-plaintext">{{ $organization->contact_number ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <p class="form-control-plaintext">{{ $organization->email ?? '-' }}</p>
                </div>

            </div>
        </div>
    </div>

    <!-- RIGHT CARD -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Admin & Subscription</h5>

                <div class="mb-3">
                    <label class="form-label">Admin Name</label>
                    <p class="form-control-plaintext">{{ $organization->admin_name ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Admin Email</label>
                    <p class="form-control-plaintext">{{ $organization->admin_email ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Admin Mobile</label>
                    <p class="form-control-plaintext">{{ $organization->admin_mobile ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Subscription Plan</label>
                    <p class="form-control-plaintext">{{ $organization->plan_type ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Organization Status</label>
                    <span class="badge bg-{{ $organization->status == 1 ? 'success' : 'danger' }}">
                        {{ $organization->status == 1 ? 'Active' : 'Inactive' }}
                    </span>
                </div>

            </div>
        </div>
    </div>

    <!-- FULL WIDTH CARD -->
    <div class="col-12">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Address Details</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <p class="form-control-plaintext">{{ $organization->address ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <p class="form-control-plaintext">{{ $organization->city ?? '-' }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">State</label>
                        <p class="form-control-plaintext">{{ $organization->state ?? '-' }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Country</label>
                        <p class="form-control-plaintext">{{ $organization->country ?? '-' }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pincode</label>
                        <p class="form-control-plaintext">{{ $organization->pincode ?? '-' }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
</div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Add Organization | ' . config('app.name'))

@section('content')



    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Organization</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.organization.index') }}">Organization</a>
                </li>
                <li class="breadcrumb-item">Create</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto">
            <button type="submit" form="orgForm" class="btn btn-primary">
                <i class="feather-save me-2"></i> Save Organization
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <form id="orgForm" method="POST" action="{{ route('admin.organization.store') }}">
            @csrf

            <div class="row">

                <!-- LEFT CARD -->
                <div class="col-xl-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">

                            <h5 class="mb-4">Organization Master</h5>

                            <div class="mb-3">
                                <label class="form-label">Organization Name *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Organization Type</label>
                                <select name="type" class="form-control">
                                    <option>Private</option>
                                    <option>Trust</option>
                                    <option>Government</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Registration Number</label>
                                <input type="text" name="registration_number" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">GST / Tax ID</label>
                                <input type="text" name="gst" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contact_number" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
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
                                <input type="text" name="admin_name" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Admin Email</label>
                                <input type="email" name="admin_email" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Admin Mobile</label>
                                <input type="text" name="admin_mobile" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subscription Plan</label>
                                <select name="plan_type" class="form-control">
                                    <option>Basic</option>
                                    <option>Standard</option>
                                    <option>Premium</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Organization Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
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
                                    <textarea name="address" class="form-control"></textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" name="state" class="form-control">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" class="form-control">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" name="pincode" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>


<<<<<<< HEAD
=======
        @include('admin.organization.form')

    </form>
</div>
>>>>>>> ff197a201622e4fea1f6253f70baf39f2297ba38

@endsection

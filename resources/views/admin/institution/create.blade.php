@extends('layouts.admin')

@section('page-title', 'Create Institution | ' . config('app.name'))

@section('content')

<div class="main-content">

    {{-- ================= PAGE HEADER ================= --}}
    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-10">Institution</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Institution</li>
                <li class="breadcrumb-item">Create</li>
            </ul>
        </div>
    </div>

    <form action="{{ route('admin.institutions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- ================= CORE DETAILS ================= --}}
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">1. Institution Details</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Institution Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Institution Code *</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control"></textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ================= ACCESS & BRANDING ================= --}}
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">2. Access & Branding</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Institution URL</label>
                            <input type="text" name="institution_url" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Default Language</label>
                            <input type="text" name="default_language" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Login Template</label>
                            <input type="text" name="login_template" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Institution Logo</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                    </div>
                </div>
            </div>

            {{-- ================= ADMIN ================= --}}
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">3. Admin & Control</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Admin Name</label>
                            <input type="text" name="admin_name" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Admin Email</label>
                            <input type="email" name="admin_email" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Admin Mobile</label>
                            <input type="text" name="admin_mobile" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ================= BILLING ================= --}}
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">4. Billing & Payment</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Invoice Type</label>
                            <select name="invoice_type" class="form-control">
                                <option>Proforma</option>
                                <option>Tax Invoice</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Invoice Amount</label>
                            <input type="number" name="invoice_amount" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Payment Mode</label>
                            <select name="payment_mode" class="form-control">
                                <option>Bank</option>
                                <option>UPI</option>
                                <option>Card</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-control">
                                <option>Pending</option>
                                <option>Paid</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ================= SAVE BUTTON ================= --}}
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="feather-save me-2"></i> Save Institution
                </button>
            </div>

        </div>
    </form>

</div>

@endsection

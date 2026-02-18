@extends('layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-header-left">
            <h5 class="m-b-10">View Institution</h5>
        </div>
        <div class="page-header-right">
            <a href="{{ route('admin.institutions.index') }}" class="btn btn-secondary">
                <i class="feather-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="row">

            {{-- ================= 1. CORE DETAILS ================= --}}
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">1. Institution Details</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-6">
                            <label>Name</label>
                            <p>{{ $institution->name }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>Code</label>
                            <p>{{ $institution->code }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>Organization</label>
                            <p>{{ $institution->organization->name ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>GST Number</label>
                            <p>{{ $institution->gst_number ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>Email</label>
                            <p>{{ $institution->email ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>Contact Number</label>
                            <p>{{ $institution->contact_number ?? '-' }}</p>
                        </div>

                        <div class="col-md-12">
                            <label>Address</label>
                            <p>{{ $institution->address ?? '-' }}</p>
                        </div>

                        <div class="col-md-3">
                            <label>City</label>
                            <p>{{ $institution->city ?? '-' }}</p>
                        </div>

                        <div class="col-md-3">
                            <label>State</label>
                            <p>{{ $institution->state ?? '-' }}</p>
                        </div>

                        <div class="col-md-3">
                            <label>Country</label>
                            <p>{{ $institution->country ?? '-' }}</p>
                        </div>

                        <div class="col-md-3">
                            <label>Pincode</label>
                            <p>{{ $institution->pincode ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>Timezone</label>
                            <p>{{ $institution->timezone ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>Status</label>
                            <span class="badge bg-{{ $institution->status == 1 ? 'success' : 'danger' }}">
                                {{ $institution->status == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>


            {{-- ================= 2. ACCESS & BRANDING ================= --}}
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">2. Access & Branding</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-6">
                            <label>Institution URL</label>
                            <p>{{ $institution->institution_url ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>Login Template</label>
                            <p>{{ $institution->login_template ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>Default Language</label>
                            <p>{{ $institution->default_language ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label>Logo</label><br>
                            @if($institution->logo)
                                <img src="{{ asset('uploads/' . $institution->logo) }}" width="120">
                            @else
                                -
                            @endif
                        </div>

                    </div>
                </div>
            </div>


            {{-- ================= 3. ADMIN ================= --}}
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">3. Admin & Control</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-4">
                            <label>Admin Name</label>
                            <p>{{ $institution->admin_name ?? '-' }}</p>
                        </div>

                        <div class="col-md-4">
                            <label>Admin Email</label>
                            <p>{{ $institution->admin_email ?? '-' }}</p>
                        </div>

                        <div class="col-md-4">
                            <label>Admin Mobile</label>
                            <p>{{ $institution->admin_mobile ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label>Role</label>
                            <p>{{ $institution->admin_role ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label>Modules</label>
                            <p class="form-control-plaintext">
                                @if($institution->modules && $institution->modules->count() > 0)
                                    {{ $institution->modules->pluck('module_display_name')->implode(', ') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>




                    </div>
                </div>
            </div>


            {{-- ================= 4. BILLING ================= --}}
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">4. Billing & Payment</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-3"><label>Invoice Type</label>
                            <p>{{ $institution->invoice_type ?? '-' }}</p>
                        </div>
                        <div class="col-md-3"><label>Invoice Frequency</label>
                            <p>{{ $institution->invoice_frequency ?? '-' }}</p>
                        </div>
                        <div class="col-md-3"><label>Payment Mode</label>
                            <p>{{ $institution->payment_mode ?? '-' }}</p>
                        </div>
                        <div class="col-md-3"><label>Payment Status</label>
                            <p>{{ $institution->payment_status ?? '-' }}</p>
                        </div>
                        <div class="col-md-3"><label>Invoice Amount</label>
                            <p>{{ $institution->invoice_amount ?? '-' }}</p>
                        </div>
                        <div class="col-md-3"><label>Payment Date</label>
                            <p>{{ $institution->payment_date ?? '-' }}</p>
                        </div>
                        <div class="col-md-3"><label>Payment Received</label>
                            <p>
                                @if($institution->payment_received)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-3"><label>Transaction Ref</label>
                            <p>{{ $institution->transaction_reference ?? '-' }}</p>
                        </div>

                    </div>
                </div>
            </div>
            {{-- ================= 4. LEGAL & COMMERCIAL ================= --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>4. Legal & Commercial</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-4">
                            <label>MOU Copy</label><br>

                            @if($institution->mou_copy)
                                <a href="{{ asset($institution->mou_copy) }}" target="_blank">
                                    View MOU
                                </a>
                            @else
                                <p>-</p>
                            @endif
                        </div>


                        <div class="col-md-4">
                            <label>PO Number</label>
                            <p>{{ $institution->po_number ?? '-' }}</p>
                        </div>

                        <div class="col-md-4">
                            <label>PO Start Date</label>
                            <p>{{ $institution->po_start_date ?? '-' }}</p>

                        </div>

                        <div class="col-md-4">
                            <label>PO End Date</label>
                            <p>{{ $institution->po_end_date ?? '-' }}</p>
                        </div>

                        <div class="col-md-4">
                            <label>Subscription Plan</label>
                            <p>{{ $institution->subscription_plan ?? '-' }}</p>
                        </div>

                    </div>
                </div>
            </div>


            {{-- ================= 5. SUPPORT ================= --}}
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">5. Support Details</h5>
                    </div>
                    <div class="card-body row g-3">

                        <div class="col-md-4"><label>POC Name</label>
                            <p>{{ $institution->poc_name ?? '-' }}</p>
                        </div>
                        <div class="col-md-4"><label>POC Email</label>
                            <p>{{ $institution->poc_email ?? '-' }}</p>
                        </div>
                        <div class="col-md-4"><label>POC Contact</label>
                            <p>{{ $institution->poc_contact ?? '-' }}</p>
                        </div>
                        <div class="col-md-4"><label>Support SLA</label>
                            <p>{{ $institution->support_sla ?? '-' }}</p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
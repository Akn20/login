@extends('layouts.admin')

@section('page-title', 'View Vendor | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Vendor Details</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Pharmacy</li>
                    <li class="breadcrumb-item">Vendors</li>
                    <li class="breadcrumb-item">View</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="btn btn-neutral">
                    Edit Vendor
                </a>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-neutral">
                    Back
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="row">

                {{-- Vendor Info Card --}}
                <div class="col-lg-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Vendor Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th class="ps-0" style="width:140px;">Name</th>
                                    <td>{{ $vendor->vendor_name }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0">Phone</th>
                                    <td>{{ $vendor->phone_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0">Email</th>
                                    <td>{{ $vendor->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0">Address</th>
                                    <td>{{ $vendor->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0">Status</th>
                                    <td>
                                        @if($vendor->status == 'Active')
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Purchases Card --}}
                <div class="col-lg-8">
                    <div class="card stretch stretch-full mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title">Purchase Records</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Purchase Date</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($vendor->purchases as $index => $purchase)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $purchase->purchase_date->format('d-m-Y') }}</td>
                                                <td>&#8377; {{ number_format($purchase->total_amount, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-3">
                                                    No purchase records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Payments Card --}}
                    <div class="card stretch stretch-full">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title">Payment Records</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Payment Date</th>
                                            <th>Amount Paid</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($vendor->payments as $index => $payment)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                                <td>&#8377; {{ number_format($payment->amount_paid, 2) }}</td>
                                                <td>
                                                    @if($payment->payment_status == 'Paid')
                                                        <span class="badge bg-soft-success text-success">Paid</span>
                                                    @else
                                                        <span class="badge bg-soft-warning text-warning">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">
                                                    No payment records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@extends('layouts.admin')

<style>

    @media print {

        .nxl-navigation,
        .nxl-sidebar,
        aside,
        nav,
        .btn,
        form {

            display: none !important;
        }

        .container-fluid {

            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

    }

</style>

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Refund Report
            </h2>

            <p class="text-muted mb-0">
                Refund transactions and approval tracking
            </p>

        </div>

        <button onclick="window.print()"
                class="btn btn-primary">

            Print Report

        </button>

    </div>

    <!-- Filters -->
    <div class="card border-0 shadow mb-4">

        <div class="card-header bg-white">

            <h5 class="mb-0 fw-bold">
                Filters
            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.accountant.reports.refund.report') }}">

                <div class="row">

                    <!-- From -->
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               name="from_date"
                               value="{{ request('from_date') }}"
                               class="form-control">

                    </div>

                    <!-- To -->
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                               name="to_date"
                               value="{{ request('to_date') }}"
                               class="form-control">

                    </div>

                    <!-- Refund Type -->
                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Refund Type
                        </label>

                        <select name="refund_type"
                                class="form-select">

                            <option value="">
                                All
                            </option>

                            <option value="OPD">OPD</option>
                            <option value="IPD">IPD</option>
                            <option value="PHARMACY">PHARMACY</option>
                            <option value="LAB">LAB</option>
                            <option value="ADVANCE">ADVANCE</option>

                        </select>

                    </div>

                    <!-- Status -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">
                                All
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Processed">
                                Processed
                            </option>

                            <option value="Approved">
                                Approved
                            </option>

                            <option value="Rejected">
                                Rejected
                            </option>

                        </select>

                    </div>

                    <!-- Refund Mode -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Refund Mode
                        </label>

                        <select name="refund_mode"
                                class="form-select">

                            <option value="">
                                All
                            </option>

                            <option value="Cash">
                                Cash
                            </option>

                            <option value="UPI">
                                UPI
                            </option>

                            <option value="Card">
                                Card
                            </option>

                            <option value="Bank Transfer">
                                Bank Transfer
                            </option>

                            <option value="Insurance">
                                Insurance
                            </option>

                        </select>

                    </div>

                    <!-- Search -->
                    <div class="col-md-12">

                        <button type="submit"
                                class="btn btn-primary">

                            Search Report

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Summary -->
    <div class="row">

        <!-- Total -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Refund Amount
                    </h6>

                    <h3 class="fw-bold text-danger mt-3">

                        ₹ {{ number_format($totalRefundAmount, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Approved -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Approved Refunds
                    </h6>

                    <h3 class="fw-bold text-success mt-3">

                        ₹ {{ number_format($approvedRefundAmount, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Pending -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pending Refunds
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">

                        ₹ {{ number_format($pendingRefundAmount, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Count -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Refund Records
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">

                        {{ $refundCount }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Refund Details
            </h5>

            <span class="badge bg-dark">

                Total Records :
                {{ $refunds->count() }}

            </span>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Refund No</th>

                            <th>Patient</th>

                            <th>Refund Type</th>

                            <th>Bill Type</th>

                            <th>Refund Amount</th>

                            <th>Refund Date</th>

                            <th>Refund Mode</th>

                            <th>Status</th>

                            <th>Approval Status</th>

                            <th>Reason</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($refunds as $key => $refund)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    {{ $refund->refund_no }}
                                </td>

                                <td>
                                    {{ $refund->patient_name }}
                                </td>

                                <td>

                                    <span class="badge bg-info">

                                        {{ $refund->refund_type }}

                                    </span>

                                </td>

                                <td>
                                    {{ $refund->bill_type }}
                                </td>

                                <td class="fw-bold text-danger">

                                    ₹ {{ number_format($refund->refund_amount, 2) }}

                                </td>

                                <td>

                                    {{ \Carbon\Carbon::parse($refund->refund_date)->format('d-m-Y') }}

                                </td>

                                <td>
                                    {{ $refund->refund_mode }}
                                </td>

                                <td>

                                    @if($refund->status == 'Approved')

                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    @elseif($refund->status == 'Pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($refund->status == 'Rejected')

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    @else

                                        <span class="badge bg-info">
                                            {{ $refund->status }}
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($refund->approval_status == 'Approved')

                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    @elseif($refund->approval_status == 'Rejected')

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                                <td style="max-width:250px;">

                                    {{ $refund->refund_reason }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="11"
                                    class="text-center text-muted py-4">

                                    No refund records found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
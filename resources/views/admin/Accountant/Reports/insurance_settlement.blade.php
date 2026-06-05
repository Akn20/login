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
                Insurance Settlement Report
            </h2>

            <p class="text-muted mb-0">
                Insurance claim approvals and settlement tracking
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
                  action="{{ route('admin.accountant.reports.insurance.settlement') }}">

                <div class="row">

                    <!-- From -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               name="from_date"
                               value="{{ request('from_date') }}"
                               class="form-control">

                    </div>

                    <!-- To -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                               name="to_date"
                               value="{{ request('to_date') }}"
                               class="form-control">

                    </div>

                    <!-- Provider -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Insurance Provider
                        </label>

                        <select name="provider"
                                class="form-select">

                            <option value="">
                                All Providers
                            </option>

                            @foreach($providers as $provider)

                                <option value="{{ $provider->insurance_provider }}"
                                    {{ request('provider') == $provider->insurance_provider ? 'selected' : '' }}>

                                    {{ $provider->insurance_provider }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Status -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Claim Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">
                                All
                            </option>

                            <option value="pending"
                                {{ request('status') == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="approved"
                                {{ request('status') == 'approved' ? 'selected' : '' }}>
                                Approved
                            </option>

                            <option value="partial"
                                {{ request('status') == 'partial' ? 'selected' : '' }}>
                                Partial
                            </option>

                            <option value="rejected"
                                {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                Rejected
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

        <!-- Claims -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Claims
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">

                        ₹ {{ number_format($totalClaims, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Approved -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Approved Amount
                    </h6>

                    <h3 class="fw-bold text-success mt-3">

                        ₹ {{ number_format($totalApproved, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Paid -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Settled Amount
                    </h6>

                    <h3 class="fw-bold text-info mt-3">

                        ₹ {{ number_format($totalPaid, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Pending -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pending Settlement
                    </h6>

                    <h3 class="fw-bold text-danger mt-3">

                        ₹ {{ number_format($pendingSettlement, 2) }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Insurance Claim Details
            </h5>

            <span class="badge bg-dark">

                Total Records :
                {{ $claims->count() }}

            </span>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Claim Number</th>

                            <th>Patient</th>

                            <th>Insurance Provider</th>

                            <th>Claim Date</th>

                            <th>Claim Amount</th>

                            <th>Approved</th>

                            <th>Paid</th>

                            <th>Pending</th>

                            <th>Status</th>

                            <th>Reconciliation</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($claims as $key => $claim)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    {{ $claim->claim_number }}
                                </td>

                                <td>
                                    {{ $claim->patient_name }}
                                </td>

                                <td>
                                    {{ $claim->insurance_provider }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($claim->claim_date)->format('d-m-Y') }}
                                </td>

                                <td class="fw-bold text-primary">

                                    ₹ {{ number_format($claim->billed_amount, 2) }}

                                </td>

                                <td class="fw-bold text-success">

                                    ₹ {{ number_format($claim->approved_amount, 2) }}

                                </td>

                                <td class="fw-bold text-info">

                                    ₹ {{ number_format($claim->paid_amount, 2) }}

                                </td>

                                <td class="fw-bold text-danger">

                                    ₹ {{ number_format($claim->approved_amount - $claim->paid_amount, 2) }}

                                </td>

                                <td>

                                    @if($claim->status == 'approved')

                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    @elseif($claim->status == 'pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($claim->status == 'partial')

                                        <span class="badge bg-info">
                                            Partial
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($claim->reconciled)

                                        <span class="badge bg-success">
                                            Reconciled
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="11"
                                    class="text-center text-muted py-4">

                                    No insurance claims found

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
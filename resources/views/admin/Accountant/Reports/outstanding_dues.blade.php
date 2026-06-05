@extends('layouts.admin')

<style>

    @media print {

        .nxl-navigation,
        .nxl-sidebar,
        .sidebar,
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
                Outstanding Dues Report
            </h2>

            <p class="text-muted mb-0">
                View pending IPD and Pharmacy dues
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
                  action="{{ route('admin.accountant.reports.outstanding.dues') }}">

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

                    <!-- Type -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Due Type
                        </label>

                        <select name="type"
                                class="form-select">

                            <option value="">
                                All
                            </option>

                            <option value="IPD"
                                {{ request('type') == 'IPD' ? 'selected' : '' }}>

                                IPD

                            </option>

                            <option value="Pharmacy"
                                {{ request('type') == 'Pharmacy' ? 'selected' : '' }}>

                                Pharmacy

                            </option>

                        </select>

                    </div>

                    <!-- Button -->
                    <div class="col-md-3 mb-3 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary w-100">

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
                        Total Outstanding
                    </h6>

                    <h3 class="fw-bold text-danger mt-3">

                        ₹ {{ number_format($totalOutstanding, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- IPD -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        IPD Outstanding
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">

                        ₹ {{ number_format($ipdOutstanding, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Pharmacy -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pharmacy Outstanding
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">

                        ₹ {{ number_format($pharmacyOutstanding, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Count -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pending Bills
                    </h6>

                    <h3 class="fw-bold text-dark mt-3">

                        {{ $totalPendingBills }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Outstanding Bills
            </h5>

            <span class="badge bg-dark">

                Total Records :
                {{ $reportData->count() }}

            </span>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Type</th>

                            <th>Bill No</th>

                            <th>Patient Name</th>

                            <th>Total Amount</th>

                            <th>Paid Amount</th>

                            <th>Pending Amount</th>

                            <th>Date</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($reportData as $key => $report)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <!-- Type -->
                                <td>

                                    @if($report->type == 'IPD')

                                        <span class="badge bg-primary">
                                            IPD
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            Pharmacy
                                        </span>

                                    @endif

                                </td>

                                <!-- Bill -->
                                <td>

                                    {{ $report->bill_no }}

                                </td>

                                <!-- Patient -->
                                <td>

                                    {{ $report->patient_name }}

                                </td>

                                <!-- Total -->
                                <td class="fw-bold">

                                    ₹ {{ number_format($report->payable_amount, 2) }}

                                </td>

                                <!-- Paid -->
                                <td class="text-success fw-bold">

                                    ₹ {{ number_format($report->paid_amount, 2) }}

                                </td>

                                <!-- Pending -->
                                <td class="text-danger fw-bold">

                                    ₹ {{ number_format($report->pending_amount, 2) }}

                                </td>

                                <!-- Date -->
                                <td>

                                    {{ \Carbon\Carbon::parse($report->bill_date)->format('d-m-Y') }}

                                </td>

                                <!-- Status -->
                                <td>

                                    <span class="badge bg-danger">
                                        Pending
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="text-center text-muted py-4">

                                    No outstanding dues found

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
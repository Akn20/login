@extends('layouts.admin')

<style>

    @media print {

        /* Hide Sidebar */
        .nxl-navigation,
        .nxl-sidebar,
        .sidebar,
        aside,
        nav,
        .main-sidebar {

            display: none !important;
        }

        /* Remove margins/padding */
        .main-content,
        .content,
        .container-fluid {

            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* Hide buttons/filter section */
        .btn,
        form,
        .card-header input {

            display: none !important;
        }

        /* Table styling */
        table {

            width: 100% !important;
            border-collapse: collapse;
        }

        th,
        td {

            border: 1px solid #000 !important;
            padding: 8px !important;
        }

        body {

            background: #fff !important;
        }

    }

</style>

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Daily Collection Report
            </h2>

            <p class="text-muted mb-0">
                View daily payment collections and transaction summaries
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">

            <button onclick="window.print()"
                    class="btn btn-primary">

                <i class="feather-printer me-1"></i>
                Print

            </button>

        </div>

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
                  action="{{ route('admin.accountant.reports.daily.collection') }}">

                <div class="row">

                    <!-- From Date -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               name="from_date"
                               value="{{ request('from_date') }}"
                               class="form-control">

                    </div>

                    <!-- To Date -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                               name="to_date"
                               value="{{ request('to_date') }}"
                               class="form-control">

                    </div>

                    <!-- Payment Mode -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Payment Mode
                        </label>

                        <select name="payment_mode"
                                class="form-select">

                            <option value="">
                                All
                            </option>

                            <option value="Cash"
                                {{ request('payment_mode') == 'Cash' ? 'selected' : '' }}>
                                Cash
                            </option>

                            <option value="Card"
                                {{ request('payment_mode') == 'Card' ? 'selected' : '' }}>
                                Card
                            </option>

                            <option value="UPI"
                                {{ request('payment_mode') == 'UPI' ? 'selected' : '' }}>
                                UPI
                            </option>

                            <option value="Insurance"
                                {{ request('payment_mode') == 'Insurance' ? 'selected' : '' }}>
                                Insurance
                            </option>

                        </select>

                    </div>

                    <!-- Search -->
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

    <!-- Summary Cards -->
    <div class="row">

        <!-- Total -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Collection
                    </h6>

                    <h3 class="fw-bold text-success mt-3">
                        ₹ {{ number_format($totalCollection, 2) }}
                    </h3>

                </div>

            </div>

        </div>

        <!-- Cash -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Cash Collection
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">
                        ₹ {{ number_format($cashCollection, 2) }}
                    </h3>

                </div>

            </div>

        </div>

        <!-- UPI -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        UPI Collection
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">
                        ₹ {{ number_format($upiCollection, 2) }}
                    </h3>

                </div>

            </div>

        </div>

        <!-- Card -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Card Collection
                    </h6>

                    <h3 class="fw-bold text-info mt-3">
                        ₹ {{ number_format($cardCollection, 2) }}
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Collection Transactions
            </h5>

            <span class="badge bg-dark">
                Total Records :
                {{ $collections->count() }}
            </span>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Type</th>

                            <th>Patient Name</th>

                            <th>Bill Number</th>

                            <th>Payment Mode</th>

                            <th>Amount</th>

                            <th>Payment Date</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($collections as $key => $collection)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <!-- OPD / IPD -->
                                <td>

                                    @if($collection->type == 'OPD')

                                        <span class="badge bg-primary">
                                            OPD
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            IPD
                                        </span>

                                    @endif

                                </td>

                                <!-- Patient -->
                                <td>
                                    {{ $collection->patient_name }}
                                </td>

                                <!-- Bill -->
                                <td>
                                    {{ $collection->bill_no }}
                                </td>

                                <!-- Payment Mode -->
                                <td>

                                    @if(strtolower($collection->payment_mode) == 'cash')

                                        <span class="badge bg-success">
                                            Cash
                                        </span>

                                    @elseif(strtolower($collection->payment_mode) == 'upi')

                                        <span class="badge bg-warning text-dark">
                                            UPI
                                        </span>

                                    @elseif(strtolower($collection->payment_mode) == 'card')

                                        <span class="badge bg-info text-dark">
                                            Card
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $collection->payment_mode }}
                                        </span>

                                    @endif

                                </td>

                                <!-- Amount -->
                                <td class="fw-bold text-success">

                                    ₹ {{ number_format($collection->amount, 2) }}

                                </td>

                                <!-- Date -->
                                <td>

                                    {{ \Carbon\Carbon::parse($collection->payment_date)->format('d-m-Y h:i A') }}

                                </td>

                                <!-- Status -->
                                <td>

                                    <span class="badge bg-primary">
                                        Completed
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center text-muted py-4">

                                    No collection records found

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
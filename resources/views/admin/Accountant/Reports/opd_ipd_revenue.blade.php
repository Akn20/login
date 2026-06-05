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
                OPD vs IPD Revenue Report
            </h2>

            <p class="text-muted mb-0">
                Compare OPD and IPD revenue collections
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
                  action="{{ route('admin.accountant.reports.opd.ipd.revenue') }}">

                <div class="row">

                    <!-- From -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               name="from_date"
                               value="{{ request('from_date') }}"
                               class="form-control">

                    </div>

                    <!-- To -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                               name="to_date"
                               value="{{ request('to_date') }}"
                               class="form-control">

                    </div>

                    <!-- Button -->
                    <div class="col-md-4 mb-3 d-flex align-items-end">

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

        <!-- OPD -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total OPD Revenue
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">

                        ₹ {{ number_format($totalOpdRevenue, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- IPD -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total IPD Revenue
                    </h6>

                    <h3 class="fw-bold text-success mt-3">

                        ₹ {{ number_format($totalIpdRevenue, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Total -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Revenue
                    </h6>

                    <h3 class="fw-bold text-dark mt-3">

                        ₹ {{ number_format($totalRevenue, 2) }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Highest -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Highest Revenue
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">

                        {{ $highestRevenueSource }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Revenue Comparison
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

                            <th>Date</th>

                            <th>OPD Revenue</th>

                            <th>IPD Revenue</th>

                            <th>Total Revenue</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($reportData as $key => $report)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <!-- Date -->
                                <td>

                                    {{ \Carbon\Carbon::parse($report->date)->format('d-m-Y') }}

                                </td>

                                <!-- OPD -->
                                <td class="fw-bold text-primary">

                                    ₹ {{ number_format($report->opd_revenue, 2) }}

                                </td>

                                <!-- IPD -->
                                <td class="fw-bold text-success">

                                    ₹ {{ number_format($report->ipd_revenue, 2) }}

                                </td>

                                <!-- Total -->
                                <td class="fw-bold text-dark">

                                    ₹ {{ number_format($report->total, 2) }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-muted py-4">

                                    No revenue records found

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
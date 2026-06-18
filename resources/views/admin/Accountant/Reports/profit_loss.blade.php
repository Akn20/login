@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Profit & Loss Summary
            </h2>

            <p class="text-muted mb-0">
                View overall hospital profit, revenue, and expense summaries
            </p>

        </div>

        <div>

            <button onclick="window.print()"
                    class="btn btn-primary">

                Print Report

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
                action="{{ route('admin.accountant.reports.profit.loss') }}">

                <div class="row">

                    <!-- From Date -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                                name="from_date"
                                value="{{ request('from_date') }}"
                               class="form-control">

                    </div>

                    <!-- To Date -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                                name="to_date"
                                value="{{ request('to_date') }}"
                               class="form-control">

                    </div>

                    <!-- Search -->
                    <div class="col-md-4 mb-3 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            Generate Summary

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Summary Cards -->
    <div class="row">

        <!-- Total Revenue -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Revenue
                    </h6>

                    <h3 class="fw-bold text-success mt-3">
                        ₹ {{ number_format($totalRevenue, 2) }}
                    </h3>

                </div>

            </div>

        </div>

        <!-- Total Expenses -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Expenses
                    </h6>

                    <h3 class="fw-bold text-danger mt-3">
                        ₹ {{ number_format($totalExpenses, 2) }}
                    </h3>

                </div>

            </div>

        </div>

        <!-- Net Profit -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Net Profit
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">
                        ₹ {{ number_format($netProfit, 2) }}
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Profit Loss Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Profit & Loss Details
            </h5>

            <input type="text"
                   class="form-control w-25"
                   placeholder="Search Details">

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Category</th>

                            <th>Description</th>

                            <th>Amount</th>

                            <th>Type</th>

                            <th>Date</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($details as $key => $detail)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    {{ $detail['category'] }}
                                </td>

                                <td>
                                    {{ $detail['description'] }}
                                </td>

                                <td class="fw-bold">

                                    ₹ {{ number_format($detail['amount'], 2) }}

                                </td>

                                <td>

                                    @if($detail['type'] == 'Income')

                                        <span class="badge bg-success">
                                            Income
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Expense
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $detail['date'] }}
                                </td>

                                <td>

                                    <span class="badge bg-primary">

                                        {{ $detail['status'] }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center text-muted py-4">

                                    No records found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

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
@endsection
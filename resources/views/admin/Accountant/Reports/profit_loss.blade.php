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

            <button class="btn btn-success me-2">
                Export Excel
            </button>

            <button class="btn btn-danger me-2">
                Export PDF
            </button>

            <button class="btn btn-primary">
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

            <form>

                <div class="row">

                    <!-- From Date -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               class="form-control">

                    </div>

                    <!-- To Date -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
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
                        ₹ 25,00,000
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
                        ₹ 15,00,000
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
                        ₹ 10,00,000
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

                        <tr>

                            <td>1</td>

                            <td>Revenue</td>

                            <td>OPD Consultation Revenue</td>

                            <td>₹ 5,00,000</td>

                            <td>
                                <span class="badge bg-success">
                                    Income
                                </span>
                            </td>

                            <td>01-05-2026</td>

                            <td>
                                <span class="badge bg-primary">
                                    Completed
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>2</td>

                            <td>Expense</td>

                            <td>Staff Salary Payments</td>

                            <td>₹ 3,00,000</td>

                            <td>
                                <span class="badge bg-danger">
                                    Expense
                                </span>
                            </td>

                            <td>03-05-2026</td>

                            <td>
                                <span class="badge bg-success">
                                    Paid
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>3</td>

                            <td>Revenue</td>

                            <td>IPD Room Charges</td>

                            <td>₹ 7,50,000</td>

                            <td>
                                <span class="badge bg-success">
                                    Income
                                </span>
                            </td>

                            <td>05-05-2026</td>

                            <td>
                                <span class="badge bg-primary">
                                    Completed
                                </span>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
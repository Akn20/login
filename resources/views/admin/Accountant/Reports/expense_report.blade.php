@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Expense Report
            </h2>

            <p class="text-muted mb-0">
                View operational expenses and expense summaries
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
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               class="form-control">

                    </div>

                    <!-- To Date -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                               class="form-control">

                    </div>

                    <!-- Expense Category -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Expense Category
                        </label>

                        <select class="form-select">

                            <option>
                                All Categories
                            </option>

                            <option>
                                Salary
                            </option>

                            <option>
                                Maintenance
                            </option>

                            <option>
                                Equipment
                            </option>

                            <option>
                                Utilities
                            </option>

                            <option>
                                Pharmacy Stock
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

        <!-- Total Expense -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Expenses
                    </h6>

                    <h3 class="fw-bold text-danger mt-3">
                        ₹ 6,80,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- Highest Expense -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Highest Expense Category
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">
                        Salary
                    </h3>

                </div>

            </div>

        </div>

        <!-- Total Vendors -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Vendors
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">
                        35
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Expense Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Expense Details
            </h5>

            <input type="text"
                   class="form-control w-25"
                   placeholder="Search Expense">

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Expense Category</th>

                            <th>Vendor Name</th>

                            <th>Amount</th>

                            <th>Payment Mode</th>

                            <th>Expense Date</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>

                            <td>Salary</td>

                            <td>Hospital Staff</td>

                            <td>₹ 3,00,000</td>

                            <td>
                                <span class="badge bg-primary">
                                    Bank Transfer
                                </span>
                            </td>

                            <td>05-05-2026</td>

                            <td>
                                <span class="badge bg-success">
                                    Paid
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>2</td>

                            <td>Equipment</td>

                            <td>MedTech Solutions</td>

                            <td>₹ 1,20,000</td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    Card
                                </span>
                            </td>

                            <td>06-05-2026</td>

                            <td>
                                <span class="badge bg-success">
                                    Paid
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>3</td>

                            <td>Utilities</td>

                            <td>Electricity Board</td>

                            <td>₹ 45,000</td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    UPI
                                </span>
                            </td>

                            <td>07-05-2026</td>

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
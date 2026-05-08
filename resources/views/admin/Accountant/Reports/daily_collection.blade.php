@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Daily Collection Report
            </h2>

            <p class="text-muted mb-0">
                View daily payment collections and transaction summaries
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

    <!-- Filter Section -->
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

                    <!-- Payment Mode -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Payment Mode
                        </label>

                        <select class="form-select">

                            <option>
                                All
                            </option>

                            <option>
                                Cash
                            </option>

                            <option>
                                Card
                            </option>

                            <option>
                                UPI
                            </option>

                            <option>
                                Insurance
                            </option>

                        </select>

                    </div>

                    <!-- Search Button -->
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

        <!-- Total Collection -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Collection
                    </h6>

                    <h3 class="fw-bold text-success mt-3">
                        ₹ 1,50,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- Cash Collection -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Cash Collection
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">
                        ₹ 60,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- UPI Collection -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        UPI Collection
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">
                        ₹ 40,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- Card Collection -->
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Card Collection
                    </h6>

                    <h3 class="fw-bold text-info mt-3">
                        ₹ 50,000
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Collection Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Collection Transactions
            </h5>

            <input type="text"
                   class="form-control w-25"
                   placeholder="Search Transactions">

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Transaction ID</th>

                            <th>Patient Name</th>

                            <th>Bill Number</th>

                            <th>Payment Mode</th>

                            <th>Amount</th>

                            <th>Date</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>

                            <td>TXN1001</td>

                            <td>Rahul Sharma</td>

                            <td>BILL-101</td>

                            <td>
                                <span class="badge bg-success">
                                    Cash
                                </span>
                            </td>

                            <td>₹ 5,000</td>

                            <td>07-05-2026</td>

                            <td>
                                <span class="badge bg-primary">
                                    Completed
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>2</td>

                            <td>TXN1002</td>

                            <td>Priya Kumar</td>

                            <td>BILL-102</td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    UPI
                                </span>
                            </td>

                            <td>₹ 3,500</td>

                            <td>07-05-2026</td>

                            <td>
                                <span class="badge bg-primary">
                                    Completed
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>3</td>

                            <td>TXN1003</td>

                            <td>Arjun Reddy</td>

                            <td>BILL-103</td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    Card
                                </span>
                            </td>

                            <td>₹ 7,000</td>

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
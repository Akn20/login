@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Refund Report
            </h2>

            <p class="text-muted mb-0">
                View patient refund transactions and refund summaries
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

                    <!-- Refund Status -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Refund Status
                        </label>

                        <select class="form-select">

                            <option>
                                All
                            </option>

                            <option>
                                Approved
                            </option>

                            <option>
                                Pending
                            </option>

                            <option>
                                Rejected
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

        <!-- Total Refunds -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Refund Amount
                    </h6>

                    <h3 class="fw-bold text-danger mt-3">
                        ₹ 1,25,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- Approved Refunds -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Approved Refunds
                    </h6>

                    <h3 class="fw-bold text-success mt-3">
                        ₹ 95,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- Pending Refunds -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pending Refund Requests
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">
                        12
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Refund Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Refund Details
            </h5>

            <input type="text"
                   class="form-control w-25"
                   placeholder="Search Patient">

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Patient Name</th>

                            <th>Bill Number</th>

                            <th>Refund Amount</th>

                            <th>Refund Reason</th>

                            <th>Refund Date</th>

                            <th>Payment Mode</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>

                            <td>Rahul Sharma</td>

                            <td>BILL-801</td>

                            <td>₹ 5,000</td>

                            <td>Duplicate Payment</td>

                            <td>07-05-2026</td>

                            <td>
                                <span class="badge bg-primary">
                                    UPI
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success">
                                    Approved
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>2</td>

                            <td>Priya Verma</td>

                            <td>BILL-802</td>

                            <td>₹ 8,000</td>

                            <td>Cancelled Service</td>

                            <td>08-05-2026</td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    Card
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>3</td>

                            <td>Arjun Kumar</td>

                            <td>BILL-803</td>

                            <td>₹ 2,500</td>

                            <td>Billing Correction</td>

                            <td>09-05-2026</td>

                            <td>
                                <span class="badge bg-success">
                                    Cash
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-danger">
                                    Rejected
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
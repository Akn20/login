@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Outstanding Dues Report
            </h2>

            <p class="text-muted mb-0">
                View pending patient payments and due balances
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

                    <!-- Due Status -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Due Status
                        </label>

                        <select class="form-select">

                            <option>
                                All
                            </option>

                            <option>
                                Pending
                            </option>

                            <option>
                                Partial
                            </option>

                            <option>
                                Overdue
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

        <!-- Total Pending -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Pending Amount
                    </h6>

                    <h3 class="fw-bold text-danger mt-3">
                        ₹ 2,40,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- Total Patients -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Due Patients
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">
                        86
                    </h3>

                </div>

            </div>

        </div>

        <!-- Overdue Cases -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Overdue Cases
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">
                        14
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Due Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Outstanding Due Details
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

                            <th>Total Bill</th>

                            <th>Paid Amount</th>

                            <th>Pending Amount</th>

                            <th>Due Date</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>

                            <td>Rahul Sharma</td>

                            <td>BILL-501</td>

                            <td>₹ 25,000</td>

                            <td>₹ 15,000</td>

                            <td>₹ 10,000</td>

                            <td>12-05-2026</td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    Partial
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>2</td>

                            <td>Priya Verma</td>

                            <td>BILL-502</td>

                            <td>₹ 18,000</td>

                            <td>₹ 8,000</td>

                            <td>₹ 10,000</td>

                            <td>10-05-2026</td>

                            <td>
                                <span class="badge bg-danger">
                                    Overdue
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>3</td>

                            <td>Arjun Kumar</td>

                            <td>BILL-503</td>

                            <td>₹ 12,000</td>

                            <td>₹ 7,000</td>

                            <td>₹ 5,000</td>

                            <td>15-05-2026</td>

                            <td>
                                <span class="badge bg-primary">
                                    Pending
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
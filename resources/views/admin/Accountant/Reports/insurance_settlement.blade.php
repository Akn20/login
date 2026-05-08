@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Insurance Settlement Report
            </h2>

            <p class="text-muted mb-0">
                View insurance claims, approvals, and settlement details
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

                    <!-- Insurance Company -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Insurance Company
                        </label>

                        <select class="form-select">

                            <option>
                                All Companies
                            </option>

                            <option>
                                Star Health
                            </option>

                            <option>
                                ICICI Lombard
                            </option>

                            <option>
                                HDFC Ergo
                            </option>

                            <option>
                                Medi Assist
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

        <!-- Total Claimed -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Claimed Amount
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">
                        ₹ 9,50,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- Approved Amount -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Approved Amount
                    </h6>

                    <h3 class="fw-bold text-success mt-3">
                        ₹ 7,80,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- Pending Claims -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pending Claims
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">
                        24
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Insurance Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Insurance Settlement Details
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

                            <th>Insurance Company</th>

                            <th>Claim Amount</th>

                            <th>Approved Amount</th>

                            <th>Pending Amount</th>

                            <th>Settlement Date</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>

                            <td>Rahul Sharma</td>

                            <td>Star Health</td>

                            <td>₹ 1,20,000</td>

                            <td>₹ 1,00,000</td>

                            <td>₹ 20,000</td>

                            <td>07-05-2026</td>

                            <td>
                                <span class="badge bg-success">
                                    Approved
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>2</td>

                            <td>Priya Verma</td>

                            <td>ICICI Lombard</td>

                            <td>₹ 80,000</td>

                            <td>₹ 50,000</td>

                            <td>₹ 30,000</td>

                            <td>08-05-2026</td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    Partial
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>3</td>

                            <td>Arjun Kumar</td>

                            <td>HDFC Ergo</td>

                            <td>₹ 60,000</td>

                            <td>₹ 0</td>

                            <td>₹ 60,000</td>

                            <td>-</td>

                            <td>
                                <span class="badge bg-danger">
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
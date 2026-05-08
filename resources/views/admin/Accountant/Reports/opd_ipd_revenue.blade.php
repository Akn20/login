@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                OPD/IPD Revenue Report
            </h2>

            <p class="text-muted mb-0">
                View OPD and IPD revenue collections and summaries
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

                    <!-- Revenue Type -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Revenue Type
                        </label>

                        <select class="form-select">

                            <option>
                                All
                            </option>

                            <option>
                                OPD
                            </option>

                            <option>
                                IPD
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

        <!-- Total Revenue -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Revenue
                    </h6>

                    <h3 class="fw-bold text-success mt-3">
                        ₹ 12,50,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- OPD Revenue -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        OPD Revenue
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">
                        ₹ 4,50,000
                    </h3>

                </div>

            </div>

        </div>

        <!-- IPD Revenue -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        IPD Revenue
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">
                        ₹ 8,00,000
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Revenue Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                OPD/IPD Revenue Details
            </h5>

            <input type="text"
                   class="form-control w-25"
                   placeholder="Search Revenue">

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Revenue Type</th>

                            <th>Total Patients</th>

                            <th>Total Bills</th>

                            <th>Total Revenue</th>

                            <th>Collected Amount</th>

                            <th>Pending Amount</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>

                            <td>
                                <span class="badge bg-primary">
                                    OPD
                                </span>
                            </td>

                            <td>320</td>

                            <td>300</td>

                            <td>₹ 4,50,000</td>

                            <td>₹ 4,10,000</td>

                            <td>₹ 40,000</td>

                            <td>
                                <span class="badge bg-success">
                                    Active
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>2</td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    IPD
                                </span>
                            </td>

                            <td>180</td>

                            <td>170</td>

                            <td>₹ 8,00,000</td>

                            <td>₹ 7,20,000</td>

                            <td>₹ 80,000</td>

                            <td>
                                <span class="badge bg-primary">
                                    Good
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
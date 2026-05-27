@extends('layouts.admin')

@section('content')

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

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

        <div>

            <h2 class="fw-bold mb-1">
                Department Revenue Report
            </h2>

            <p class="text-muted mb-0">
                View department-wise billed revenue summary
            </p>

        </div>

        <div>

            <button onclick="window.print()"
                    class="btn btn-primary">

                <i class="feather-printer me-1"></i>
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
                  action="{{ route('admin.accountant.reports.department.revenue') }}">

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

                    <!-- Department Filter -->
<div class="col-md-3 mb-3">

    <label class="form-label">
        Department
    </label>

    <select name="department"
            class="form-select">

        <option value="">
            All Departments
        </option>

        <option value="OPD">
            OPD
        </option>

        <option value="Laboratory">
            Laboratory
        </option>

        <option value="Radiology">
            Radiology
        </option>

        <option value="Pharmacy">
            Pharmacy
        </option>

        @foreach($departments as $department)

            <option value="{{ $department->department_name }}"
                {{ request('department') == $department->department_name ? 'selected' : '' }}>

                {{ $department->department_name }}

            </option>

        @endforeach

    </select>

</div>

                    <!-- Search -->
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

        <!-- Highest Revenue -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Highest Revenue Department
                    </h6>

                    <h3 class="fw-bold text-primary mt-3">

                        {{ $highestDepartment->department_name ?? 'N/A' }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Total Departments -->
        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Departments
                    </h6>

                    <h3 class="fw-bold text-warning mt-3">

                        {{ $totalDepartments }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">
                Department Revenue Details
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

                            <th>Department</th>

                            <th>Total Bills</th>

                            <th>Total Revenue</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($reportData as $key => $report)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <!-- Department -->
                                <td class="fw-semibold">

                                    {{ $report->department_name }}

                                </td>

                                <!-- Bills -->
                                <td>

                                    {{ $report->total_bills }}

                                </td>

                                <!-- Revenue -->
                                <td class="fw-bold text-success">

                                    ₹ {{ number_format($report->total_revenue, 2) }}

                                </td>

                                <!-- Status -->
                                <td>

                                    @if($report->total_revenue > 100000)

                                        <span class="badge bg-success">
                                            High Revenue
                                        </span>

                                    @elseif($report->total_revenue > 50000)

                                        <span class="badge bg-warning text-dark">
                                            Medium Revenue
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Low Revenue
                                        </span>

                                    @endif

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
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
                action="{{ route('admin.accountant.reports.expense.report') }}">

                <div class="row">

                    <!-- From Date -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                                name="from_date"
                                value="{{ request('from_date') }}"
                               class="form-control">

                    </div>

                    <!-- To Date -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                                name="to_date"
                                value="{{ request('to_date') }}"
                               class="form-control">

                    </div>

                    <!-- Expense Category -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Expense Category
                        </label>

                        <select name="category"
                                class="form-select">

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $category)

                                <option value="{{ $category->category_name }}"
                                    {{ request('category') == $category->category_name ? 'selected' : '' }}>

                                    {{ $category->category_name }}

                                </option>

                            @endforeach

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
                        ₹ {{ number_format($totalExpenses, 2) }}
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
                        {{ $highestExpenseCategory ?? 'N/A' }}
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
                        {{ $totalVendors }}
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

                        @forelse($expenses as $key => $expense)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    {{ $expense->category_name }}
                                </td>

                                <td>
                                    {{ $expense->vendor_name ?? 'N/A' }}
                                </td>

                                <td class="fw-bold text-danger">

                                    ₹ {{ number_format($expense->paid_amount, 2) }}

                                </td>

                                <td>

                                    <span class="badge bg-primary">

                                        {{ $expense->payment_mode }}

                                    </span>

                                </td>

                                <td>

                                    {{ \Carbon\Carbon::parse($expense->payment_date)->format('d-m-Y') }}

                                </td>

                                <td>

                                    @if($expense->payment_status == 'Fully Paid')

                                        <span class="badge bg-success">
                                            Fully Paid
                                        </span>

                                    @elseif($expense->payment_status == 'Partial')

                                        <span class="badge bg-warning text-dark">
                                            Partial
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Unpaid
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center text-muted py-4">

                                    No expense records found

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
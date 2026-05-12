@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="mb-4">
        <h4 class="fw-bold">Vendor Purchase Report</h4>
    </div>

    <!-- 🔹 Filters -->
    <form method="GET">
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="row g-3 align-items-end">

                    <!-- Vendor -->
                    <div class="col-md-3">
                        <label class="form-label">Vendor</label>
                        <select name="vendor_name" class="form-control">
                            <option value="">All</option>
                            @foreach($allVendors as $v)
                                <option value="{{ $v->vendor_name }}"
                                    {{ request('vendor_name') == $v->vendor_name ? 'selected' : '' }}>
                                    {{ $v->vendor_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- From Date -->
                    <div class="col-md-3">
                        <label class="form-label">From Date</label>
                        <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                    </div>

                    <!-- To Date -->
                    <div class="col-md-3">
                        <label class="form-label">To Date</label>
                        <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                    </div>

                    <!-- Button -->
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">
                            Filter
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- 🔹 Summary Cards -->
    <div class="row mb-4 g-3">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Purchases</h6>
                    <h4 class="fw-bold">₹ {{ number_format($totalPurchase,2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-warning h-100">
                <div class="card-body">
                    <h6 class="text-muted">Pending Payments</h6>
                    <h4 class="fw-bold text-warning">₹ {{ number_format($pendingPayments,2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Vendors</h6>
                    <h4 class="fw-bold">{{ $totalVendors }}</h4>
                </div>
            </div>
        </div>

    </div>

    <!-- 🔹 Table -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Vendor Name</th>
                            <th>Total Purchase</th>
                            <th>Paid Amount</th>
                            <th>Pending Amount</th>
                            <th>Last Purchase Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($reportData as $v)
                        <tr>
                            <td class="fw-semibold">{{ $v->vendor_name }}</td>
                            <td>₹ {{ number_format($v->total_purchase,2) }}</td>
                            <td class="text-success">₹ {{ number_format($v->paid_amount,2) }}</td>
                            <td class="text-danger">₹ {{ number_format($v->pending_amount,2) }}</td>
                            <td>
                                {{ $v->last_purchase_date 
                                    ? \Carbon\Carbon::parse($v->last_purchase_date)->format('d-m-Y') 
                                    : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No data found</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $reportData->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
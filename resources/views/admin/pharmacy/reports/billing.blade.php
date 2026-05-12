@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Pharmacy Billing Report</h4>
    </div>

    <!-- 🔹 Filters -->
   <form method="GET">
<div class="row g-3 mb-3">

    <div class="col-md-3">
        <label>From</label>
        <input type="date" name="from" value="{{ request('from') }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label>To</label>
        <input type="date" name="to" value="{{ request('to') }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label>Payment Status</label>
        <select name="payment_status" class="form-control">
            <option value="">All</option>
            <option value="Paid">Paid</option>
            <option value="Unpaid">Unpaid</option>
        </select>
    </div>

    <div class="col-md-3">
        <label>Payment Mode</label>
        <select name="payment_mode" class="form-control">
            <option value="">All</option>
            <option value="Cash">Cash</option>
            <option value="UPI">UPI</option>
            <option value="Card">Card</option>
        </select>
    </div>

    <div class="col-md-12">
        <button class="btn btn-primary">Filter</button>
    </div>

</div>
</form>
    <!-- 🔹 Summary Cards -->
   <div class="row mb-3">

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Total Billing</h6>
                <h4>₹ {{ number_format($totalAmount,2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <h6>Total Paid</h6>
                <h4>₹ {{ number_format($totalPaid,2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <h6>Total Balance</h6>
                <h4>₹ {{ number_format($totalBalance,2) }}</h4>
            </div>
        </div>
    </div>

</div>

    <!-- 🔹 Table -->
    <div class="card">
        <div class="card-body">

          <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Bill No</th>
            <th>Patient</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Balance</th>
            <th>Status</th>
            <th>Mode</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
    @forelse($bills as $bill)
        <tr>
            <td>{{ $bill->bill_number }}</td>
            <td>{{ $bill->display_patient_name }}</td>
            <td>₹ {{ $bill->total_amount }}</td>
            <td>₹ {{ $bill->paid_amount }}</td>
            <td>₹ {{ $bill->balance_amount }}</td>

            <td>
                <span class="badge bg-{{ $bill->payment_status == 'Paid' ? 'success' : 'danger' }}">
                    {{ $bill->payment_status }}
                </span>
            </td>

            <td>{{ $bill->payment_mode ?? '-' }}</td>

            <td>{{ $bill->created_at->format('d-m-Y') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">No data found</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $bills->links() }}
</div>
        </div>
    </div>

</div>

@endsection
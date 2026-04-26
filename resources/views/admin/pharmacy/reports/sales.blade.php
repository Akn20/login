@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daily Sales Report</h4>
    </div>

   <form method="GET">

<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-3">
                <label>From Date</label>
                <input type="date" name="from"
                       value="{{ request('from') }}"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <label>To Date</label>
                <input type="date" name="to"
                       value="{{ request('to') }}"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <label>Payment Mode</label>
                <select name="payment_mode" class="form-control">
                    <option value="">All</option>
                    <option value="Cash" {{ request('payment_mode')=='Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Card" {{ request('payment_mode')=='Card' ? 'selected' : '' }}>Card</option>
                    <option value="UPI" {{ request('payment_mode')=='UPI' ? 'selected' : '' }}>UPI</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100">Filter</button>
            </div>

        </div>
    </div>
</div>

</form>
    <!-- 🔹 Summary Cards -->
    <div class="row mb-3">

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Amount</h6>
                    <h4>₹ {{ $sales->sum('total_amount') }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Paid Amount</h6>
                    <h4>₹ {{ $sales->sum('paid_amount') }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Balance Amount</h6>
                    <h4>₹ {{ $sales->sum('balance_amount') }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Sales</h6>
                    <h4>{{ $sales->count() }}</h4>
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
                <th>Invoice No</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Status</th>
                <th>Payment Mode</th>
            </tr>
            </thead>

               <tbody>
@forelse($sales as $sale)
<tr>
    <td>{{ $sale->bill_number }}</td>

    <!-- 🔥 using accessor -->
    <td>{{ $sale->display_patient_name }}</td>

    <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d-m-Y') }}</td>

    <td>₹ {{ $sale->total_amount }}</td>
    <td>₹ {{ $sale->paid_amount }}</td>
    <td>₹ {{ $sale->balance_amount }}</td>

    <td>
        <span class="badge 
            {{ $sale->payment_status == 'Paid' ? 'bg-success' : ($sale->payment_status == 'Partial' ? 'bg-info' : 'bg-warning') }}">
            {{ $sale->payment_status }}
        </span>
    </td>

    <td>{{ ucfirst($sale->payment_mode) }}</td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">No data found</td>
</tr>
@endforelse
</tbody>

            </table>
<div class="mt-3">
    {{ $sales->links() }}
</div>
        </div>
    </div>

</div>

@endsection
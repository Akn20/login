@extends('layouts.admin')

@section('page-title', 'Payment | ' . config('app.name'))

@section('content')

<div class="container-fluid">

    <!-- 🔹 Page Title -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">

    <div class="page-header-left">
        <h4 class="mb-0">Payment for Bill: {{ $bill->bill_no }}</h4>
    </div>

    <div class="page-header-right">
        <a href="{{ route('admin.accountant.billing.index') }}" 
           class="btn btn-outline-secondary btn-sm">
            ← Back
        </a>
    </div>

</div>

    <div class="card shadow-sm">
        
        <!-- 🔹 Header -->
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <span>Payment Details</span>
            <span class="badge bg-light text-dark">
                {{ ucfirst($bill->payment_status) }}
            </span>
        </div>

        <!-- 🔹 Body -->
        <div class="card-body">

            <!-- 🔹 Messages -->
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- 🔹 Bill Info -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ $bill->patient->first_name }}</p>
                    <p><strong>Advance:</strong> ₹{{ $bill->ipd->advance_amount ?? 0 }}</p>
                    <p>
                        <strong>Status:</strong> 
                        <span class="badge 
                            @if($bill->payment_status == 'paid') bg-success
                            @elseif($bill->payment_status == 'partial') bg-warning text-dark
                            @else bg-danger
                            @endif
                        ">
                            {{ ucfirst($bill->payment_status) }}
                        </span>
                    </p>
                </div>

                <div class="col-md-6 text-end">
                    <p><strong>Total:</strong> ₹{{ $bill->payable_amount }}</p>
                    <p><strong>Paid:</strong> <span class="text-success">₹{{ $bill->paid_amount }}</span></p>
                    <p><strong>Due:</strong> <span class="text-danger">₹{{ $bill->due_amount }}</span></p>
                </div>
            </div>

            <hr>

            <!-- 🔹 Payment Form -->
            <form method="POST" action="{{ route('admin.accountant.payment.store') }}">
                @csrf

                <input type="hidden" name="bill_id" value="{{ $bill->id }}">

                <div class="row">

                    <!-- Amount -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Amount</label>
                        <input 
                            type="number" 
                            name="amount" 
                            class="form-control"
                            max="{{ $bill->due_amount }}"
                            placeholder="Enter amount"
                            required>
                    </div>

                    <!-- Payment Mode -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode" class="form-select">
                            <option value="cash">Cash</option>
                            <option value="upi">UPI</option>
                            <option value="card">Card</option>
                        </select>
                    </div>

                    <!-- Transaction ID -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Transaction ID</label>
                        <input 
                            type="text" 
                            name="transaction_id" 
                            class="form-control"
                            placeholder="For UPI/Card">
                    </div>

                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Submit Payment
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
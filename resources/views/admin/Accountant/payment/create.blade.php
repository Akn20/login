@extends('layouts.admin')

@section('page-title', 'Payment | ' . config('app.name'))

@section('content')

<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Payment for Bill: {{ $bill->bill_no }}</h4>
        </div>

        <a href="{{ route('admin.accountant.billing.index') }}" 
           class="btn btn-outline-secondary btn-sm">
            Back
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <span>Payment Details</span>
            <span class="badge bg-light text-dark">
                {{ ucfirst($bill->payment_status) }}
            </span>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!--  Bill Info -->
            <div class="row mb-3">
                <div class="col-md-5">
                    <p><strong>Patient:</strong> {{ $bill->patient->first_name }} {{ $bill->patient->last_name }}</p>
                    <p><strong>Advance:</strong> ₹{{ $bill->ipd->advance_amount ?? 0 }}</p>
                    <p>
                        <strong>Status:</strong> 
                        <span class="badge 
                            @if($bill->payment_status == 'paid') bg-success
                            @elseif($bill->payment_status == 'partial') bg-warning text-dark
                            @else bg-danger
                            @endif">
                            {{ ucfirst($bill->payment_status) }}
                        </span>
                    </p>

                    @if($bill->due_amount <= 0)
                        <div class="alert alert-success"> This bill is fully paid. No further payments required.</div>
                    @endif
                </div>

                <div class="col-md-6 text-end">
                    <p><strong>Total:</strong> ₹{{ $bill->payable_amount }}</p>
                    <p><strong>Paid:</strong> <span class="text-success">₹{{ $bill->paid_amount }}</span></p>
                    <p><strong>Due:</strong> <span class="text-danger">₹{{ $bill->due_amount }}</span></p>
                </div>
            </div>
            <hr>

            <!--  Payment Form -->
            <form method="POST" action="{{ route('admin.accountant.payment.store') }}">
                @csrf
                <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                <div class="row">

                    <!-- Amount -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Amount</label>
                        <input 
                            type="number" 
                            step="0.01"
                            name="amount" 
                            class="form-control"
                            max="{{ $bill->due_amount }}"
                            placeholder="Enter amount"
                            {{ $bill->due_amount <= 0 ? 'disabled' : '' }}
                            required>
                    </div>

                    <!-- Payment Mode -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode" 
                                class="form-select"
                                {{ $bill->due_amount <= 0 ? 'disabled' : '' }}>
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
                            placeholder="For UPI/Card"
                            {{ $bill->due_amount <= 0 ? 'disabled' : '' }}>
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" 
                            class="btn btn-success"
                            {{ $bill->due_amount <= 0 ? 'disabled' : '' }}>
                        Submit Payment
                    </button>
                </div>
            </form>

            <!--  Payment History -->
            <hr class="my-4">
            <h5 class="mb-3">
                Payment History 
                ({{ $bill->payments ? $bill->payments->count() : 0 }})
            </h5>

            @if($bill->payments && $bill->payments->count() > 0)

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Mode</th>
                                <th>Transaction ID</th>
                                <th>Receipt</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($bill->payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                                <td class="fw-bold">₹{{ $payment->amount }}</td>
                                <td>
                                    <span class="badge 
                                        @if($payment->payment_mode == 'cash') bg-secondary
                                        @elseif($payment->payment_mode == 'upi') bg-success
                                        @else bg-primary
                                        @endif">
                                        {{ strtoupper($payment->payment_mode) }}
                                    </span>
                                </td>
                                <td>{{ $payment->transaction_id ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.accountant.payment.receipt', $payment->id) }}" 
                                    class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    No payments recorded yet
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
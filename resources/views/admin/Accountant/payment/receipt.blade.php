@extends('layouts.admin')

@section('page-title', 'Receipt')

@section('content')

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Header -->
                <div class="print-area">
                    <div class="text-center mb-4">
                        <h4>Hospital Management System</h4>
                        <h5>Payment Receipt</h5>
                    </div>

                    <hr>

                    <!-- Receipt Info -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <p><strong>Patient:</strong> {{ $payment->bill->patient->first_name }} {{ $payment->bill->patient->last_name }}</p>
                            <p><strong>Bill No:</strong> {{ $payment->bill->bill_no }}</p>
                        </div>

                        <div class="col-md-6 text-end">
                            <p><strong>Receipt ID:</strong> {{ $payment->id }}</p>
                            <p><strong>Date:</strong> {{ $payment->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Payment Details -->
                    <h5 class="mb-3">Payment Details</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Amount Paid</th>
                            <td>₹{{ $payment->amount }}</td>
                        </tr>
                        <tr>
                            <th>Payment Mode</th>
                            <td>{{ strtoupper($payment->payment_mode) }}</td>
                        </tr>
                        <tr>
                            <th>Transaction ID</th>
                            <td>{{ $payment->transaction_id ?? '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    <!-- Bill Summary -->
                    <h5 class="mb-3">Bill Summary</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Total Bill</th>
                            <td>₹{{ $payment->bill->payable_amount }}</td>
                        </tr>
                        <tr>
                            <th>Total Paid</th>
                            <td>₹{{ $payment->bill->paid_amount }}</td>
                        </tr>
                        <tr>
                            <th>Remaining Due</th>
                            <td>₹{{ $payment->bill->due_amount }}</td>
                        </tr>
                    </table>

                    <hr>

                    <!-- Footer -->
                    <div class="text-center mt-4"><p>Thank you for your payment</p></div>
                </div>

                <!-- Print Button -->
                <div class="d-flex gap-2 no-print">
                    <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                    
                    <a href="{{ route('admin.accountant.billing.show', $payment->bill->id) }}" class="btn btn-secondary">
                        Back to Bill
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    @media print {
        .card {
            border: none;
            box-shadow: none;
        }

        /* Hide everything */
        body * {
            visibility: hidden;
        }

        /* Show only receipt */
        .print-area, .print-area * {
            visibility: visible;
        }

        /* Position receipt properly */
        .print-area {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }
    }
    </style>
@endsection
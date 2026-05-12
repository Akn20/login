@extends('layouts.admin')

@section('title', 'Collect Payment')

@section('content')
<div class="container-fluid">

    @php
        $invoice = (object)[
            'invoice_number' => 'INV-2026-001',
            'invoice_date' => '2026-03-10',
            'patient_name' => 'Ramesh Kumar',
            'uhid' => 'UHID001',
            'phone' => '9876543210',
            'doctor_name' => 'Dr. Mehta',
            'prescription_number' => 'RX-2026-101',
            'grand_total' => 691.60,
            'paid_amount' => 300.00,
            'balance_amount' => 391.60,
            'payment_status' => 'Partially Paid',
        ];

        $paymentModes = ['Cash', 'Card', 'UPI', 'Net Banking', 'Insurance', 'Mixed'];

        $history = collect([
            (object)[
                'date' => '2026-03-10',
                'mode' => 'UPI',
                'reference' => 'UPI98347291',
                'amount' => 300.00,
                'notes' => 'Initial partial payment',
                'status' => 'Received',
            ],
        ]);

        $paymentBadge = match($invoice->payment_status) {
            'Paid' => 'success',
            'Partially Paid' => 'warning',
            'Unpaid' => 'danger',
            default => 'secondary'
        };
    @endphp

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-0">Collect Payment</h4>
            <small class="text-muted">Pharmacy → Billing → Payment Collection</small>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.billing.view') }}" class="btn btn-light">
                <i class="feather-arrow-left"></i> Back
            </a>
            <button type="button" class="btn btn-success">
                <i class="feather-save"></i> Save Payment
            </button>
        </div>
    </div>

    <div class="row">
        {{-- LEFT --}}
        <div class="col-lg-8">

            {{-- Invoice Info --}}
            <div class="card mb-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0">Invoice Information</h5>
                    <span class="badge bg-{{ $paymentBadge }} custom-badge">{{ $invoice->payment_status }}</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="detail-label">Invoice No</label>
                            <div class="detail-value">{{ $invoice->invoice_number }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="detail-label">Invoice Date</label>
                            <div class="detail-value">{{ $invoice->invoice_date }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="detail-label">Prescription No</label>
                            <div class="detail-value">{{ $invoice->prescription_number }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="detail-label">Patient Name</label>
                            <div class="detail-value">{{ $invoice->patient_name }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="detail-label">UHID</label>
                            <div class="detail-value">{{ $invoice->uhid }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="detail-label">Phone</label>
                            <div class="detail-value">{{ $invoice->phone }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="detail-label">Doctor Name</label>
                            <div class="detail-value">{{ $invoice->doctor_name }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="detail-label">Outstanding Balance</label>
                            <div class="detail-value text-danger">₹ {{ number_format($invoice->balance_amount, 2) }}</div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Collect Payment Form --}}
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Payment Entry</h5>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Payment Date</label>
                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Payment Mode</label>
                                <select class="form-select">
                                    @foreach($paymentModes as $mode)
                                        <option {{ $mode === 'Cash' ? 'selected' : '' }}>{{ $mode }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Amount Received</label>
                                <input type="number" step="0.01" class="form-control" value="391.60">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Remaining Balance</label>
                                <input type="number" step="0.01" class="form-control" value="0.00" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Transaction Reference</label>
                                <input type="text" class="form-control" placeholder="Enter card / UPI / txn reference">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Collected By</label>
                                <input type="text" class="form-control" value="Admin">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Notes / Remarks</label>
                                <textarea class="form-control" rows="4" placeholder="Enter payment note or remarks..."></textarea>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-2 flex-wrap">
                                <a href="{{ route('admin.billing.view') }}" class="btn btn-light">
                                    Cancel
                                </a>
                                <button type="button" class="btn btn-success">
                                    <i class="feather-save"></i> Save Payment
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            {{-- Payment History --}}
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Payment History</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered align-middle mb-0 payment-history-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">SL</th>
                                <th>Date</th>
                                <th>Mode</th>
                                <th>Reference</th>
                                <th class="text-end">Amount (₹)</th>
                                <th>Notes</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row->date }}</td>
                                    <td>{{ $row->mode }}</td>
                                    <td>{{ $row->reference }}</td>
                                    <td class="text-end">{{ number_format($row->amount, 2) }}</td>
                                    <td>{{ $row->notes }}</td>
                                    <td>
                                        <span class="badge bg-success custom-badge">{{ $row->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No payment history found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-4">

            <div class="card mb-3 sticky-summary">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Payment Summary</h5>
                </div>
                <div class="card-body">

                    <div class="summary-row">
                        <span>Grand Total</span>
                        <strong>₹ {{ number_format($invoice->grand_total, 2) }}</strong>
                    </div>

                    <div class="summary-row text-success">
                        <span>Already Paid</span>
                        <strong>₹ {{ number_format($invoice->paid_amount, 2) }}</strong>
                    </div>

                    <div class="summary-row text-danger border-top pt-2 mt-2">
                        <span>Balance Due</span>
                        <strong>₹ {{ number_format($invoice->balance_amount, 2) }}</strong>
                    </div>

                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body d-grid gap-2">
                    <button type="button" class="btn btn-success">
                        <i class="feather-save"></i> Save Payment
                    </button>
                    <a href="{{ route('admin.billing.view') }}" class="btn btn-primary">
                        <i class="feather-eye"></i> View Invoice
                    </a>
                    <a href="{{ route('admin.billing.index') }}" class="btn btn-light">
                        Back to List
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.custom-badge {
    min-width: 110px;
    text-align: center;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 6px;
}

.detail-label {
    display: block;
    margin-bottom: 4px;
    font-size: 13px;
    color: #6c757d;
    font-weight: 500;
}

.detail-value {
    font-size: 15px;
    font-weight: 600;
    color: #212529;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-size: 15px;
}

.payment-history-table th,
.payment-history-table td {
    vertical-align: middle;
    white-space: nowrap;
}

.sticky-summary {
    position: sticky;
    top: 20px;
}

@media (max-width: 991.98px) {
    .sticky-summary {
        position: static;
    }
}
</style>
@endsection
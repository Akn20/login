@extends('layouts.admin')

@section('title', 'View Invoice')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-0">Invoice Details</h4>
            <small class="text-muted">Pharmacy → Billing → View</small>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.pharmacy.billing.index') }}" class="btn btn-light">
                ← Back
            </a>
        </div>
    </div>

    <div class="row">

        {{-- LEFT SIDE --}}
        <div class="col-lg-8">

            {{-- INVOICE SUMMARY --}}
            <div class="card mb-3">
                <div class="card-header bg-white d-flex justify-content-between">
                    <h5 class="mb-0">Invoice Summary</h5>

                    <div class="d-flex gap-2">
                        <span class="badge bg-primary">
                            {{ $invoice->invoice_status ?? 'N/A' }}
                        </span>
                        <span class="badge bg-warning">
                            {{ $invoice->payment_status ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label>Invoice No</label>
                            <div>{{ $invoice->bill_number }}</div>
                        </div>

                        <div class="col-md-4">
                            <label>Date</label>
                            <div>{{ $invoice->created_at->format('Y-m-d') }}</div>
                        </div>

                        <div class="col-md-4">
                            <label>Payment Mode</label>
                            <div>{{ $invoice->payment_mode ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label>Patient Name</label>
                            <div>{{ $invoice->display_patient_name }}
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>

            {{-- ITEMS --}}
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Invoice Items</h5>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Medicine</th>
                                <th>Batch</th>
                                <th>Qty</th>
                                <th class="text-end">Unit Price (₹)</th>
                                <th class="text-end">Total (₹)</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    {{-- MEDICINE --}}
                                    <td>{{ $item->medicine->medicine_name ?? '-' }}</td>

                                    {{-- BATCH --}}
                                    <td>{{ $item->batch->batch_number ?? '-' }}</td>

                                    {{-- QTY --}}
                                    <td>{{ $item->quantity }}</td>

                                    {{-- PRICE --}}
                                    <td class="text-end">{{ number_format($item->unit_price, 2) }}</td>

                                    {{-- TOTAL --}}
                                    <td class="text-end fw-bold">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No items found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- REMARKS --}}
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Remarks</h5>
                </div>
                <div class="card-body">
                    {{ $invoice->remarks ?? 'No remarks' }}
                </div>
            </div>

        </div>

        {{-- RIGHT SIDE --}}
        <div class="col-lg-4">

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Amount Summary</h5>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Amount</span>
                        <strong>₹ {{ number_format($invoice->total_amount, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Paid Amount</span>
                        <strong>₹ {{ number_format($invoice->paid_amount, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between text-danger">
                        <span>Balance</span>
                        <strong>₹ {{ number_format($invoice->balance_amount, 2) }}</strong>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
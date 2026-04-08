@extends('layouts.admin')

@section('title', 'Print Invoice')

@section('content')
<div class="container-fluid print-page">

    <div class="d-flex justify-content-between mb-3 no-print">
        <h4>Print Invoice</h4>
        <button onclick="window.print()" class="btn btn-primary">Print</button>
    </div>

    <div class="card invoice-print-card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h2>Pharmacy / Hospital Name</h2>
                    <p class="text-muted">Address, City, Phone, Email</p>
                </div>
                <div class="text-end">
                    <h3>PHARMACY INVOICE</h3>
                    <p>
                        Invoice No: <strong>{{ $bill->bill_number }}</strong><br>
                        Date: <strong>{{ $bill->created_at->format('Y-m-d') }}</strong><br>
                        Status: <strong>{{ $bill->invoice_status }}</strong>
                    </p>
                </div>
            </div>

            {{-- PAYMENT INFO --}}
            <h6>Invoice Info</h6>
            <table class="table table-borderless mb-4">
                <tr>
                    <td>Patient Name</td>
                    <td>: {{ $bill->display_patient_name }}</td>
                </tr>

                <tr>
                    <td>Payment Status</td>
                    <td>: {{ $bill->payment_status }}</td>
                </tr>
                <tr>
                    <td>Payment Mode</td>
                    <td>: {{ $bill->payment_mode }}</td>
                </tr>
                <tr>
                    <td>Paid Amount</td>
                    <td>: ₹ {{ number_format($bill->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Balance</td>
                    <td>: ₹ {{ number_format($bill->balance_amount, 2) }}</td>
                </tr>
            </table>

            {{-- ITEMS TABLE --}}
            <h6>Invoice Items</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Medicine</th>
                        <th>Batch</th>
                        <th>Qty</th>
                        <th>Unit Price (₹)</th>
                        
                        <th>Total (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($bill->items as $index => $item)
                        @php
                            $qty = $item->quantity;
                            $unit_price = $item->unit_price;
                            $line_total = $qty * $unit_price;
                            
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->medicine->medicine_name ?? 'N/A' }}</td>
                            <td>{{ $item->batch->batch_number ?? 'N/A' }}</td>
                            <td>{{ $qty }}</td>
                            <td>{{ number_format($unit_price,2) }}</td>
                            
                            
                            <td>{{ number_format($line_total,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- TOTALS --}}
            <table class="table table-sm mt-3">
                <tr>
                    <th>Total Amount</th>
                    <td>₹ {{ number_format($bill->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Paid Amount</th>
                    <td>₹ {{ number_format($bill->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Balance</th>
                    <td>₹ {{ number_format($bill->balance_amount, 2) }}</td>
                </tr>
            </table>

            {{-- REMARKS --}}
            <h6>Remarks / Notes</h6>
            <p>{{ $bill->remarks ?? 'No remarks available.' }}</p>

        </div>
    </div>
</div>

<style>
@media print {

    /* ❌ Hide everything */
    body * {
        visibility: hidden !important;
    }

    /* ✅ Show only your invoice */
    .print-page, .print-page * {
        visibility: visible !important;
    }

    /* ✅ Position invoice properly */
    .print-page {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    /* ❌ Extra safety (kill sidebar/navbar completely) */
    .main-sidebar,
    .app-sidebar,
    .navbar,
    nav,
    header,
    aside {
        display: none !important;
    }

    body {
        margin: 0;
        padding: 0;
    }
}
</style>
@endsection
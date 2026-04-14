@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Print Button -->
    <div class="text-end mb-3 no-print">
        <button onclick="window.print()" class="btn btn-success shadow-sm">
            <i class="bi bi-printer"></i> Print
        </button>
    </div>

    <!-- Receipt -->
    <div id="print-area">

        <div class="card shadow-sm border-0">

            <div class="card-body p-4">

                <!-- Hospital Header -->
                <div class="text-center mb-3">
                    <h4 class="fw-bold text-primary">HIMS</h4>
                </div>

                <hr>

                <!-- Receipt Info -->
                <div class="row mb-3">

                    <div class="col-6">
                        <p class="mb-1"><strong>Receipt No:</strong> {{ $billing->receipt_no }}</p>
                        <p class="mb-1"><strong>Date:</strong> {{ $billing->created_at->format('d-m-Y H:i') }}</p>
                    </div>

                    <div class="col-6 text-end">
                        <p class="mb-1"><strong>Payment Mode:</strong> {{ $billing->payment_mode }}</p>
                    </div>

                </div>

                <!-- Patient Details -->
                <div class="mb-3">
                    <h6 class="fw-bold text-secondary">Patient Details</h6>

                    <p class="mb-1">
                        <strong>Name:</strong>
                        {{ $billing->patient->first_name ?? '' }}
                        {{ $billing->patient->last_name ?? '' }}
                    </p>

                    <p class="mb-1">
                        <strong>UHID:</strong>
                        {{ $billing->patient->patient_code ?? '' }}
                    </p>
                </div>

                <hr>

                <!-- Billing Table -->
                <div class="table-responsive mb-3">
                    <table class="table table-bordered">

                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th class="text-end">Amount (₹)</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Consultation Fee</td>
                                <td class="text-end">{{ number_format($billing->amount, 2) }}</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-end text-success">₹{{ number_format($billing->amount, 2) }}</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>

                <!-- Footer -->
                <div class="row mt-4">

                    <div class="col-6">
                        <p class="text-muted small">
                            * This is a system generated receipt.
                        </p>
                    </div>

                    <div class="col-6 text-end">
                        <p>Authorized Signature</p>
                        <br>
                        <hr style="width:150px; margin-left:auto;">
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


{{-- ✅ PRINT STYLING (MAIN FIX) --}}
<style>

@page {
    size: A4;
    margin: 10mm;
}

#print-area {
    max-width: 700px;
    margin: auto;
}

/* PRINT MODE */
@media print {

    /* Hide everything */
    body * {
        visibility: hidden;
    }

    /* Show only receipt */
    #print-area, #print-area * {
        visibility: visible;
    }

    /* Position receipt */
    #print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    /* Hide UI elements */
    .no-print,
    .sidebar,
    .navbar,
    .header,
    .footer {
        display: none !important;
    }

    /* Remove shadows */
    .card {
        box-shadow: none !important;
        border: none !important;
    }

    /* Prevent page break */
    table, tr, td {
        page-break-inside: avoid !important;
    }
}

</style>
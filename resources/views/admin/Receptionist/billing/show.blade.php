@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Billing Details</h4>

        <div class="d-flex justify-content-end align-items-center gap-2">

    <a href="{{ route('admin.billing.index') }}"
       class="btn btn-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>

    <a href="{{ route('admin.billing.receipt', $billing->id) }}"
       class="btn btn-success shadow-sm">
        <i class="bi bi-printer me-1"></i> Print
    </a>

</div>
    </div>

    <!-- Card -->
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <!-- Billing Info -->
            <div class="row mb-4">

                <div class="col-md-6">
                    <p><strong>Receipt No:</strong> {{ $billing->receipt_no }}</p>
                    <p><strong>Date:</strong> {{ $billing->created_at->format('d-m-Y H:i') }}</p>
                </div>

                <div class="col-md-6 text-end">
                    <p>
                        <strong>Status:</strong>
                        <span class="badge bg-success">Paid</span>
                    </p>
                    <p><strong>Payment Mode:</strong> {{ $billing->payment_mode }}</p>
                </div>

            </div>

            <hr>

            <!-- Patient Details -->
            <div class="mb-4">
                <h6 class="fw-bold text-secondary">Patient Details</h6>

                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Name:</strong>
                            {{ $billing->patient->first_name ?? '' }}
                            {{ $billing->patient->last_name ?? '' }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <p><strong>UHID:</strong>
                            {{ $billing->patient->patient_code ?? '' }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Mobile:</strong>
                            {{ $billing->patient->mobile ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Billing Details -->
            <div class="mb-4">
                <h6 class="fw-bold text-secondary">Billing Details</h6>

                <div class="table-responsive">
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
                                <td class="text-end">{{ $billing->amount }}</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-end text-success">₹{{ $billing->amount }}</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>

            <hr>

            <!-- Footer -->
            <div class="row mt-4">

                <div class="col-md-6">
                    <p class="text-muted small">
                        Payment collected by Receptionist
                    </p>
                </div>

                <div class="col-md-6 text-end">
                    <p class="fw-semibold">
                        Collected By:
                        {{ auth()->user()->name ?? 'Admin' }}
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Claim Details</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.accountant.claims.index') }}" class="btn btn-light">
                <i class="feather-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">

        {{-- CLAIM INFO --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Claim Information</div>
                <div class="card-body d-flex flex-column">
                    <p><strong>Claim No:</strong> {{ $claim->claim_number }}</p>
                    <p><strong>Patient:</strong>
                        {{ $claim->patient->first_name ?? '' }}
                        {{ $claim->patient->last_name ?? '' }}
                    </p>
                    <p><strong>Provider:</strong> {{ $claim->insurance_provider }}</p>
                    <p><strong>Billed Amount:</strong> ₹ {{ number_format($claim->billed_amount, 2) }}</p>
                </div>
            </div>
        </div>

        {{-- APPROVAL --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Approval</div>
                <div class="card-body d-flex flex-column">
                    {{-- Show approved amount --}}
                    @if($claim->approval)
                        <p class="text-success">
                            Approved Amount: ₹ {{ number_format($claim->approval->approved_amount, 2) }}
                        </p>
                    @endif

                    {{-- Show uploaded document --}}
                    @if($claim->approval && $claim->approval->document)
                        <p>
                            <strong>Document:</strong>
                            <a href="{{ asset('storage/'.$claim->approval->document) }}" target="_blank">
                                View File
                            </a>
                        </p>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('admin.accountant.claims.approval') }}" enctype="multipart/form-data" class="mt-auto">
                        @csrf
                        <input type="hidden" name="claim_id" value="{{ $claim->id }}">

                        <input type="number" step="0.01" name="approved_amount"
                               class="form-control mb-2"
                               placeholder="Enter Approved Amount">

                        <input type="file" name="document" class="form-control mb-2">

                        <button class="btn btn-success btn-sm w-100">
                            Save / Update Approval
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- PAYMENTS --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Payments</div>
                <div class="card-body d-flex flex-column">
                    {{-- LIST --}}
                    @if($claim->payments->count())
                        <ul class="list-group mb-3 flex-grow-1">
                            @foreach($claim->payments as $payment)
                                <li class="list-group-item d-flex justify-content-between">
                                    <div>
                                        ₹ {{ number_format($payment->payment_amount, 2) }} <br>
                                        <small class="text-muted">
                                            {{ $payment->payment_mode ?? 'N/A' }}
                                        </small>
                                        @if($payment->transaction_reference)
                                            <br>
                                            <small class="text-info">
                                                Ref: {{ $payment->transaction_reference }}
                                            </small>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="flex-grow-1">No payments added yet</p>
                    @endif

                    {{-- ADD PAYMENT --}}
                    <form method="POST" action="{{ route('admin.accountant.claims.payment') }}" class="mt-auto">
                        @csrf
                        <input type="hidden" name="claim_id" value="{{ $claim->id }}">

                        <input type="number" step="0.01" name="payment_amount"
                               class="form-control mb-2"
                               placeholder="Enter Amount">

                        <input type="text" name="payment_mode"
                               class="form-control mb-2"
                               placeholder="Payment Mode (Cash / Bank / UPI)">

                        <input type="text" name="transaction_reference"
                               class="form-control mb-2"
                               placeholder="Transaction Reference (UTR / Cheque No)">

                        <button class="btn btn-primary btn-sm w-100">
                            Add Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- RECONCILIATION --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Reconciliation</div>
                <div class="card-body d-flex flex-column">
                    @php
                        $approved = $claim->approval->approved_amount ?? 0;
                        $paid = $claim->payments->sum('payment_amount');
                        $diff = $approved - $paid;
                    @endphp

                    <p>Approved: ₹ {{ number_format($approved, 2) }}</p>
                    <p>Paid: ₹ {{ number_format($paid, 2) }}</p>

                    <p>
                        Difference:
                        <strong class="{{ $diff == 0 ? 'text-success' : 'text-danger' }}">
                            ₹ {{ number_format($diff, 2) }}
                        </strong>
                    </p>

                    {{-- ✅ SHOW EXISTING REMARKS --}}
                    @if($claim->reconciliation && $claim->reconciliation->remarks)
                        <p class="mt-2">
                            <strong>Remarks:</strong><br>
                            <span class="text-muted">
                                {{ $claim->reconciliation->remarks }}
                            </span>
                        </p>
                    @endif

                    {{-- ✅ FORM INSTEAD OF LINK --}}
                    <form method="POST" action="{{ route('admin.accountant.claims.reconcile', $claim->id) }}" class="mt-auto">
                        @csrf

                        <textarea name="remarks"
                                  class="form-control mb-2"
                                  placeholder="Enter remarks (optional)"></textarea>

                        <button class="btn btn-warning btn-sm w-100">
                            Recalculate & Save
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
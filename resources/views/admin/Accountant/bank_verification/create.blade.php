@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header mb-4">

        <div class="page-header-left">
            <h5 class="m-b-0">
                Create Bank Verification
            </h5>
        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.bank-verification.index') }}"
               class="btn btn-light">

                Back

            </a>

        </div>

    </div>

    {{-- CARD --}}
    <div class="card">

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.bank-verification.store') }}">

                @csrf

                <div class="row">

                    {{-- RECONCILIATION --}}
                    <div class="col-md-6 mb-3">

                        <label>Reconciliation</label>

                        <select name="financial_reconciliation_id"
                                class="form-control"
                                required>

                            <option value="">
                                Select Reconciliation
                            </option>

                            @foreach($reconciliations as $item)

                                <option value="{{ $item->id }}">

                                    {{ $item->reconciliation_date }}
                                    -
                                    ₹ {{ number_format($item->total_cash + $item->total_digital, 2) }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- BANK NAME --}}
                    <div class="col-md-6 mb-3">

                        <label>Bank Name</label>

                        <input type="text"
                               name="bank_name"
                               class="form-control"
                               required>

                    </div>

                    {{-- DEPOSIT AMOUNT --}}
                    <div class="col-md-6 mb-3">

                        <label>Deposit Amount</label>

                        <input type="number"
                               step="0.01"
                               name="deposit_amount"
                               class="form-control"
                               required>

                    </div>

                    {{-- DEPOSIT DATE --}}
                    <div class="col-md-6 mb-3">

                        <label>Deposit Date</label>

                        <input type="date"
                               name="deposit_date"
                               class="form-control"
                               required>

                    </div>

                    {{-- REFERENCE NUMBER --}}
                    <div class="col-md-6 mb-3">

                        <label>Reference Number</label>

                        <input type="text"
                               name="reference_number"
                               class="form-control">

                    </div>

                    {{-- VERIFIED BY --}}
                    <div class="col-md-6 mb-3">

                        <label>Verified By</label>

                        <input type="text"
                               name="verified_by"
                               class="form-control">

                    </div>

                    {{-- REMARKS --}}
                    <div class="col-12 mb-3">

                        <label>Remarks</label>

                        <textarea name="remarks"
                                  class="form-control"
                                  rows="4"></textarea>

                    </div>

                </div>

                <button class="btn btn-success">

                    Save Verification

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
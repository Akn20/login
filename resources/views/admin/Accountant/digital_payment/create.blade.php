@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header mb-4">

        <div class="page-header-left">
            <h5 class="m-b-0">
                Create Digital Payment
            </h5>
        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.digital-payment.index') }}"
               class="btn btn-light">

                Back

            </a>

        </div>

    </div>

    {{-- FORM --}}
    <div class="card">

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.digital-payment.store') }}">

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

                    {{-- METHOD --}}
                    <div class="col-md-6 mb-3">

                        <label>Payment Method</label>

                        <select name="payment_method"
                                class="form-control"
                                required>

                            <option value="">Select</option>

                            <option value="UPI">UPI</option>

                            <option value="Card">Card</option>

                            <option value="Net Banking">Net Banking</option>

                            <option value="Wallet">Wallet</option>

                        </select>

                    </div>

                    {{-- GATEWAY --}}
                    <div class="col-md-6 mb-3">

                        <label>Payment Gateway</label>

                        <input type="text"
                               name="payment_gateway"
                               class="form-control"
                               required>

                    </div>

                    {{-- AMOUNT --}}
                    <div class="col-md-6 mb-3">

                        <label>Payment Amount</label>

                        <input type="number"
                               step="0.01"
                               name="payment_amount"
                               class="form-control"
                               required>

                    </div>

                    {{-- DATE --}}
                    <div class="col-md-6 mb-3">

                        <label>Payment Date</label>

                        <input type="date"
                               name="payment_date"
                               class="form-control"
                               required>

                    </div>

                    {{-- TRANSACTION REF --}}
                    <div class="col-md-6 mb-3">

                        <label>Transaction Reference</label>

                        <input type="text"
                               name="transaction_reference"
                               class="form-control">

                    </div>

                    {{-- REMARKS --}}
                    <div class="col-12 mb-3">

                        <label>Remarks</label>

                        <textarea name="remarks"
                                  rows="4"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <button class="btn btn-success">

                    Save Payment

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
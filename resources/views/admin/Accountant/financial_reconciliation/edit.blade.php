@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Edit Financial Reconciliation</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.financial-reconciliation.index') }}"
               class="btn btn-light">
                Back
            </a>
        </div>
    </div>

    <div class="card">

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.financial-reconciliation.update', $reconciliation->id) }}">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Date</label>

                        <input type="date"
                               name="reconciliation_date"
                               class="form-control"
                                 value="{{ old('reconciliation_date', $reconciliation->reconciliation_date) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Total Cash</label>

                        <input type="number"
                               step="0.01"
                               name="total_cash"
                                 value="{{ old('total_cash', $reconciliation->total_cash) }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Total Digital Payments</label>

                        <input type="number"
                               step="0.01"
                               name="total_digital"
                               class="form-control"
                                    value="{{ old('total_digital', $reconciliation->total_digital) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Total Bank Deposit</label>

                        <input type="number"
                               step="0.01"
                               name="total_bank_deposit"
                               class="form-control"
                                    value="{{ old('total_bank_deposit', $reconciliation->total_bank_deposit) }}"
                               required>
                    </div>

                                        <div class="col-md-6 mb-3">

                        <label>Bank Name</label>

                        <input type="text"
                            name="bank_name"
                            class="form-control"
                            value="{{ old('bank_name', $reconciliation->bank_name) }}">

                    </div>

                    <div class="col-md-6 mb-3">

                    <label>Deposit Reference</label>

                    <input type="text"
                        name="deposit_reference"
                        class="form-control"
                        value="{{ old('deposit_reference', $reconciliation->deposit_reference) }}">

                </div>

                <div class="col-md-6 mb-3">

    <label>Verification Status</label>

    <select name="verification_status"
            class="form-control"
            required>

        <option value="">Select Status</option>

        <option value="Pending"
            {{ old('verification_status', $reconciliation->verification_status) == 'Pending' ? 'selected' : '' }}>
            Pending
        </option>

        <option value="Verified"
            {{ old('verification_status', $reconciliation->verification_status) == 'Verified' ? 'selected' : '' }}>
            Verified
        </option>

        <option value="Mismatch"
            {{ old('verification_status', $reconciliation->verification_status) == 'Mismatch' ? 'selected' : '' }}>
            Mismatch
        </option>

    </select>

</div>

            <div class="col-md-6 mb-3">

    <label>Payment Gateway</label>

    <select name="payment_gateway"
            class="form-control">

        <option value="">Select</option>

        <option value="UPI"
            {{ old('payment_gateway', $reconciliation->payment_gateway) == 'UPI' ? 'selected' : '' }}>
            UPI
        </option>

        <option value="Card"
            {{ old('payment_gateway', $reconciliation->payment_gateway) == 'Card' ? 'selected' : '' }}>
            Card
        </option>

        <option value="Net Banking"
            {{ old('payment_gateway', $reconciliation->payment_gateway) == 'Net Banking' ? 'selected' : '' }}>
            Net Banking
        </option>

        <option value="Wallet"
            {{ old('payment_gateway', $reconciliation->payment_gateway) == 'Wallet' ? 'selected' : '' }}>
            Wallet
        </option>

    </select>

</div>

                    <div class="col-md-6 mb-3">

                        <label>Gateway Reference</label>

                        <input type="text"
                            name="gateway_reference"
                            value="{{ old('gateway_reference', $reconciliation->gateway_reference) }}"
                            class="form-control">

                    </div>


                    <div class="col-md-6 mb-3">

    <label>Digital Payment Status</label>

    <select name="digital_payment_status"
            class="form-control"
            required>

        <option value="">Select Status</option>

        <option value="Pending"
            {{ old('digital_payment_status', $reconciliation->digital_payment_status) == 'Pending' ? 'selected' : '' }}>
            Pending
        </option>

        <option value="Success"
            {{ old('digital_payment_status', $reconciliation->digital_payment_status) == 'Success' ? 'selected' : '' }}>
            Success
        </option>

        <option value="Failed"
            {{ old('digital_payment_status', $reconciliation->digital_payment_status) == 'Failed' ? 'selected' : '' }}>
            Failed
        </option>

    </select>

</div>

                    <div class="col-12 mb-3">
                        <label>Remarks</label>

                        <textarea name="remarks"
                                  class="form-control"
                                  rows="4">{{ old('remarks', $reconciliation->remarks) }}</textarea>
                    </div>

                </div>

                <button class="btn btn-success">
                    Save Reconciliation
                </button>

            </form>

        </div>

    </div>

</div>

@endsection
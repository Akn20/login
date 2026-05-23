@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="page-header mb-4">
        <div class="page-header-left">
            <h5 class="m-b-0">Create Financial Reconciliation</h5>
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
                  action="{{ route('admin.financial-reconciliation.store') }}">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Date</label>

                        <input type="date"
                               name="reconciliation_date"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Total Cash</label>

                        <input type="number"
                               step="0.01"
                               name="total_cash"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Total Digital Payments</label>

                        <input type="number"
                    name="total_digital"
                    class="form-control"
                    value="{{ old('total_digital') }}"
                    readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Total Bank Deposit</label>

                                        <input type="number"
                    name="total_bank_deposit"
                    class="form-control"
                    value="{{ old('total_bank_deposit') }}"
                    readonly>
                    </div>

                                        <div class="col-md-6 mb-3">

                        <label>Bank Name</label>

                        <input type="text"
                            name="bank_name"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                    <label>Deposit Reference</label>

                    <input type="text"
                        name="deposit_reference"
                        class="form-control">

                </div>

                                <div class="col-md-6 mb-3">

                    <label>Verification Status</label>

                    <select name="verification_status"
                            class="form-control">

                        <option value="Pending">Pending</option>
                        <option value="Verified">Verified</option>
                        <option value="Mismatch">Mismatch</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                        <label>Payment Gateway</label>

                        <select name="payment_gateway"
                                class="form-control">

                            <option value="">Select</option>
                            <option value="UPI">UPI</option>
                            <option value="Card">Card</option>
                            <option value="Net Banking">Net Banking</option>
                            <option value="Wallet">Wallet</option>

                        </select>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label>Gateway Reference</label>

                        <input type="text"
                            name="gateway_reference"
                            class="form-control">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label>Digital Payment Status</label>

                        <select name="digital_payment_status"
                                class="form-control">

                            <option value="Pending">Pending</option>
                            <option value="Success">Success</option>
                            <option value="Failed">Failed</option>

                        </select>

                    </div>

                    <div class="col-12 mb-3">
                        <label>Remarks</label>

                        <textarea name="remarks"
                                  class="form-control"
                                  rows="4"></textarea>
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
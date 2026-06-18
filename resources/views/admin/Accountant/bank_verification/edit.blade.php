@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header mb-4">

        <div class="page-header-left">
            <h5 class="m-b-0">
                Edit Bank Verification
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
                  action="{{ route('admin.bank-verification.update', $verification->id) }}">

                @csrf
                @method('PUT')

                <div class="row">

                    
                    <div class="col-md-6 mb-3">

    <label>Select Reconciliation</label>

    <select name="financial_reconciliation_id"
            class="form-control"
            required>

        <option value="">
            Select reconciliation
        </option>

        @foreach($reconciliations as $item)

            <option value="{{ $item->id }}"

                        {{ $verification->financial_reconciliation_id == $item->id
                            ? 'selected'
                            : '' }}>

                        {{ $item->reconciliation_date }}
                        -
                        ₹ {{ number_format(
                            $item->total_cash +
                            $item->total_digital,
                            2
                        ) }}

                    </option>

        @endforeach

    </select>

</div>

                    {{-- BANK NAME --}}
                    <div class="col-md-6 mb-3">

                        <label>Bank Name</label>

                        <input type="text"
                               name="bank_name"
                               value="{{ old('bank_name', $verification->bank_name) }}"
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
                                 value="{{ old('deposit_amount', $verification->deposit_amount) }}"
                               required>

                    </div>

                    {{-- DEPOSIT DATE --}}
                    <div class="col-md-6 mb-3">

                        <label>Deposit Date</label>

                        <input type="date"
                               name="deposit_date"
                               class="form-control"
                                value="{{ old('deposit_date', $verification->deposit_date) }}"
                               required>

                    </div>

                    {{-- REFERENCE NUMBER --}}
                    <div class="col-md-6 mb-3">

                        <label>Reference Number</label>

                        <input type="text"
                               name="reference_number"
                               class="form-control"
                               value="{{ old('reference_number', $verification->reference_number) }}">

                    </div>

                    {{-- VERIFIED BY --}}
                    <div class="col-md-6 mb-3">

                        <label>Verified By</label>

                        <input type="text"
                               name="verified_by"
                               class="form-control"
                               value="{{ old('verified_by', $verification->verified_by) }}">

                    </div>

                    {{-- REMARKS --}}
                    <div class="col-12 mb-3">

                        <label>Remarks</label>

                        <textarea name="remarks"
                                  class="form-control"
                                  rows="4">{{ old('remarks', $verification->remarks) }}</textarea>

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
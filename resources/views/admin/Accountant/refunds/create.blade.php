@extends('layouts.admin')

@section('page-title', 'Create Refund')

@section('content')

<div class="page-header mb-4">

    <div class="page-header-left">

        <h5>Create Refund</h5>

    </div>

</div>

{{-- VALIDATION ERRORS --}}
@if ($errors->any())

<div class="alert alert-danger">

    <ul class="mb-0">

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

<div class="card">

    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.refunds.store') }}"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                {{-- PATIENT --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Patient

                    </label>

                    <select name="patient_id"
                            class="form-control"
                            required>

                        <option value="">
                            Select Patient
                        </option>

                        @foreach($patients as $patient)

                        <option value="{{ $patient->id }}">

                            {{ $patient->patient_code }}
                            -
                            {{ $patient->first_name }}
                            {{ $patient->last_name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                {{-- REFUND TYPE --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Refund Type

                    </label>

                    <select name="refund_type"
                            class="form-control"
                            required>

                        <option value="">
                            Select Refund Type
                        </option>

                        <option value="OPD">
                            OPD
                        </option>

                        <option value="IPD">
                            IPD
                        </option>

                        <option value="PHARMACY">
                            Pharmacy
                        </option>

                        <option value="LAB">
                            Laboratory
                        </option>

                        <option value="ADVANCE">
                            Advance
                        </option>

                        <option value="INSURANCE">
                            Insurance
                        </option>

                        <option value="CANCELLATION">
                            Cancellation
                        </option>

                    </select>

                </div>

                {{-- REFUND DATE --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Refund Date

                    </label>

                    <input type="date"
                           name="refund_date"
                           class="form-control"
                           required>

                </div>

                {{-- AMOUNT --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Refund Amount

                    </label>

                    <input type="number"
                           step="0.01"
                           name="refund_amount"
                           class="form-control"
                           required>

                </div>

                {{-- BILL TYPE --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Bill Type

                    </label>

                    <select name="bill_type"
                            class="form-control">

                        <option value="">
                            Select Bill Type
                        </option>

                        <option value="OPD">
                            OPD
                        </option>

                        <option value="IPD">
                            IPD
                        </option>

                        <option value="PHARMACY">
                            Pharmacy
                        </option>

                        <option value="LAB">
                            Laboratory
                        </option>

                    </select>

                </div>

                {{-- BILL ID --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Bill ID

                    </label>

                    <input type="text"
                           name="bill_id"
                           class="form-control">

                </div>

                {{-- REASON --}}
                <div class="col-md-12 mb-3">

                    <label class="form-label">

                        Refund Reason

                    </label>

                    <textarea name="refund_reason"
                              rows="4"
                              class="form-control"
                              required></textarea>

                </div>

                {{-- REMARKS --}}
                <div class="col-md-12 mb-3">

                    <label class="form-label">

                        Remarks

                    </label>

                    <textarea name="remarks"
                              rows="3"
                              class="form-control"></textarea>

                </div>

                {{-- DOCUMENT --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Supporting Document

                    </label>

                    <input type="file"
                           name="document"
                           class="form-control">

                </div>

            </div>

            {{-- BUTTONS --}}
            <div class="text-end">

                <button type="submit"
                        class="btn btn-primary">

                    Submit Refund

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Edit Refund')

@section('content')

<div class="page-header mb-4">

    <div class="page-header-left">

        <h5>Edit Refund</h5>

    </div>

</div>

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
              action="{{ route('admin.refunds.update', $refund->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                {{-- PATIENT --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Patient

                    </label>

                    <select name="patient_id"
                            class="form-control"
                            required>

                        @foreach($patients as $patient)

                        <option value="{{ $patient->id }}"
                            {{ $refund->patient_id == $patient->id ? 'selected' : '' }}>

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

                        @foreach([
                            'OPD',
                            'IPD',
                            'PHARMACY',
                            'LAB',
                            'ADVANCE',
                            'INSURANCE',
                            'CANCELLATION'
                        ] as $type)

                        <option value="{{ $type }}"
                            {{ $refund->refund_type == $type ? 'selected' : '' }}>

                            {{ $type }}

                        </option>

                        @endforeach

                    </select>

                </div>

                {{-- DATE --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Refund Date

                    </label>

                    <input type="date"
                           name="refund_date"
                           class="form-control"
                           value="{{ $refund->refund_date->format('Y-m-d') }}"
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
                           value="{{ $refund->refund_amount }}"
                           required>

                </div>

                {{-- BILL TYPE --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Bill Type

                    </label>

                    <select name="bill_type"
                            class="form-control">

                        @foreach([
                            'OPD',
                            'IPD',
                            'PHARMACY',
                            'LAB'
                        ] as $billType)

                        <option value="{{ $billType }}"
                            {{ $refund->bill_type == $billType ? 'selected' : '' }}>

                            {{ $billType }}

                        </option>

                        @endforeach

                    </select>

                </div>

                {{-- BILL ID --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Bill ID

                    </label>

                    <input type="text"
                           name="bill_id"
                           class="form-control"
                           value="{{ $refund->bill_id }}">

                </div>

                {{-- REASON --}}
                <div class="col-md-12 mb-3">

                    <label class="form-label">

                        Refund Reason

                    </label>

                    <textarea name="refund_reason"
                              rows="4"
                              class="form-control"
                              required>{{ $refund->refund_reason }}</textarea>

                </div>

                {{-- REMARKS --}}
                <div class="col-md-12 mb-3">

                    <label class="form-label">

                        Remarks

                    </label>

                    <textarea name="remarks"
                              rows="3"
                              class="form-control">{{ $refund->remarks }}</textarea>

                </div>

                {{-- DOCUMENT --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Replace Document

                    </label>

                    <input type="file"
                           name="document"
                           class="form-control">

                </div>

                {{-- EXISTING DOCUMENT --}}
                @if($refund->document)

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Existing Document

                    </label>

                    <br>

                    <a href="{{ asset('storage/' . $refund->document) }}"
                       target="_blank"
                       class="btn btn-info btn-sm">

                        View Document

                    </a>

                </div>

                @endif

            </div>

            {{-- BUTTON --}}
            <div class="text-end">

                <button type="submit"
                        class="btn btn-primary">

                    Update Refund

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
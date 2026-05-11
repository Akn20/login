@extends('layouts.admin')

@section('title', 'Record Data Usage Consent')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                Record Data Usage Consent

            </h4>

            <a href="{{ route('admin.data-consent.index') }}"
               class="btn btn-secondary btn-sm">

                Back

            </a>

        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('admin.data-consent.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    {{-- Patient --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Select Patient

                        </label>

                        <select name="patient_id"
                                class="form-select"
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

                    {{-- Purpose --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Purpose

                        </label>

                        <select name="purpose"
                                class="form-select"
                                required>

                            <option value="">

                                Select Purpose

                            </option>

                            <option value="Treatment">

                                Treatment

                            </option>

                            <option value="Billing">

                                Billing

                            </option>

                            <option value="Insurance">

                                Insurance

                            </option>

                            <option value="Research">

                                Research

                            </option>

                            <option value="Internal Usage">

                                Internal Usage

                            </option>

                        </select>

                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Consent Status

                        </label>

                        <select name="consent_status"
                                class="form-select"
                                required>

                            <option value="">

                                Select Status

                            </option>

                            <option value="Granted">

                                Granted

                            </option>

                            <option value="Refused">

                                Refused

                            </option>

                            <option value="Pending">

                                Pending

                            </option>

                        </select>

                    </div>

                    {{-- Remarks --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Remarks

                        </label>

                        <textarea name="remarks"
                                  rows="4"
                                  class="form-control"></textarea>

                    </div>

                    {{-- Upload --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Upload Consent Document

                        </label>

                        <input type="file"
                               name="document"
                               class="form-control">

                    </div>

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    Save Consent

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
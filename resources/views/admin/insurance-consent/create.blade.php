@extends('layouts.admin')

@section('title', 'Create Insurance Consent')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                Create Insurance Consent

            </h4>

            <a href="{{ route('admin.insurance-consent.index') }}"
               class="btn btn-secondary btn-sm">

                Back

            </a>

        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('admin.insurance-consent.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    {{-- Patient --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Patient

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

                    {{-- Insurance --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Insurance

                        </label>

                        <select name="insurance_id"
                                class="form-select"
                                required>

                            <option value="">

                                Select Insurance

                            </option>

                            @foreach($insurances as $insurance)

                                <option value="{{ $insurance->id }}">

                                    {{ $insurance->provider_name }}
                                    -
                                    {{ $insurance->policy_number }}

                                </option>

                            @endforeach

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

                            <option value="Pending">

                                Pending

                            </option>

                            <option value="Approved">

                                Approved

                            </option>

                            <option value="Rejected">

                                Rejected

                            </option>

                        </select>

                    </div>

                    {{-- Document --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Upload Document

                        </label>

                        <input type="file"
                               name="document"
                               class="form-control">

                    </div>

                    {{-- Consent Text --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Consent Text

                        </label>

                        <textarea name="consent_text"
                                  rows="5"
                                  class="form-control"></textarea>

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
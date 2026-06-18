@extends('layouts.admin')

@section('title', 'Edit Insurance Consent')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            <div class="card shadow-sm border-0">

                {{-- Header --}}
                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <div>

                        <h4 class="mb-0">

                            Edit Insurance Consent

                        </h4>

                        <small class="text-muted">

                            Update insurance consent information

                        </small>

                    </div>

                    <a href="{{ route('admin.insurance-consent.index') }}"
                       class="btn btn-outline-secondary btn-sm">

                        <i class="feather-arrow-left me-1"></i>

                        Back

                    </a>

                </div>

                {{-- Body --}}
                <div class="card-body">

                    {{-- Validation Errors --}}
                    @if($errors->any())

                        <div class="alert alert-danger">

                            <strong>

                                Please fix the following errors:

                            </strong>

                            <ul class="mb-0 mt-2">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    {{-- Form --}}
                    <form action="{{ route('admin.insurance-consent.update', $consent->id) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- Patient --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Patient

                                </label>

                                <select name="patient_id"
                                        class="form-select"
                                        required>

                                    <option value="">

                                        Select Patient

                                    </option>

                                    @foreach($patients as $patient)

                                        <option value="{{ $patient->id }}"
                                            {{ $consent->patient_id == $patient->id ? 'selected' : '' }}>

                                            {{ $patient->patient_code }}
                                            -
                                            {{ $patient->first_name }}
                                            {{ $patient->last_name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- Insurance --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Insurance

                                </label>

                                <select name="insurance_id"
                                        class="form-select"
                                        required>

                                    <option value="">

                                        Select Insurance

                                    </option>

                                    @foreach($insurances as $insurance)

                                        <option value="{{ $insurance->id }}"
                                            {{ $consent->insurance_id == $insurance->id ? 'selected' : '' }}>

                                            {{ $insurance->provider_name }}
                                            -
                                            {{ $insurance->policy_number }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Consent Status

                                </label>

                                <select name="consent_status"
                                        class="form-select"
                                        required>

                                    <option value="Pending"
                                        {{ $consent->consent_status == 'Pending' ? 'selected' : '' }}>

                                        Pending

                                    </option>

                                    <option value="Approved"
                                        {{ $consent->consent_status == 'Approved' ? 'selected' : '' }}>

                                        Approved

                                    </option>

                                    <option value="Rejected"
                                        {{ $consent->consent_status == 'Rejected' ? 'selected' : '' }}>

                                        Rejected

                                    </option>

                                </select>

                            </div>

                            {{-- Upload --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Upload Document

                                </label>

                                <input type="file"
                                       name="document"
                                       class="form-control">

                                @if($consent->document)

                                    <div class="mt-2">

                                        <a href="{{ asset('storage/' . $consent->document) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-success">

                                            <i class="feather-eye me-1"></i>

                                            View Current Document

                                        </a>

                                    </div>

                                @endif

                            </div>

                            {{-- Consent Text --}}
                            <div class="col-md-12 mb-4">

                                <label class="form-label fw-semibold">

                                    Consent Text

                                </label>

                                <textarea name="consent_text"
                                          rows="6"
                                          class="form-control"
                                          placeholder="Enter insurance consent details...">{{ old('consent_text', $consent->consent_text) }}</textarea>

                            </div>

                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end">

                            <a href="{{ route('admin.insurance-consent.index') }}"
                               class="btn btn-light me-2">

                                Cancel

                            </a>

                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="feather-save me-1"></i>

                                Update Consent

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
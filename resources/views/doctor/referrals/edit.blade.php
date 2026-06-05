@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Edit Referral
            </h3>

            <p class="text-muted mb-0">
                Update referral information and clinical notes
            </p>

        </div>

        <a href="{{ route('doctor.referrals.index') }}"
           class="btn btn-secondary">

            <i class="fa fa-arrow-left me-1"></i>
            Back

        </a>

    </div>

    <!-- Validation Errors -->
    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('doctor.referrals.update', $referral->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="row">

            <!-- Left -->
            <div class="col-lg-8">

                <!-- Patient Information -->
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Patient Information
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <!-- Patient -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Patient
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $referral->patient->first_name ?? '' }} {{ $referral->patient->last_name ?? '' }}"
                                       readonly>

                            </div>

                            <!-- UHID -->
                            <div class="col-md-3">

                                <label class="form-label">
                                    Patient Code
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $referral->patient->patient_code ?? '-' }}"
                                       readonly>

                            </div>

                            <!-- Age/Gender -->
                            <div class="col-md-3">

                                <label class="form-label">
                                    Gender
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $referral->patient->gender ?? '-' }}"
                                       readonly>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Referral Information -->
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Referral Information
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <!-- Referred Doctor -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Referred Doctor
                                </label>

                                <select class="form-select"
                                        name="referred_doctor_id">

                                    <option value="">
                                        Select Doctor
                                    </option>

                                    @foreach($doctors as $doctor)

                                        <option value="{{ $doctor->id }}"
                                            {{ $referral->referred_doctor_id == $doctor->id ? 'selected' : '' }}>

                                            {{ $doctor->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <!-- Department -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Department
                                </label>

                                <select class="form-select"
                                        name="referred_department_id">

                                    <option value="">
                                        Select Department
                                    </option>

                                    @foreach($departments as $department)

                                        <option value="{{ $department->id }}"
                                            {{ $referral->referred_department_id == $department->id ? 'selected' : '' }}>

                                            {{ $department->department_name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <!-- Referral Type -->
                            <div class="col-md-4">

                                <label class="form-label">
                                    Referral Type
                                </label>

                                <select class="form-select"
                                        name="referral_type">

                                    <option value="Internal"
                                        {{ $referral->referral_type == 'Internal' ? 'selected' : '' }}>

                                        Internal

                                    </option>

                                    <option value="External"
                                        {{ $referral->referral_type == 'External' ? 'selected' : '' }}>

                                        External

                                    </option>

                                </select>

                            </div>

                            <!-- Priority -->
                            <div class="col-md-4">

                                <label class="form-label">
                                    Priority
                                </label>

                                <select class="form-select"
                                        name="priority">

                                    <option value="Normal"
                                        {{ $referral->priority == 'Normal' ? 'selected' : '' }}>

                                        Normal

                                    </option>

                                    <option value="Urgent"
                                        {{ $referral->priority == 'Urgent' ? 'selected' : '' }}>

                                        Urgent

                                    </option>

                                    <option value="Emergency"
                                        {{ $referral->priority == 'Emergency' ? 'selected' : '' }}>

                                        Emergency

                                    </option>

                                </select>

                            </div>

                            <!-- Followup -->
                            <div class="col-md-4">

                                <label class="form-label">
                                    Follow-up Date
                                </label>

                                <input type="date"
                                       class="form-control"
                                       name="followup_date"
                                       value="{{ $referral->followup_date }}">

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Clinical -->
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Clinical Information
                        </h5>

                    </div>

                    <div class="card-body">

                        <!-- Reason -->
                        <div class="mb-3">

                            <label class="form-label">
                                Referral Reason
                            </label>

                            <textarea rows="4"
                                      class="form-control"
                                      name="referral_reason"
                                      required>{{ $referral->referral_reason }}</textarea>

                        </div>

                        <!-- Notes -->
                        <div>

                            <label class="form-label">
                                Clinical Notes
                            </label>

                            <textarea rows="5"
                                      class="form-control"
                                      name="clinical_notes">{{ $referral->clinical_notes }}</textarea>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Right -->
            <div class="col-lg-4">

                <!-- Summary -->
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Referral Summary
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <small class="text-muted">
                                Referral ID
                            </small>

                            <h6 class="mb-0">
                                {{ $referral->id }}
                            </h6>

                        </div>

                        <div class="mb-3">

                            <small class="text-muted">
                                Created Date
                            </small>

                            <h6 class="mb-0">
                                {{ date('d-M-Y', strtotime($referral->created_at)) }}
                            </h6>

                        </div>

                        <div>

                            <small class="text-muted">
                                Current Status
                            </small><br>

                            <span class="badge bg-primary px-3 py-2">

                                {{ $referral->status }}

                            </span>

                        </div>

                    </div>

                </div>

                <!-- Status -->
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Update Status
                        </h5>

                    </div>

                    <div class="card-body">

                        <label class="form-label">
                            Change Referral Status
                        </label>

                        <select class="form-select"
                                name="status">

                            <option value="Pending"
                                {{ $referral->status == 'Pending' ? 'selected' : '' }}>

                                Pending

                            </option>

                            <option value="Accepted"
                                {{ $referral->status == 'Accepted' ? 'selected' : '' }}>

                                Accepted

                            </option>

                            <option value="In Progress"
                                {{ $referral->status == 'In Progress' ? 'selected' : '' }}>

                                In Progress

                            </option>

                            <option value="Completed"
                                {{ $referral->status == 'Completed' ? 'selected' : '' }}>

                                Completed

                            </option>

                            <option value="Rejected"
                                {{ $referral->status == 'Rejected' ? 'selected' : '' }}>

                                Rejected

                            </option>

                        </select>

                    </div>

                </div>

                <!-- Buttons -->
                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <button type="submit"
                                class="btn btn-primary w-100 mb-2">

                            <i class="fa fa-save me-1"></i>
                            Update Referral

                        </button>

                        <a href="{{ route('doctor.referrals.index') }}"
                           class="btn btn-danger w-100 mb-2">

                            Cancel

                        </a>

                        <button type="reset"
                                class="btn btn-light border w-100">

                            Reset Changes

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
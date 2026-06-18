@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Create Referral
            </h3>

            <p class="text-muted mb-0">
                Refer patient to another doctor or department
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

    <form action="{{ route('doctor.referrals.store') }}"
          method="POST">

        @csrf

        <div class="row">

            <!-- Left Section -->
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

<select class="form-select"
        name="patient_id"
        id="patient_id"
        required>

    <option value="">
        Select Patient
    </option>

    @foreach($patients as $patient)

        <option value="{{ $patient->id }}"
            data-uhid="{{ $patient->patient_code }}"
            data-gender="{{ $patient->gender }}"
            data-dob="{{ $patient->date_of_birth }}"
            {{ old('patient_id') == $patient->id ? 'selected' : '' }}>

            {{ $patient->first_name }}
            {{ $patient->last_name }}
            - {{ $patient->patient_code }}

        </option>

    @endforeach

</select>

                            </div>

                            <!-- UHID -->
                            <div class="col-md-3">

                                <label class="form-label">
                                    UUID
                                </label>

<input type="text"
       class="form-control"
       id="patient_uhid"
       readonly>

                            </div>

                            <!-- Age/Gender -->
                            <div class="col-md-3">

                                <label class="form-label">
                                    Age/Gender
                                </label>

<input type="text"
       class="form-control"
       id="patient_age_gender"
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
        name="referred_doctor_id"
        required>

    <option value="">
        Select Doctor
    </option>

    @foreach($doctors as $doctor)

        <option value="{{ $doctor->id }}"
            {{ old('referred_doctor_id') == $doctor->id ? 'selected' : '' }}>

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
            {{ old('referred_department_id') == $department->id ? 'selected' : '' }}>

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
                                        {{ old('referral_type') == 'Internal' ? 'selected' : '' }}>
                                        Internal
                                    </option>

                                    <option value="External"
                                        {{ old('referral_type') == 'External' ? 'selected' : '' }}>
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
                                        name="priority"
                                        required>

                                    <option value="Normal"
                                        {{ old('priority') == 'Normal' ? 'selected' : '' }}>
                                        Normal
                                    </option>

                                    <option value="Urgent"
                                        {{ old('priority') == 'Urgent' ? 'selected' : '' }}>
                                        Urgent
                                    </option>

                                    <option value="Emergency"
                                        {{ old('priority') == 'Emergency' ? 'selected' : '' }}>
                                        Emergency
                                    </option>

                                </select>

                            </div>

                            <!-- Follow-up Date -->
                            <div class="col-md-4">

                                <label class="form-label">
                                    Follow-up Date
                                </label>

                                <input type="date"
                                       class="form-control"
                                       name="followup_date"
                                       value="{{ old('followup_date') }}">

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Clinical Information -->
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Clinical Information
                        </h5>

                    </div>

                    <div class="card-body">

                        <!-- Referral Reason -->
                        <div class="mb-3">

                            <label class="form-label">
                                Referral Reason
                            </label>

                            <textarea rows="4"
                                      class="form-control"
                                      name="referral_reason"
                                      placeholder="Enter referral reason"
                                      required>{{ old('referral_reason') }}</textarea>

                        </div>

                        <!-- Clinical Notes -->
                        <div>

                            <label class="form-label">
                                Clinical Notes
                            </label>

                            <textarea rows="5"
                                      class="form-control"
                                      name="clinical_notes"
                                      placeholder="Enter clinical notes">{{ old('clinical_notes') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Right Section -->
            <div class="col-lg-4">

                <!-- Referral Summary -->
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Referral Summary
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <small class="text-muted">
                                Referral Number
                            </small>

                            <h6 class="mb-0">
                                Auto Generated
                            </h6>

                        </div>

                        <div class="mb-3">

                            <small class="text-muted">
                                Created By
                            </small>

                            <h6 class="mb-0">

                                {{ auth()->user()->name ?? 'Doctor' }}

                            </h6>

                        </div>

                        <div class="mb-3">

                            <small class="text-muted">
                                Referral Date
                            </small>

                            <h6 class="mb-0">

                                {{ date('d-M-Y') }}

                            </h6>

                        </div>

                        <div>

                            <small class="text-muted">
                                Status
                            </small><br>

                            <span class="badge bg-warning text-dark">

                                Pending

                            </span>

                        </div>

                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <button type="submit"
                                class="btn btn-primary w-100 mb-2">

                            <i class="fa fa-save me-1"></i>
                            Save Referral

                        </button>

                        <button type="reset"
                                class="btn btn-light border w-100">

                            Reset Form

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>
<script>

    document.getElementById('patient_id').addEventListener('change', function () {

        let selectedOption = this.options[this.selectedIndex];

        let uhid = selectedOption.getAttribute('data-uhid');

        let gender = selectedOption.getAttribute('data-gender');

        let dob = selectedOption.getAttribute('data-dob');

        // UHID
        document.getElementById('patient_uhid').value = uhid ?? '';

        // Calculate Age
        if (dob) {

            let birthDate = new Date(dob);

            let today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();

            let month = today.getMonth() - birthDate.getMonth();

            if (
                month < 0 ||
                (month === 0 && today.getDate() < birthDate.getDate())
            ) {
                age--;
            }

            document.getElementById('patient_age_gender').value =
                age + ' / ' + gender;

        } else {

            document.getElementById('patient_age_gender').value = '';

        }

    });

</script>

@endsection
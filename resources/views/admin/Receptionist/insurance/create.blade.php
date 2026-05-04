@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Add Insurance</h4>
        <a href="{{ route('admin.insurance.index') }}" class="btn btn-outline-secondary">
            Back
        </a>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <form action="{{ route('admin.insurance.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Patient *</label>

                        <select name="patient_id" class="form-control shadow-sm" required>
                            <option value="">Select Patient</option>

                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}>

                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                    ({{ $patient->patient_code }})

                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Insurance Type *</label>
                        <input type="text" name="insurance_type" value="{{ old('insurance_type') }}" class="form-control shadow-sm" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Provider Name *</label>
                        <input type="text" name="provider_name" value="{{ old('provider_name') }}" class="form-control shadow-sm" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Policy Number *</label>
                        <input type="text" name="policy_number" value="{{ old('policy_number') }}" class="form-control shadow-sm" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Policy Holder Name *</label>
                        <input type="text" name="policy_holder_name" value="{{ old('policy_holder_name') }}" class="form-control shadow-sm" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Valid From *</label>
                        <input type="date" name="valid_from" value="{{ old('valid_from') }}" class="form-control shadow-sm" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Valid To *</label>
                        <input type="date" name="valid_to" value="{{ old('valid_to') }}" class="form-control shadow-sm" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Sum Insured</label>
                        <input type="number" name="sum_insured" value="{{ old('sum_insured') }}" class="form-control shadow-sm">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">TPA Name</label>
                        <input type="text" name="tpa_name" value="{{ old('tpa_name') }}" class="form-control shadow-sm">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control shadow-sm">{{ old('remarks') }}</textarea>
                    </div>

                </div>

                <hr class="my-4">

                <!-- Document Upload Section -->
                <h5 class="text-primary mb-3">Upload Documents</h5>

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Insurance Card *</label>
                        <input type="file" name="insurance_card" class="form-control shadow-sm" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">ID Proof</label>
                        <input type="file" name="id_proof" class="form-control shadow-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Authorization Letter</label>
                        <input type="file" name="authorization_letter" class="form-control shadow-sm">
                    </div>

                </div>

            </div>

            <!-- Footer Buttons -->
            <div class="card-footer text-end bg-white">
                <button class="btn btn-success shadow-sm">
                    Save Insurance
                </button>
            </div>
        </div>

    </form>

</div>

@endsection
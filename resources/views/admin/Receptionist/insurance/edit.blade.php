@extends('layouts.admin')

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<style>
    .card-custom {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .section-title {
        font-weight: 600;
        color: #0d6efd;
        border-left: 4px solid #0d6efd;
        padding-left: 10px;
        margin-bottom: 15px;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 5px rgba(25,135,84,0.3);
    }

    .btn-custom {
        border-radius: 8px;
        padding: 8px 18px;
    }

    .file-btn {
        font-size: 13px;
        border-radius: 6px;
    }
</style>

<div class="container-fluid">

    <h4 class="fw-bold mb-4 text-primary">Edit Insurance</h4>

    <form method="POST" action="{{ route('admin.insurance.update', $insurance->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')


        <div class="card card-custom p-4">

            <!-- 🔷 BASIC DETAILS -->
            <h5 class="section-title">Insurance Details</h5>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="fw-semibold">Patient</label>
                    <select name="patient_id" class="form-control"
                        {{ $insurance->status != 'pending' ? 'disabled' : '' }}>

                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}"
                                {{ $insurance->patient_id == $patient->id ? 'selected' : '' }}>

                                {{ $patient->first_name }} {{ $patient->last_name }}
                                ({{ $patient->patient_code }})

                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-semibold">Insurance Type</label>
                    <input type="text" name="insurance_type"
                        value="{{ $insurance->insurance_type }}"
                        class="form-control"
                        {{ $insurance->status != 'pending' ? 'readonly' : '' }}>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-semibold">Provider Name</label>
                    <input type="text" name="provider_name"
                        value="{{ $insurance->provider_name }}"
                        class="form-control"
                        {{ $insurance->status != 'pending' ? 'readonly' : '' }}>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-semibold">Policy Number</label>
                    <input type="text" name="policy_number"
                        value="{{ $insurance->policy_number }}"
                        class="form-control"
                        {{ $insurance->status != 'pending' ? 'readonly' : '' }}>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-semibold">Policy Holder</label>
                    <input type="text" name="policy_holder_name"
                        value="{{ $insurance->policy_holder_name }}"
                        class="form-control"
                        {{ $insurance->status != 'pending' ? 'readonly' : '' }}>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="fw-semibold">Valid From</label>
                    <input type="date" name="valid_from"
                        value="{{ $insurance->valid_from }}"
                        class="form-control"
                        {{ $insurance->status != 'pending' ? 'readonly' : '' }}>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="fw-semibold">Valid To</label>
                    <input type="date" name="valid_to"
                        value="{{ $insurance->valid_to }}"
                        class="form-control"
                        {{ $insurance->status != 'pending' ? 'readonly' : '' }}>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="fw-semibold">Sum Insured</label>
                    <input type="number" name="sum_insured"
                        value="{{ $insurance->sum_insured }}"
                        class="form-control"
                        {{ $insurance->status != 'pending' ? 'readonly' : '' }}>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="fw-semibold">TPA Name</label>
                    <input type="text" name="tpa_name"
                        value="{{ $insurance->tpa_name }}"
                        class="form-control"
                        {{ $insurance->status != 'pending' ? 'readonly' : '' }}>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="fw-semibold">Status</label>

                    <select name="status" class="form-control"
                        {{ $insurance->status != 'pending' ? '' : '' }}>

                        <option value="pending" {{ $insurance->status == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="claimed" {{ $insurance->status == 'claimed' ? 'selected' : '' }}>
                            Claimed
                        </option>

                        <option value="rejected" {{ $insurance->status == 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>

                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="fw-semibold">Remarks</label>
                    <textarea name="remarks"
                        class="form-control"
                        {{ $insurance->status != 'pending' ? 'readonly' : '' }}>{{ $insurance->remarks }}</textarea>
                </div>

            </div>

            <hr>

            <!-- 🔷 DOCUMENTS -->
            <h5 class="section-title">Documents</h5>

            @php
    $docs = $insurance->documents->keyBy('document_type');
@endphp

<div class="row">

    <!-- Insurance Card -->
    <div class="col-md-4 mb-3">
        <label class="fw-semibold">Insurance Card</label><br>

        @if(isset($docs['Insurance Card']))
            <a href="{{ Storage::url($docs['Insurance Card']->file_path) }}"
               target="_blank"
               class="btn btn-info file-btn mb-2">
                View File
            </a>
        @endif

        @if($insurance->status == 'pending')
            <input type="file" name="insurance_card" class="form-control">
        @endif
    </div>

    <!-- ID Proof -->
    <div class="col-md-4 mb-3">
        <label class="fw-semibold">ID Proof</label><br>

        @if(isset($docs['ID Proof']))
            <a href="{{ asset('storage/'.$docs['ID Proof']->file_path) }}"
               target="_blank"
               class="btn btn-info file-btn mb-2">
                View File
            </a>
        @endif

        @if($insurance->status == 'pending')
            <input type="file" name="id_proof" class="form-control">
        @endif
    </div>

    <!-- Authorization Letter -->
    <div class="col-md-4 mb-3">
        <label class="fw-semibold">Authorization Letter</label><br>

        @if(isset($docs['Authorization Letter']))
            <a href="{{ asset('storage/'.$docs['Authorization Letter']->file_path) }}"
               target="_blank"
               class="btn btn-info file-btn mb-2">
                View File
            </a>
        @endif

        @if($insurance->status == 'pending')
            <input type="file" name="authorization_letter" class="form-control">
        @endif
    </div>

</div>

            <hr>

            <!-- 🔷 ACTION BUTTONS -->
            <div class="d-flex justify-content-between">

                <a href="{{ route('admin.insurance.index') }}"
                   class="btn btn-secondary btn-custom">
                    ⬅ Back
                </a>

                @if($insurance->status == 'pending')
                    <button type="submit"
                            class="btn btn-success btn-custom">
                        ✔ Update Insurance
                    </button>
                @endif

            </div>

        </div>

    </form>

</div>

@endsection
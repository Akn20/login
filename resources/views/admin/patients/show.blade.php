@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">View Patient</h5>
    </div>

    <div class="page-header-right">
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
            <i class="feather-arrow-left me-2"></i> Back to List
        </a>
    </div>
</div>

<div class="main-content">
<div class="row">

    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Patient Details</h5>

                <p><strong>Patient Code:</strong> {{ $patient->patient_code }}</p>
                <p><strong>Name:</strong> {{ $patient->first_name }} {{ $patient->last_name }}</p>
                <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth }}</p>
                <p><strong>Mobile:</strong> {{ $patient->mobile }}</p>
                <p><strong>Email:</strong> {{ $patient->email ?? '-' }}</p>
                <p><strong>Blood Group:</strong> {{ $patient->blood_group ?? '-' }}</p>

            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <p><strong>Emergency Contact:</strong> {{ $patient->emergency_contact ?? '-' }}</p>
                <p><strong>Address:</strong> {{ $patient->address ?? '-' }}</p>

                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $patient->status ? 'success' : 'danger' }}">
                        {{ $patient->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>

                <p>
                    <strong>VIP:</strong>
                    @if($patient->is_vip)
                        <span class="badge bg-danger">VIP</span>
                    @else
                        Normal
                    @endif
                </p>

            </div>
        </div>
    </div>

</div>
</div>

@endsection
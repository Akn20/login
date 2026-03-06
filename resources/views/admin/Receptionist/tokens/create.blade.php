@extends('layouts.admin')

@section('content')
<div class="nxl-content">

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Generate Token</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Receptionist</li>
                <li class="breadcrumb-item">Token & Queue</li>
                <li class="breadcrumb-item">Generate Token</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.tokens.index') }}" class="btn btn-neutral">
                Back
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">

                        <form action="{{ route('admin.tokens.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <!-- Patient -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Patient</label>
                                    <select name="patient_id" class="form-control" required>
                                        <option value="">Select Patient</option>

                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">
                                                {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->uhid }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Department -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department</label>
                                    <select name="department_id" class="form-control" required>
                                        <option value="">Select Department</option>

                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">
                                                {{ $department->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Doctor -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Doctor</label>

                                    <select name="doctor_id" class="form-control">
                                        <option value="">Select Doctor (Optional)</option>

                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">
                                                {{ $doctor->doctor_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Generate Token
                                </button>

                                <a href="{{ route('admin.tokens.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
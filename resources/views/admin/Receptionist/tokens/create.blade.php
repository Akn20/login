@extends('layouts.admin')

@section('content')
<div class="nxl-content">

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
                <li class="breadcrumb-item">Token & Queue Management</li>
                <li class="breadcrumb-item">Generate Token</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.tokens.index') }}" class="btn btn-neutral">Back</a>
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

                                <!-- Appointment Selection -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Appointment</label>
                                    <select name="appointment_id" class="form-control">
                                        <option value="">Select Appointment</option>

                                        @if(isset($appointments))
                                            @foreach($appointments as $appointment)
                                                <option value="{{ $appointment->id }}">
                                                    {{ $appointment->patient->patient_code ?? '' }} -
                                                    {{ $appointment->patient->first_name ?? '' }}
                                                    {{ $appointment->patient->last_name ?? '' }}
                                                    |
                                                    {{ $appointment->appointment_date ?? '' }}
                                                    {{ $appointment->appointment_time ?? '' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-muted">
                                        Token generation will be linked to appointment once appointment module is finalized.
                                    </small>
                                </div>

                                <!-- Placeholder Patient -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Patient</label>
                                    <input type="text" class="form-control" value="Auto-filled from appointment" readonly>
                                </div>

                                <!-- Placeholder Doctor / Staff -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Doctor / Staff</label>
                                    <input type="text" class="form-control" value="Auto-filled from appointment" readonly>
                                </div>

                                <!-- Placeholder Department -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department</label>
                                    <input type="text" class="form-control" value="Auto-filled from appointment" readonly>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <input type="text" class="form-control" value="WAITING" readonly>
                                </div>

                            </div>

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
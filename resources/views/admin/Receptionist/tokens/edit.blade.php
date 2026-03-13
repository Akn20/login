@extends('layouts.admin')

@section('content')
<div class="nxl-content">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Reassign Token</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Receptionist</li>
                <li class="breadcrumb-item">Token & Queue Management</li>
                <li class="breadcrumb-item">Reassign</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.tokens.index') }}" class="btn btn-neutral">Back</a>
        </div>
    </div>

    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">

                <div class="card stretch stretch-full">
                    <div class="card-body">

                        <form action="{{ route('admin.tokens.update', $token->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Token Number</label>
                                    <input type="text" class="form-control" value="{{ $token->token_number }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Patient</label>
                                    <input type="text" class="form-control"
                                           value="{{ $token->appointment->patient->first_name ?? '' }} {{ $token->appointment->patient->last_name ?? '' }}"
                                           readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Current Doctor</label>
                                    <input type="text" class="form-control"
                                           value="{{ $token->appointment->doctor->name ?? '-' }}"
                                           readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department</label>
                                    <input type="text" class="form-control"
                                           value="{{ $token->appointment->department->department_name ?? '-' }}"
                                           readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">New Doctor</label>
                                    <select name="doctor_id" class="form-control" required>
                                        <option value="">Select Doctor</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ $token->appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.tokens.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
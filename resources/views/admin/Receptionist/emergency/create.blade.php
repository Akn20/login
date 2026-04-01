@extends('layouts.admin')

@section('page-title', 'Emergency Registration | ' . config('app.name'))

@section('content')
<div class="nxl-content">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">

            <div class="page-header-title">
                <h5 class="m-b-10">Emergency Registration</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Receptionist</li>
                <li class="breadcrumb-item">Emergency</li>
                <li class="breadcrumb-item">Register</li>
            </ul>

        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">

                <div class="card stretch stretch-full">
                    <div class="card-body">

                        {{-- Success Message --}}
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.emergency.store') }}" method="POST">
                            @csrf

                            {{-- Select Existing Patient --}}
                            <div class="mb-3">
                                <label class="form-label">Select Existing Patient </label>
                                <select name="patient_id" id="patientSelect" class="form-control">
                                    <option value="">Select Registered Patient </option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            data-name="{{ $patient->first_name }} {{ $patient->last_name }}"
                                            data-mobile="{{ $patient->mobile }}"
                                            data-gender="{{ $patient->gender ?? '' }}"
                                            data-age="{{ $patient->age ?? '' }}">
                                            
                                            {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->mobile }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Patient Name --}}
                            <div class="mb-3">
                                <label class="form-label">Patient Name</label>
                                <input type="text" name="patient_name" id="patientName" class="form-control"
                                    placeholder="Enter name or Unknown">
                            </div>

                            {{-- Gender --}}
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" id="patientGender" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            {{-- Age --}}
                            <div class="mb-3">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" id="patientAge" class="form-control"
                                    placeholder="Approximate Age">
                            </div>

                            {{-- Mobile --}}
                            <div class="mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" name="mobile" id="patientMobile" class="form-control">
                            </div>

                            {{-- Emergency Type --}}
                            <div class="mb-3">
                                <label class="form-label">Emergency Type</label>
                                <select name="emergency_type" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Accident">Accident</option>
                                    <option value="Cardiac">Cardiac</option>
                                    <option value="Trauma">Trauma</option>
                                    <option value="Suicide">Suicide</option>
                                    <option value="Other">Other</option>
                                </select>

                                @error('emergency_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    REGISTER EMERGENCY
                                </button>

                                <a href="{{ route('admin.emergency.create') }}" class="btn btn-light">
                                    CANCEL
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('patientSelect').addEventListener('change', function () {

        let selected = this.options[this.selectedIndex];

        let name = selected.getAttribute('data-name');
        let mobile = selected.getAttribute('data-mobile');
        let gender = selected.getAttribute('data-gender');
        let age = selected.getAttribute('data-age');

        // Autofill fields
        document.getElementById('patientName').value = name || '';
        document.getElementById('patientMobile').value = mobile || '';
        document.getElementById('patientGender').value = gender || '';
        document.getElementById('patientAge').value = age || '';

    });

});
</script>
@endsection

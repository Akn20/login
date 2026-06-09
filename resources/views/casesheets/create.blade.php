@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            {{-- Heading --}}
            <div class="mb-4">

                <h2 class="fw-bold mb-1">
                    Create Case Sheet
                </h2>

                <p class="text-muted mb-0">
                    Fill all required details
                </p>

            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- Form Start --}}
            <form action="{{ route('admin.casesheets.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    {{-- Patient Dropdown --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Select Patient
                        </label>

                        <select name="patient_id"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Patient --
                            </option>

                            @foreach($patients as $patient)

                                <option value="{{ $patient->id }}">

                                    {{ $patient->patient_code }}
                                    -
                                    {{ $patient->first_name }}
                                    {{ $patient->last_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Doctor Dropdown --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Select Doctor
                        </label>

                        <select name="doctor_id"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Doctor --
                            </option>

                            @foreach($doctors as $doctor)

                                <option value="{{ $doctor->id }}">

                                    Dr. {{ $doctor->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Visit Type --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Visit Type
                        </label>

                        <select name="visit_type"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Visit Type --
                            </option>

                            <option value="OPD">
                                OPD
                            </option>

                            <option value="IPD">
                                IPD
                            </option>

                        </select>

                    </div>

                    {{-- Symptoms --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label fw-semibold">
                            Symptoms
                        </label>

                        <textarea name="symptoms"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Enter symptoms here...">{{ old('symptoms') }}</textarea>

                    </div>

                    {{-- Diagnosis --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label fw-semibold">
                            Diagnosis
                        </label>

                        <textarea name="diagnosis"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Enter diagnosis here...">{{ old('diagnosis') }}</textarea>

                    </div>

                    {{-- Clinical Notes --}}
                    <div class="col-md-12 mb-4">

                        <label class="form-label fw-semibold">
                            Clinical Notes
                        </label>

                        <textarea name="clinical_notes"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Enter clinical notes here...">{{ old('clinical_notes') }}</textarea>

                    </div>

                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary px-4">

                        <i class="feather-save"></i>
                        Save Case Sheet

                    </button>

                    <a href="{{ route('admin.casesheets.index') }}"
                       class="btn btn-light border">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
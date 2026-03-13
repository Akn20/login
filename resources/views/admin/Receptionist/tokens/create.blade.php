@extends('layouts.admin')

@section('content')

    <div class="nxl-content">
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body">

                            {{-- Appointment Select Form --}}
                            <form method="GET" action="{{ route('admin.tokens.create') }}">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Appointment</label>

                                        <select name="appointment_id"
                                                class="form-control"
                                                onchange="this.form.submit()">

                                            <option value="">Select Appointment</option>

                                            @foreach($appointments as $appointment)

                                                <option value="{{ $appointment->id }}"
                                                    {{ request('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                                    {{ $appointment->patient->patient_code }} -
                                                    {{ $appointment->patient->first_name }}
                                                    {{ $appointment->patient->last_name }}
                                                    |
                                                    {{ $appointment->appointment_date }}
                                                    {{ $appointment->appointment_time }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>

                            {{-- Token Create Form --}}
                            <form action="{{ route('admin.tokens.store') }}" method="POST">

                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $selectedAppointment->id ?? '' }}">

                                <div class="row">

                                    {{-- Patient --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Patient</label>

                                        <input type="text"
                                            class="form-control"
                                            value="{{ $selectedAppointment->patient->first_name ?? '' }} {{ $selectedAppointment->patient->last_name ?? '' }}"
                                            readonly>
                                    </div>

                                    {{-- Doctor --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Doctor</label>

                                        <input type="text"
                                        class="form-control"
                                        value="{{ $selectedDoctor->name ?? '' }}"
                                        readonly>
                                    </div>

                                    {{-- Department --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Department</label>

                                        <input type="text"
                                        class="form-control"
                                        value="{{ $selectedAppointment->department->department_name ?? '' }}"
                                        readonly>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>

                                        <input type="text"
                                        class="form-control"
                                        value="WAITING"
                                        readonly>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">Generate Token</button>
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
@extends('layouts.admin')

@section('title', 'Create Patient Alert')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Create Patient Alert</h4>

        <a href="{{ route('patient-alerts.index') }}"
            class="btn btn-secondary">
            Back
        </a>
    </div>

    <!-- Form Card -->
    <div class="card">

        <div class="card-body">
            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif
            <form action="{{ route('patient-alerts.store') }}" method="POST">
                @csrf

                <div class="row">

                    <!-- Patient -->
                    <div class="col-md-6 mb-3">
                        <label>Patient</label>
                        <select name="patient_id" class="form-control" required>

                            <option value="">Select Patient</option>

                            @foreach($patients as $patient)

                                <option value="{{ $patient->id }}">
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <!-- Alert Type -->
                    <div class="col-md-6 mb-3">
                        <label>Alert Type</label>

                        <select name="alert_type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="appointment">Appointment</option>
                            <option value="lab">Lab</option>
                            <option value="payment">Payment</option>
                            <option value="followup">Follow-up</option>
                            <option value="general">General</option>
                        </select>
                    </div>

                    <!-- Title -->
                    <div class="col-md-12 mb-3">
                        <label>Title</label>

                        <input type="text"
                            name="title"
                            class="form-control"
                            placeholder="Enter Alert Title">
                    </div>

                    <!-- Message -->
                    <div class="col-md-12 mb-3">
                        <label>Message</label>

                        <textarea name="message"
                            rows="5"
                            class="form-control"
                            placeholder="Enter Alert Message"></textarea>
                    </div>

                    <!-- Alert Date -->
                    <div class="col-md-6 mb-3">
                        <label>Alert Date</label>

                        <input type="datetime-local"
                            name="alert_date"
                            class="form-control">
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-4 d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Save Alert
                    </button>

                    <a href="{{ route('patient-alerts.index') }}"
                        class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

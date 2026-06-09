
@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                Schedule Follow-up
            </h4>

            <a href="{{ route('doctor.followups.index') }}"
               class="btn btn-sm btn-outline-primary">
                <i class="feather feather-arrow-left"></i> Back
            </a>

        </div>

        <div class="card-body">

            <form action="{{ route('doctor.followups.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                <div class="col-md-6 mb-3">

    <label class="form-label">
        Consultation
    </label>

    <select name="consultation_id"
            class="form-control"
            required>

        <option value="">
            Select Consultation
        </option>

        @foreach($consultations as $consultation)

            <option value="{{ $consultation->id }}">

                {{ optional($consultation->patient)->first_name }}
                {{ optional($consultation->patient)->last_name }}
                -
                {{ $consultation->consultation_date }}

            </option>

        @endforeach

    </select>

</div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Patient
                        </label>

                        <select name="patient_id"
                                class="form-control"
                                required>

                            <option value="">
                                Select Patient
                            </option>

                            @foreach($patients as $patient)

                                <option value="{{ $patient->id }}">

                                    {{ $patient->first_name }}
                                    {{ $patient->last_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Doctor
                        </label>

                        <select name="doctor_id"
                                class="form-control"
                                required>

                            <option value="">
                                Select Doctor
                            </option>

                            @foreach($doctors as $doctor)

                                <option value="{{ $doctor->id }}">

                                    {{ $doctor->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Follow-up Date
                        </label>

                        <input type="date"
                               name="follow_up_date"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                            <option value="Missed">
                                Missed
                            </option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Remarks
                        </label>

                        <textarea name="remarks"
                                  rows="4"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <button class="btn btn-primary">

                    Save Follow-up

                </button>

               

            </form>

        </div>

    </div>

</div>

@endsection

@extends('layouts.admin')

@section('content')


    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">

            <div class="card-header">
                <h4>Patient Consultation</h4>
            </div>

            <div class="card-body">

                <!-- Patient Information -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Patient Information</strong>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-3">
                                <label>Name</label>
                                <input type="text" class="form-control" value={{ $patient->first_name }} readonly>
                            </div>

                            <div class="col-md-2">
                                <label>Age</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}" readonly>
                            </div>

                            <div class="col-md-2">
                                <label>Gender</label>
                                <input type="text" class="form-control" value={{ $patient->gender }} readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Blood Group</label>
                                <input type="text" class="form-control" value={{ $patient->blood_group }} readonly>
                            </div>

                        </div>

                    </div>
                </div>


                <form method="POST" action="{{ route('doctor.save-consultation') }}">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">


                    <!-- Symptoms -->
                    <div class="mb-3">

                        <label><strong>Symptoms</strong></label>

                        <textarea name="symptoms" class="form-control" rows="3" placeholder="Enter symptoms"
                            required></textarea>

                    </div>


                    <!-- Diagnosis -->
                    <div class="mb-3">

                        <label><strong>Diagnosis</strong></label>

                        <textarea name="diagnosis" class="form-control" rows="3" placeholder="Enter diagnosis"
                            required></textarea>

                    </div>


                    <!-- Prescription -->
                    <div class="card mb-3">

                        <div class="card-header">
                            <strong>Prescription</strong>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">

                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Dosage</th>
                                        <th>Frequency</th>
                                        <th>Duration</th>
                                        <th>Instructions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td>
                                            <select name="medicine" class="form-control" required>
                                                <option value="">Select Medicine</option>

                                                @foreach($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}">
                                                        {{ $medicine->medicine_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="dosage" required></td>
                                        <td><input type="text" class="form-control" name="frequency" required></td>
                                        <td><input type="text" class="form-control" name="duration" required></td>
                                        <td><input type="text" class="form-control" name="instructions" required></td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>
                    </div>


                    <!-- Recommended Tests -->
                    <div class="mb-3">

                        <label><strong>Recommended Tests</strong></label>

                        <input type="text" name="tests" class="form-control" placeholder="Blood Test, X-Ray, MRI etc">

                    </div>
                    <div class="mb-3">
                        <label><strong>Referral Doctor</strong></label>

                        <select name="referral_doctor_id" class="form-control">
                            <option value="">Select Doctor</option>

                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">
                                    {{ $doctor->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    <!-- Buttons -->
                    <div class="text-center mt-4 d-flex gap-2">

                        <button type="submit" class="btn btn-success">
                            Save Consultation
                        </button>





                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
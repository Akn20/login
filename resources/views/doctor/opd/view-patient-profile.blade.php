@extends('layouts.admin')

@section('content')

<div class="container">

   <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Patient Profile</h3>

        <a href="{{ route('doctor.consultation',$patient->id) }}" class="btn btn-primary btn-lg">
            Continue Consultation
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Patient CODE</label>
                    <input type="text" class="form-control" value="{{ $patient->patient_code }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Patient Name</label>
                    <input type="text" class="form-control" value="{{ $patient->first_name }} {{ $patient->last_name }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Age</label>
                    <input type="text" class="form-control"
                        value="{{ $patient->date_of_birth->age }} years"
                        readonly>                
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender</label>
                    <input type="text" class="form-control" value="{{ $patient->gender }}" readonly>                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Blood Group</label>
                    <input type="text" class="form-control" value="{{ $patient->blood_group }}" readonly>                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" value="{{ $patient->mobile }}" readonly>                </div>

            </div>

        </div>
    </div>




        <!-- Previous Visits -->
    <div class="card">
        <div class="card-header">
            <h5>Previous Consultations</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Symptoms</th>
                            <th>Diagnosis</th>
                            <th>Prescription</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>12 Feb 2026</td>
                            <td>Dr. Sharma</td>
                            <td>Fever, Headache</td>
                            <td>Viral Fever</td>
                            <td>Paracetamol</td>
                        </tr>

                        <tr>
                            <td>05 Jan 2026</td>
                            <td>Dr. Mehta</td>
                            <td>Stomach Pain</td>
                            <td>Gastritis</td>
                            <td>Antacid</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </div>


</div>

@endsection
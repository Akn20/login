@extends('layouts.admin')

@section('content')

<div class="container">

   <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Patient Profile</h3>

        <a href="{{ route('doctor.consultation') }}" class="btn btn-primary btn-lg">
            Continue Consultation
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Patient ID</label>
                    <input type="text" class="form-control" value="P001" >
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Patient Name</label>
                    <input type="text" class="form-control" value="Ramesh Kumar" >
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Age</label>
                    <input type="text" class="form-control" value="35" >
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender</label>
                    <input type="text" class="form-control" value="Male" >
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Blood Group</label>
                    <input type="text" class="form-control" value="O+" >
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" value="9876543210" >
                </div>

            </div>

        </div>
    </div>


    <!-- Medical Information -->

    <div class="card mt-4">
        <div class="card-header">
            <h5>Medical Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Allergies</label>
                    <input type="text" class="form-control" value="Penicillin" >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Chronic Conditions</label>
                    <input type="text" class="form-control" value="Diabetes" >
                </div>

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
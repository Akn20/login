@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Patient Profile</h3>

    <div class="card">
        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Patient ID</label>
                    <input type="text" class="form-control" value="P001" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Patient Name</label>
                    <input type="text" class="form-control" value="Ramesh Kumar" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Age</label>
                    <input type="text" class="form-control" value="35" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender</label>
                    <input type="text" class="form-control" value="Male" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Blood Group</label>
                    <input type="text" class="form-control" value="O+" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" value="9876543210" readonly>
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
                    <input type="text" class="form-control" value="Penicillin" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Chronic Conditions</label>
                    <input type="text" class="form-control" value="Diabetes" readonly>
                </div>

            </div>

        </div>
    </div>


    <!-- Continue Consultation Button -->

    <div class="mt-4 text-end">

        <a href="#" class="btn btn-primary">
            Continue Consultation
        </a>

    </div>

</div>

@endsection
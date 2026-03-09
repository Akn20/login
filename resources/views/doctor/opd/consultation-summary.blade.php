@extends('layouts.admin')

@section('content')

<style>
@media print {
    .nxl-navigation { display: none !important; }
    .nxl-header { display: none !important; }
    .nxl-footer { display: none !important; }       /* Footer */
    footer { display: none !important; }            /* Extra footer */
    .main-content { margin-left: 0 !important; }
}
</style>

<div class="container">

    <!-- Heading + Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Consultation Summary</h3>

        <div class="d-flex gap-2 align-items-center">
            <button onclick="window.print()" class="btn btn-success">
                <i class="feather-printer"></i> Print
            </button>

            
        </div>
    </div>

    <!-- Summary Card -->
    <div class="card">
        <div class="card-body">

            <!-- Patient Details -->
            <h5 class="mb-3">Patient Information</h5>

            <div class="row mb-4">

                <div class="col-md-4">
                    <strong>Name:</strong> Ramesh Kumar
                </div>

                <div class="col-md-4">
                    <strong>Age:</strong> 35
                </div>

                <div class="col-md-4">
                    <strong>Gender:</strong> Male
                </div>

                <div class="col-md-4">
                    <strong>Blood Group:</strong> O+
                </div>

                <div class="col-md-4">
                    <strong>Doctor:</strong> Dr. Sharma
                </div>

                <div class="col-md-4">
                    <strong>Date:</strong> 06 March 2026
                </div>

            </div>

            <!-- Symptoms -->
            <h5>Symptoms</h5>
            <p>Fever, Headache, Body pain</p>

            <!-- Diagnosis -->
            <h5>Diagnosis</h5>
            <p>Viral Fever</p>

            <!-- Prescription -->
            <h5 class="mt-4">Prescription</h5>

            <table class="table table-bordered mt-2">

                <thead class="table-light">
                    <tr>
                        <th>Medicine</th>
                        <th>Dose</th>
                        <th>Frequency</th>
                        <th>Days</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>Paracetamol</td>
                        <td>500 mg</td>
                        <td>3 times a day</td>
                        <td>5</td>
                    </tr>

                    <tr>
                        <td>Cetirizine</td>
                        <td>10 mg</td>
                        <td>Once daily</td>
                        <td>3</td>
                    </tr>

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
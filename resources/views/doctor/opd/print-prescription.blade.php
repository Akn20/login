@extends('layouts.admin')

@section('content')

<style>
@media print {

    /* Hide sidebar and navbar */
    .nxl-navigation,
    .nxl-header,
    .header,
    .sidebar,
    .navbar {
        display: none !important;
    }

    /* Hide print button */
    .btn-print {
        display: none !important;
    }

    /* Make content full width */
    .container-fluid {
        margin: 0;
        padding: 0;
        width: 100%;
    }

}
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-end mb-3">
        <button onclick="window.print()" class="btn btn-success btn-print">
            <i class="feather-printer"></i> Print
        </button>
    </div>

    <div class="card">
        <div class="card-body">

            <h3 class="text-center">Your Hospital Name</h3>
            <p class="text-center">Hospital Address | Phone</p>

            <hr>

            <!-- Patient Info -->
            <div class="row mb-3">

               <div class="d-flex justify-content-between mb-2">
    <div>
        <strong>Patient Name:</strong> {{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}
    </div>
    <div>
        <strong>Age:</strong> {{ \Carbon\Carbon::parse($consultation->patient->date_of_birth)->age }}
    </div>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <strong>Gender:</strong> {{ $consultation->patient->gender }}
                    </div>
                    <div>
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d-m-Y') }}
                    </div>
                </div>

                <div class="mb-2">
                    <strong>Doctor:</strong> {{ $consultation->doctor->name }}
                </div>

            </div>

            <hr>
            <!-- Prescription -->
            <div class="mb-3">
                <h5>Prescription</h5>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Days</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($consultation->medicines as $medicine)
                        <tr>
                            <td>{{ $medicine->medicine_name }}</td>
                            <td>{{ $medicine->pivot->dosage }}</td>
                            <td>{{ $medicine->pivot->frequency }}</td>
                            <td>{{ $medicine->pivot->duration }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <br><br>

            <!-- Doctor Signature -->
            <div class="text-end">
                Doctor: {{ $consultation->doctor->name ?? 'Doctor' }}
                <br><br>
                _____________________
            </div>

        </div>
    </div>

</div>

@endsection
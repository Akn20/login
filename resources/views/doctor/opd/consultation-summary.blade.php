@extends('layouts.admin')

@section('content')

    <style>
        @media print {
            .nxl-navigation {
                display: none !important;
            }

            .nxl-header {
                display: none !important;
            }

            .nxl-footer {
                display: none !important;
            }

            footer {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>

    <div class="container">

        <!-- Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Consultation Summary</h3>

            
        </div>


        <div class="card">
            <div class="card-body">

                <!-- Patient Information -->
                <h5 class="mb-3">Patient Information</h5>

                <div class="row mb-4">

                    <div class="col-md-4">
                        <strong>Name:</strong>
                        {{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}
                    </div>

                    <div class="col-md-4">
                        <strong>Age:</strong>
                        {{ \Carbon\Carbon::parse($consultation->patient->date_of_birth)->age }}
                    </div>

                    <div class="col-md-4">
                        <strong>Gender:</strong>
                        {{ $consultation->patient->gender }}
                    </div>

                    <div class="col-md-4">
                        <strong>Blood Group:</strong>
                        {{ $consultation->patient->blood_group }}
                    </div>

                    <div class="col-md-4">
                        <strong>Doctor:</strong>
                        {{ $consultation->doctor->name ?? 'Doctor' }}
                    </div>

                    <div class="col-md-4">
                        <strong>Referred To:</strong>
                        {{ $consultation->referralDoctor->name ?? 'None' }}
                    </div>

                    <div class="col-md-4">
                        <strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d F Y') }}
                    </div>

                </div>


                <!-- Symptoms -->
                <h5>Symptoms</h5>
                <p>{{ $consultation->symptoms }}</p>


                <!-- Diagnosis -->
                <h5>Diagnosis</h5>
                <p>{{ $consultation->diagnosis }}</p>


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

                        @foreach($consultation->medicines as $med)
                            <tr>
                                <td>{{ $med->medicine_name }}</td>
                                <td>{{ $med->pivot->dosage }}</td>
                                <td>{{ $med->pivot->frequency }}</td>
                                <td>{{ $med->pivot->duration }}</td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
                <!-- Lab Requests -->
                <div class="mt-4">
                    <h5><strong>Recommended Tests</strong></h5>

                    @if($consultation->labRequests->count() > 0)
                        <ul>
                            @foreach($consultation->labRequests as $lab)
                                <li>
                                    {{ $lab->test_name }} 
                                    
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No tests recommended</p>
                    @endif
                </div>


            </div>
        </div>

    </div>

@endsection
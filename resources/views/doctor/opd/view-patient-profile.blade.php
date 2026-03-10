@extends('layouts.admin')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Patient Profile</h3>

            <a href="{{ route('doctor.consultation', $patient->id) }}" class="btn btn-primary btn-lg">
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
                        <input type="text" class="form-control" value="{{ $patient->first_name }} {{ $patient->last_name }}"
                            readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Age</label>
                        <input type="text" class="form-control" value="{{ $patient->date_of_birth->age }} years" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Gender</label>
                        <input type="text" class="form-control" value="{{ $patient->gender }}" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Blood Group</label>
                        <input type="text" class="form-control" value="{{ $patient->blood_group }}" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" value="{{ $patient->mobile }}" readonly>
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

                            @forelse($consultations as $consultation)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d M Y') }}</td>

                                    <td>{{ $consultation->doctor->name ?? 'Doctor' }}</td>

                                    <td>{{ $consultation->symptoms }}</td>

                                    <td>{{ $consultation->diagnosis }}</td>

                                    <td>
                                        @foreach($consultation->medicines as $med)
                                            {{ $med->medicine_name }} <br>
                                        @endforeach
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No consultations found</td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>
        </div>


    </div>

@endsection
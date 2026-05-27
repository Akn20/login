@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">Patient Medical History</h3>

    {{-- Patient Information --}}
    <div class="card mb-3">
        <div class="card-header">
            Patient Information
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <strong>UHID:</strong><br>
                    {{ $patient->patient_code }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Patient Name:</strong><br>
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Gender:</strong><br>
                    {{ $patient->gender }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Date of Birth:</strong><br>
                    {{ $patient->date_of_birth }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Mobile:</strong><br>
                    {{ $patient->mobile }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Blood Group:</strong><br>
                    {{ $patient->blood_group }}
                </div>

            </div>

        </div>
    </div>
{{-- OPD Visit History --}}
<div class="card-body">

    {{ dd($opdVisits) }}

    <div class="table-responsive">
        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>Visit Date</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    <th>Consultation Fee</th>
                </tr>
            </thead>

            <tbody>

            @if($opdVisits->count())

                @foreach($opdVisits as $visit)

                    <tr>
                        <td>{{ $visit->appointment_date }}</td>
                        <td>{{ $visit->department->department_name ?? '-' }}</td>
                        <td>{{ $visit->doctor->name ?? '-' }}</td>
                        <td>{{ $visit->appointment_status }}</td>
                        <td>₹ {{ number_format($visit->consultation_fee, 2) }}</td>
                    </tr>

                @endforeach

            @else

                <tr>
                    <td colspan="5" class="text-center">
                        No visit history found
                    </td>
                </tr>

            @endif

            </tbody>

        </table>
    </div>

</div>
    {{-- IPD Admission History --}}
    <div class="card mb-3">
        <div class="card-header">
            IPD Admission History
        </div>

        <div class="card-body">
            IPD admission history will appear here
        </div>
    </div>

    {{-- Lab Investigation History --}}
    <div class="card mb-3">
        <div class="card-header">
            Lab Investigation History
        </div>

        <div class="card-body">
            Lab investigation history will appear here
        </div>
    </div>

    {{-- Medication History --}}
    <div class="card mb-3">
        <div class="card-header">
            Medication History
        </div>

        <div class="card-body">
            Medication history will appear here
        </div>
    </div>

    {{-- Allergies & Medical Flags --}}
    <div class="card mb-3">
        <div class="card-header">
            Allergies & Medical Flags
        </div>

        <div class="card-body">
            Allergy and medical flag information will appear here
        </div>
    </div>

    {{-- Clinical Documents --}}
    <div class="card mb-3">
        <div class="card-header">
            Clinical Documents
        </div>

        <div class="card-body">
            Clinical documents will appear here
        </div>
    </div>

</div>

@endsection
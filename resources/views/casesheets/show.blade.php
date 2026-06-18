@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2>Case Sheet Details</h2>

    <table class="table table-bordered">

        <tr>
            <th>Patient ID</th>
            <td>{{ $caseSheet->patient_id }}</td>
        </tr>

        <tr>
            <th>Doctor ID</th>
            <td>{{ $caseSheet->doctor_id }}</td>
        </tr>

        <tr>
            <th>Visit Type</th>
            <td>{{ $caseSheet->visit_type }}</td>
        </tr>

        <tr>
            <th>Symptoms</th>
            <td>{{ $caseSheet->symptoms }}</td>
        </tr>

        <tr>
            <th>Diagnosis</th>
            <td>{{ $caseSheet->diagnosis }}</td>
        </tr>

        <tr>
            <th>Clinical Notes</th>
            <td>{{ $caseSheet->clinical_notes }}</td>
        </tr>

    </table>

</div>

@endsection
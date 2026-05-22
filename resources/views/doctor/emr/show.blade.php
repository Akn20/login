@extends('layouts.admin')

@section('page-title', 'Patient EMR | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">

            <div class="page-header-title">
                <h5 class="m-b-10">Electronic Medical Record</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Doctor</li>
                <li class="breadcrumb-item">EMR</li>
                <li class="breadcrumb-item">Patient Record</li>
            </ul>
        </div>
    </div>

    <div class="main-content">

        <div class="card mb-4">

            <div class="card-header">
                <strong>Patient Information</strong>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-3">
                        <strong>Patient Code</strong><br>{{ $patient->patient_code }}
                    </div>

                    <div class="col-md-3">
                        <strong>Name</strong><br>{{ $patient->first_name }}{{ $patient->last_name }}
                    </div>

                    <div class="col-md-3">
                        <strong>Gender</strong><br>
                        {{ $patient->gender }}
                    </div>

                    <div class="col-md-3">
                        <strong>Mobile</strong><br>
                        {{ $patient->mobile }}
                    </div>

                </div>

            </div>

        </div>


        {{-- OPD History --}}

        <div class="card mb-4">

            <div class="card-header">
                <strong>Consultation History</strong>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>
                        <th>Date</th>
                        <th>Symptoms</th>
                        <th>Diagnosis</th>
                        <th>Tests</th>
                    </tr>

                    </thead>

                    <tbody>

                    @forelse($consultations as $consultation)

                    <tr>

                        <td>
                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $consultation->symptoms }}
                        </td>

                        <td>
                            {{ $consultation->diagnosis }}
                        </td>

                        <td>
                            {{ $consultation->tests }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            No Consultation History
                        </td>
                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Lab History --}}

        <div class="card mb-4">

            <div class="card-header">
                <strong>Laboratory Reports</strong>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>
                        <th>Test</th>
                        <th>Priority</th>
                        <th>Status</th>
                    </tr>

                    </thead>

                    <tbody>

                    @forelse($labs as $lab)

                    <tr>

                        <td>{{ $lab->test_name }}</td>

                        <td>{{ $lab->priority }}</td>

                        <td>{{ $lab->status }}</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3" class="text-center">

                            No Lab Records

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Radiology History --}}

        <div class="card mb-4">

            <div class="card-header">
                <strong>Radiology History</strong>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>Scan</th>
                        <th>Body Part</th>
                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($scans as $scan)

                    <tr>

                        <td>
                            {{ $scan->scanType->name ?? '-' }}
                        </td>

                        <td>
                            {{ $scan->body_part }}
                        </td>

                        <td>
                            {{ $scan->status }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3"
                            class="text-center">

                            No Scan Records

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Surgery History --}}

        <div class="card mb-4">

            <div class="card-header">
                <strong>Surgery History</strong>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>Surgery</th>
                        <th>Date</th>
                        <th>OT Room</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($surgeries as $surgery)

                    <tr>

                        <td>
                            {{ $surgery->surgery_type }}
                        </td>

                        <td>
                            {{ $surgery->surgery_date }}
                        </td>

                        <td>
                            {{ $surgery->ot_room }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3"
                            class="text-center">

                            No Surgery Records

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- IPD History --}}

        <div class="card">

            <div class="card-header">
                <strong>IPD History</strong>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>Admission Date</th>
                        <th>Ward</th>
                        <th>Bed</th>
                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($ipdHistory as $ipd)

                    <tr>

                        <td>
                            {{ $ipd->admission_date }}
                        </td>

                        <td>
                            {{ $ipd->ward->ward_name ?? '-' }}
                        </td>

                        <td>
                            {{ $ipd->bed->bed_number ?? '-' }}
                        </td>

                        <td>
                            {{ $ipd->status }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4"
                            class="text-center">

                            No IPD History

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
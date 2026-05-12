@extends('layouts.admin')

@section('page-title', 'View Vitals | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">

            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">
                    <h5 class="m-b-10">Vitals Details</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">Patient Monitoring</li>
                    <li class="breadcrumb-item">View</li>
                </ul>

            </div>

            <div class="page-header-right ms-auto d-flex gap-2">

                <a href="{{ route('admin.patientMonitoring.edit', $vital->id) }}" class="btn btn-neutral">
                    Edit
                </a>

                <a href="{{ route('admin.patientMonitoring.index') }}" class="btn btn-neutral">
                    Back
                </a>

            </div>

        </div>


        <div class="main-content">

            <div class="row justify-content-center">

                <div class="col-lg-6">

                    <div class="card stretch stretch-full">

                        <div class="card-header">
                            <h5 class="card-title">Vitals Information</h5>
                        </div>

                        <div class="card-body">

                            <table class="table table-borderless">

                                <tr>
                                    <th>Temperature</th>
                                    <td>{{ $vital->temperature }}</td>
                                </tr>

                                <tr>
                                    <th>Blood Pressure</th>
                                    <td>
                                        {{ $vital->blood_pressure_systolic }}/{{ $vital->blood_pressure_diastolic }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Pulse Rate</th>
                                    <td>{{ $vital->pulse_rate }}</td>
                                </tr>

                                <tr>
                                    <th>Respiratory Rate</th>
                                    <td>{{ $vital->respiratory_rate }}</td>
                                </tr>

                                <tr>
                                    <th>SpO2</th>
                                    <td>{{ $vital->spo2 }}</td>
                                </tr>

                                <tr>
                                    <th>Blood Sugar</th>
                                    <td>{{ $vital->blood_sugar }}</td>
                                </tr>

                                <tr>
                                    <th>Weight</th>
                                    <td>{{ $vital->weight }}</td>
                                </tr>

                                <tr>
                                    <th>Recorded At</th>
                                    <td>{{ \Carbon\Carbon::parse($vital->recorded_at)->format('d-m-Y H:i') }}</td>
                                </tr>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
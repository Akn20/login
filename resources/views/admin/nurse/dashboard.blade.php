@extends('layouts.admin')

@section('page-title', ' Nurse Dashboard | ' . config('app.name'))


@section('content')
<div class="nxl-content">
    <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">   
                    <h5 class="m-b-10"> Nurse Dashboard</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item"> Nurse Dashboard</li>
                </ul>
            </div>
        </div>

    
    <!-- SUMMARY CARDS -->
    <div class="main-content">
        <div class="row"> 
            <div class="row mb-4">

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-left border-success">
                        <div class="card-body">
                            <h6 class="text-muted">Total Patients</h6>
                            <h3>{{ $patients->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-left border-danger">
                        <div class="card-body">
                            <h6 class="text-muted">Critical Patients</h6>
                            <h3>{{ $criticalPatients }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-left border-secondary">
                        <div class="card-body">
                            <h6 class="text-muted">Pending Medications</h6>
                            <h3>{{ $pendingMedications }}</h3>
                    
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-left border-warning">
                        <div class="card-body">
                            <h6 class="text-muted">Vitals Due</h6>
                            <h3>{{ $pendingVitals }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-left border-success">
                        <div class="card-body">
                            <h6 class="text-muted">Ready for Discharge</h6>
                            <h3>{{ $discharges }}</h3>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    Critical Patients
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>SpO2</th>
                                <th>BP</th>
                                <th>Temp</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($criticalList as $patient)
                                <tr class="table-danger">
                                    <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                    <td>{{ $patient->spo2 ?? '-' }}</td>
                                    <td>
                                        {{ $patient->blood_pressure_systolic ?? '-' }}/
                                        {{ $patient->blood_pressure_diastolic ?? '-' }}
                                    </td>
                                    <td>{{ $patient->temperature ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Critical Patients</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
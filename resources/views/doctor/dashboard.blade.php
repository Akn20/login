@extends('layouts.admin')

@section('content')

    <div class="container-fluid">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">    
                    <h5 class="m-b-10">Doctor Dashboard</h5>
                </div>
            </div>
        </div>

        <div class="main-content">

            <div class="row">

                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card border-start border-warning border-4 shadow-sm">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Today's Appointments</h6>
                                    <h3 class="fw-bold text-success">{{ $todayAppointments }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card border-start border-info border-4 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Consultations</h6>
                                    <h3 class="fw-bold text-info">{{ $totalConsultations }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card border-start border-primary border-4 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">IPD Patients</h6>
                                    <h3 class="fw-bold text-primary">{{ $admittedPatients }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card border-start border-success border-4 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Pending Labs</h6>
                                    <h3 class="fw-bold text-success">{{ $pendingLabRequests }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row-->    
                <div class="row">

                    <div class="col-md-3 mb-4">
                        <div class="card dashboard-card border-start border-info border-4 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-2">Total Patients</h6>
                                        <h3 class="fw-bold text-info">{{ $totalPatients }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card dashboard-card border-start border-warning border-4 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-2">Lab Requests</h6>
                                        <h3 class="fw-bold text-warning">{{ $totalLabRequests }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card dashboard-card border-start border-primary border-4 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-2">Admitted Patients</h6>
                                        <h3 class="fw-bold text-primary">{{ $admittedPatients }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="row mt-4">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Appointments</h5>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($appointments as $appointment)
                                        <tr>
                                            <td>
                                                {{ $appointment->patient->first_name ?? 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $appointment->doctor->name ?? 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $appointment->appointment_date }}
                                            </td>

                                            <td>
                                                {{ $appointment->appointment_status }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center"> No Appointments Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Consultations</h5>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($consultations as $consultation)
                                        <tr>
                                            <td>
                                                {{ $consultation->patient->first_name ?? 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $consultation->doctor->name ?? 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $consultation->consultation_date }}
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No Consultations Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
@endsection
@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <h4>Patient Dashboard</h4>
</div>

<div class="row">

    <!-- Appointments Card -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <i class="feather-calendar text-primary mb-2" style="font-size: 30px;"></i>
                <h6>Appointments</h6>
                <h4>{{ count($appointments) }}</h4>

                <a href="{{ route('admin.patient.portal.appointments') }}" 
                   class="btn btn-sm btn-outline-primary mt-2">
                    View All
                </a>
            </div>
        </div>
    </div>

    <!-- Lab Reports Card -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <i class="feather-activity text-success mb-2" style="font-size: 30px;"></i>
                <h6>Lab Reports</h6>
                <h4>{{ count($labReports) }}</h4>

                <a href="{{ route('admin.patient.portal.lab') }}" 
                   class="btn btn-sm btn-outline-success mt-2">
                    View Reports
                </a>
            </div>
        </div>
    </div>

    <!-- Radiology Card -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <i class="feather-camera text-danger mb-2" style="font-size: 30px;"></i>
                <h6>Radiology</h6>
                <h4>{{ count($radiologyReports) }}</h4>

                <a href="{{ route('admin.patient.portal.radiology') }}" 
                   class="btn btn-sm btn-outline-danger mt-2">
                    View Scans
                </a>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row mt-3">

    <!-- Recent Appointments -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <strong>Recent Appointments</strong>
            </div>
            <div class="card-body">
                @forelse($appointments as $appointment)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $appointment->appointment_date }}</span>
                        <span class="badge bg-info">
                            {{ $appointment->appointment_status }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted">No appointments</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Lab Reports -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <strong>Recent Lab Reports</strong>
            </div>
            <div class="card-body">
                @forelse($labReports as $report)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Report #{{ $report->id }}</span>
                        <span class="badge bg-success">
                            {{ $report->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted">No reports</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection
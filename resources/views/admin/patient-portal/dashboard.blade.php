@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4>Patient Dashboard</h4>
</div>

<div class="row">

    <!-- Appointments Card -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <i class="feather-calendar text-primary mb-2" style="font-size: 30px;"></i>
                <h6>Appointments</h6>
                <h4>{{ $appointmentsCount }}</h4>

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
                <h4>{{ $labReportsCount }}</h4>

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
                <h4>{{ $radiologyCount }}</h4>

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
        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Recent Appointments</strong>
            </div>
            <div class="card-body">
                @forelse($appointments->take(5) as $appointment)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                        </span>

                        <span class="badge bg-primary">
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
        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Recent Lab Reports</strong>
            </div>
            <div class="card-body">
                @forelse($labReports->take(5) as $report)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>
                            Sample: {{ $report->sample->sample_id ?? '-' }}
                        </span>

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

<!-- Radiology Section -->
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Recent Radiology Reports</strong>
            </div>
            <div class="card-body">
                @forelse($radiologyReports->take(5) as $report)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>
                            {{ $report->request->patient->first_name ?? 'Patient' }}
                        </span>

                        <span class="badge bg-danger">
                            {{ $report->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted">No radiology reports</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
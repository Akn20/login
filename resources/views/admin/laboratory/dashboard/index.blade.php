@extends('layouts.admin')

@section('page-title', 'Lab Technician Dashboard | ' . config('app.name'))
@section('title', 'Lab Technician Dashboard')

@push('styles')
    <style>
        .dashboard-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .dashboard-card .card-body {
            height: 220px;  
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .dashboard-card .card-title {
            font-size: 0.95rem;
            letter-spacing: 0.02em;
            margin-bottom: 1rem;
        }
        
        .dashboard-card h2 {
            margin: 0.5rem 0;
        }
        
        .dashboard-card p {
            margin: 0.5rem 0 0 0;
            font-size: 0.85rem;
        }
        
        .status-pill {
            font-size: 0.8rem;
            padding: 0.35rem 0.7rem;
        }
        
        /* Ensure table cards have minimum height for uniformity */
        .card-body.p-0 {
            min-height: 300px;
        }

        .full-height-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .full-height-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
@endpush

@section('content')
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-1">Lab Technician Dashboard</h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Lab Technician Dashboard</li>
            </ul>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-3 col-sm-6">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase text-muted mb-3">Pending Test Orders</h6>
                    <h2 class="fw-bold text-primary">{{ $pendingTests }}</h2>
                    <p class="mb-0 text-muted">Latest pending requests for technician action</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase text-muted mb-3">Samples Collected Today</h6>
                    <h2 class="fw-bold text-success">{{ $todaySamples }}</h2>
                    <p class="mb-0 text-muted">Samples logged for today's laboratory workflow</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase text-muted mb-3">Reports Pending Entry</h6>
                    <h2 class="fw-bold text-warning">{{ $pendingEntry }}</h2>
                    <p class="mb-0 text-muted">Tests awaiting result entry or review</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase text-muted mb-3">Reports Pending Approval</h6>
                    <h2 class="fw-bold text-info">{{ $pendingApproval }}</h2>
                    <p class="mb-0 text-muted">Completed reports waiting verification</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card dashboard-card shadow-sm bg-danger text-white">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase mb-3">Critical Alerts</h6>
                    <h2 class="fw-bold">{{ $criticalAlerts }}</h2>
                    <p class="mb-0 text-white-75">High-priority results requiring immediate attention</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase text-muted mb-3">Completed Reports</h6>
                    <h2 class="fw-bold text-success">{{ $completedReports }}</h2>
                    <p class="mb-0 text-muted">Tests completed in the current dataset</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase text-muted mb-3">Total Reports</h6>
                    <h2 class="fw-bold text-dark">{{ $totalReports }}</h2>
                    <p class="mb-0 text-muted">Total lab report records in the system</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card dashboard-card shadow-sm bg-warning text-dark">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase mb-3">Equipment Alerts</h6>
                    <h2 class="fw-bold">{{ $maintenanceAlerts }}</h2>
                    <p class="mb-0 text-dark-75">Maintenance items pending review or action</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-xl-6">
            <div class="card shadow-sm full-height-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Critical Results Alerts</h6>
                    <span class="badge bg-danger">{{ $criticalAlerts }} pending</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Sample</th>
                                    <th>Parameter</th>
                                    <th>Value</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alerts as $alert)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional(optional($alert->report)->sample)->sample_id ?? '-' }}</td>
                                        <td>{{ $alert->parameter_name }}</td>
                                        <td>{{ $alert->value }}</td>
                                        <td>
                                            <span class="badge bg-{{ $alert->status == 'Pending' ? 'danger' : 'success' }} status-pill">
                                                {{ $alert->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No critical alerts available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow-sm full-height-card">
                <div class="card-header">
                    <h6 class="mb-0">Test Completion Summary</h6>
                </div>
                <div class="card-body p-3">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <p class="text-uppercase text-muted mb-1">Completion Rate</p>
            <h3 class="fw-bold mb-0">{{ $completionRate }}%</h3>
        </div>

        <div class="text-end">
            <p class="mb-1 text-muted">Completed</p>
            <h4 class="fw-bold text-success mb-0">{{ $completedReports }}</h4>
        </div>
    </div>

    <div class="progress mb-4" style="height: 12px;">
        <div 
            class="progress-bar bg-success" 
            role="progressbar" 
            style="width: {{ $completionRate }}%">
        </div>
    </div>

    <div class="row g-3">
        <div class="col-sm-6">
            <div class="border rounded p-3 h-100 text-center">
                <p class="text-uppercase text-muted mb-2">Pending Reports</p>
                <h4 class="mb-0">{{ $pendingReports }}</h4>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="border rounded p-3 h-100 text-center">
                <p class="text-uppercase text-muted mb-2">Pending Orders</p>
                <h4 class="mb-0">{{ $pendingTests }}</h4>
            </div>
        </div>
    </div>

</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Pending Test Orders</h6>
                    <span class="badge bg-primary">{{ $pendingTests }} total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Patient</th>
                                    <th>Test</th>
                                    <th>Priority</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingTestsList as $request)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($request->patient)->first_name }} {{ optional($request->patient)->last_name }}</td>
                                        <td>{{ $request->test_name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $request->priority == 'High' ? 'danger' : ($request->priority == 'Medium' ? 'warning' : 'secondary') }} status-pill">
                                                {{ $request->priority ?? 'Normal' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No pending test orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Reports Pending Entry</h6>
                    <span class="badge bg-warning">{{ $pendingEntry }} awaiting entry</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Sample</th>
                                    <th>Patient</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingEntryReports as $report)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($report->sample)->sample_id }}</td>
                                        <td>{{ optional(optional(optional($report->sample)->labRequest)->patient)->first_name }} {{ optional(optional(optional($report->sample)->labRequest)->patient)->last_name }}</td>
                                        <td>
                                            <span class="badge bg-warning status-pill">{{ $report->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No reports pending entry.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Reports Pending Approval</h6>
                    <span class="badge bg-info">{{ $pendingApproval }} pending</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Sample</th>
                                    <th>Patient</th>
                                    <th>Verification</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingApprovalReports as $report)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($report->sample)->sample_id }}</td>
                                        <td>{{ optional(optional(optional($report->sample)->labRequest)->patient)->first_name }} {{ optional(optional(optional($report->sample)->labRequest)->patient)->last_name }}</td>
                                        <td>
                                            <span class="badge bg-info status-pill">{{ $report->verification_status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No reports pending approval.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Equipment Maintenance Alerts</h6>
                    <span class="badge bg-warning">{{ $maintenanceAlerts }} alerts</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Equipment</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($maintenanceAlertsList as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($item->equipment)->name ?? 'Unknown' }}</td>
                                        <td>{{ $item->maintenance_type }}</td>
                                        <td>{{ $item->maintenance_date ? \Carbon\Carbon::parse($item->maintenance_date)->format('Y-m-d') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No equipment maintenance alerts.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Samples Collected Today</h6>
                    <span class="badge bg-success">{{ $todaySamples }} collected</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Sample ID</th>
                                    <th>Patient</th>
                                    <th>Collection Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todaySamplesList as $sample)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sample->sample_id }}</td>
                                        <td>{{ optional(optional($sample)->labRequest)->patient ? optional(optional(optional($sample)->labRequest)->patient)->first_name . ' ' . optional(optional(optional($sample)->labRequest)->patient)->last_name : '-' }}</td>
                                        <td>{{ $sample->collection_time ? \Carbon\Carbon::parse($sample->collection_time)->format('H:i A') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No samples collected today.</td>
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
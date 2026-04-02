@extends('layouts.admin')

@section('page-title', 'HR Dashboard | ' . config('app.name'))

@section('content')
    <div class="nxl-content">
        <div class="main-content">
            {{-- Welcome card --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Welcome to HR</h5>
                                <p class="mb-0 text-muted">
                                    Use this dashboard to manage staff, attendance, leave and payroll.
                                </p>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('hr.staff-management.index') }}" class="btn btn-primary btn-sm">
                                    <i class="feather-user-plus me-1"></i> Manage Staff
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick navigation cards --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="mb-2">
                                <i class="feather-users me-1 text-primary"></i>
                                Staff Management
                            </h6>
                            <p class="text-muted mb-3">
                                View and update employee profiles, roles and departments.
                            </p>
                            <a href="{{ route('hr.staff-management.index') }}" class="btn btn-outline-primary btn-sm">
                                Go to Staff
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="mb-2">
                                <i class="feather-clock me-1 text-success"></i>
                                Attendance & Shifts
                            </h6>
                            <p class="text-muted mb-3">
                                Track attendance, manage shifts and review overtime / late entries.
                            </p>
                            <a href="{{ route('hr.attendance.index') }}" class="btn btn-outline-success btn-sm">
                                View Attendance
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="mb-2">
                                <i class="feather-calendar me-1 text-warning"></i>
                                Leave & Holidays
                            </h6>
                            <p class="text-muted mb-3">
                                Configure leave types, holidays and approve employee leave requests.
                            </p>
                            <a href="{{ route('hr.leave-report.index') }}" class="btn btn-outline-warning btn-sm">
                                Leave Overview
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats widgets --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small text-uppercase">Total Staff</div>
                                <h4 class="mb-0">
                                    {{ $stats['total_staff'] ?? '0' }}
                                </h4>
                            </div>
                            <div class="avatar-text avatar-md bg-soft-primary text-primary">
                                <i class="feather-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small text-uppercase">Active Staff</div>
                                <h4 class="mb-0">
                                    {{ $stats['active_staff'] ?? '0' }}
                                </h4>
                            </div>
                            <div class="avatar-text avatar-md bg-soft-success text-success">
                                <i class="feather-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small text-uppercase">Pending Leave Requests</div>
                                <h4 class="mb-0">
                                    {{ $stats['pending_leaves'] ?? '0' }}
                                </h4>
                            </div>
                            <div class="avatar-text avatar-md bg-soft-warning text-warning">
                                <i class="feather-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts row --}}
            <div class="row mt-3">
                {{-- Headcount by Department (horizontal bar) --}}
                <div class="col-lg-6">
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-uppercase small text-muted">
                                Headcount by Department
                            </span>
                            <i class="feather-bar-chart-2 text-muted"></i>
                        </div>
                        <div class="card-body" style="height: 260px;">
                            <canvas id="departmentBarChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Attendance (stacked present vs absent) --}}
                <div class="col-lg-6">
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-uppercase small text-muted">
                                Attendance (Last 7 Days)
                            </span>
                            <i class="feather-trending-up text-muted"></i>
                        </div>
                        <div class="card-body" style="height: 260px;">
                            <canvas id="attendanceStackedChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Staff status donut --}}
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-4">
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-uppercase small text-muted">
                                Staff Status
                            </span>
                            <i class="feather-pie-chart text-muted"></i>
                        </div>
                        <div class="card-body" style="height: 260px;">
                            <canvas id="staffStatusDonut"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Horizontal bar: Headcount by Department
            const deptCtx = document.getElementById('departmentBarChart').getContext('2d');
            new Chart(deptCtx, {
                type: 'bar',
                data: {
                    labels: @json($departmentLabels),
                    datasets: [{
                        label: 'Staff',
                        data: @json($departmentCounts),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderRadius: 6,
                        maxBarThickness: 30,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ` ${ctx.parsed.x} staff`
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            // Stacked bar: Attendance present vs absent for last 7 days
            const attCtx = document.getElementById('attendanceStackedChart').getContext('2d');
            new Chart(attCtx, {
                type: 'bar',
                data: {
                    labels: @json($attendanceLabels),
                    datasets: [
                        {
                            label: 'Present',
                            data: @json($presentCounts),
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderRadius: 4,
                        },
                        {
                            label: 'Absent',
                            data: @json($absentCounts),
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                    },
                    scales: {
                        x: { stacked: true },
                        y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });

            // Donut: Staff Status (Active / Inactive / Others)
            const statusCtx = document.getElementById('staffStatusDonut').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        data: @json($statusCounts),
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.9)',
                            'rgba(255, 159, 64, 0.9)',
                            'rgba(201, 203, 207, 0.9)',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                    },
                    cutout: '60%',
                }
            });
        });
    </script>
@endpush
@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Dashboard</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Accountant</li>
                <li class="breadcrumb-item">Dashboard</li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="row">

            <!-- Today's Revenue -->
            <div class="col-md-3 mb-4">
                <div class="card dashboard-card border-start border-warning border-4 shadow-sm">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Today's Revenue</h6>
                                <h3 class="fw-bold text-success"> ₹ {{ number_format($todayRevenue, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cash Collection -->
            <div class="col-md-3 mb-4">
                <div class="card dashboard-card border-start border-info border-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Daily Cash Collection</h6>
                                <h3 class="fw-bold text-primary">₹ {{ number_format($cashCollection, 2) }}</h3>
                            </div>                    
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outstanding Dues -->
            <div class="col-md-3 mb-4">
                <div class="card dashboard-card border-start border-danger border-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Outstanding Dues</h6>
                                <h3 class="fw-bold text-danger"> ₹ {{ number_format($outstandingDues, 2) }}</h3>
                            </div>                    
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Bills -->
            <div class="col-md-3 mb-4">
                <div class="card dashboard-card border-start border-success border-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Bills</h6>
                                <h3 class="fw-bold text-dark"> {{ $totalBills }}</h3>
                            </div>                      
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row -->
        <div class="row">

            <!-- Paid Bills -->
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card border-start border-success ">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-3">Paid Bills</h6>
                        <h2 class="fw-bold text-success">{{ $paidBills }}</h2>
                    </div>
                </div>
            </div>

            <!-- Partial Bills -->
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card border-start border-danger border-4 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-3">Partial Bills</h6>
                        <h2 class="fw-bold text-warning">{{ $partialBills }}</h2>
                    </div>
                </div>
            </div>

            <!-- Pending Bills -->
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card border-start border-info border-4 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-3">Pending Bills</h6>
                        <h2 class="fw-bold text-danger">{{ $pendingBills }} </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Revenue Overview (Last 7 Days)</h5>
                    </div>

                    <div class="card-body">
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($revenueChartLabels),
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenueChartData),
                    borderWidth: 3,
                    tension: 0.4,
                    fill: false
                }]
            },

            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
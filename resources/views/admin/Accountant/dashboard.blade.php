@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Accountant Dashboard</h2>
    </div>

    <!-- First Row -->
    <div class="row">

        <!-- Today's Revenue -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Today's Revenue</h6>

                            <h3 class="fw-bold text-success">
                                ₹ {{ number_format($todayRevenue, 2) }}
                            </h3>
                        </div>

                        
                    </div>

                </div>
            </div>
        </div>

        <!-- Cash Collection -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Daily Cash Collection</h6>

                            <h3 class="fw-bold text-primary">
                                ₹ {{ number_format($cashCollection, 2) }}
                            </h3>
                        </div>

                        
                    </div>

                </div>
            </div>
        </div>

        <!-- Outstanding Dues -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Outstanding Dues</h6>

                            <h3 class="fw-bold text-danger">
                                ₹ {{ number_format($outstandingDues, 2) }}
                            </h3>
                        </div>

                        
                    </div>

                </div>
            </div>
        </div>

        <!-- Total Bills -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Bills</h6>
                            <h3 class="fw-bold text-dark">
                                {{ $totalBills }}
                            </h3>
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
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">

                    <h6 class="text-muted mb-3">Paid Bills</h6>

                    <h2 class="fw-bold text-success">
                        {{ $paidBills }}
                    </h2>

                </div>
            </div>
        </div>

        <!-- Partial Bills -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">

                    <h6 class="text-muted mb-3">Partial Bills</h6>

                    <h2 class="fw-bold text-warning">
                        {{ $partialBills }}
                    </h2>

                </div>
            </div>
        </div>

        <!-- Pending Bills -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">

                    <h6 class="text-muted mb-3">Pending Bills</h6>

                    <h2 class="fw-bold text-danger">
                        {{ $pendingBills }}
                    </h2>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
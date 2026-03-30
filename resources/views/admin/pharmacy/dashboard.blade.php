@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="mb-4">Pharmacy Dashboard</h2>

    <div class="row">

        <!-- Pending Prescriptions -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5>Pending Prescriptions</h5>
                    <h3>{{ $pendingPrescriptions }}</h3>
                </div>
            </div>
        </div>

        <!-- Today's Sales -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Today's Sales</h5>
                    <h3>₹ {{ $todaySales }}</h3>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5>Low Stock</h5>
                    <h3>{{ $lowStock }}</h3>
                </div>
            </div>
        </div>

        <!-- Expiry Alerts -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5>Expiry Alerts</h5>
                    <h3>{{ $expiryAlerts }}</h3>
                </div>
            </div>
        </div>

        <!-- Controlled Drugs -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h5>Controlled Drugs</h5>
                    <h3>{{ $controlledDrugs }}</h3>
                </div>
            </div>
        </div>

        <!-- Return Requests -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h5>Return Requests</h5>
                    <h3>{{ $returnRequests }}</h3>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="mb-4">Pharmacy Dashboard</h2>

    <div class="row">

        <!-- Pending Prescriptions -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left border-success">                
                <div class="card-body">
                    <h6 class="text-muted">Pending Prescriptions</h6>
                    <h3>{{ $pendingPrescriptions }}</h3>
                </div>
            </div>
        </div>

        <!-- Today's Sales -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left border-secondary">
                <div class="card-body">
                    <h5>Today's Sales</h5>
                    <h3>₹ {{ $todaySales }}</h3>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-md-4 mb-3">
           <div class="card shadow-sm border-left border-warning">
                <div class="card-body">
                    <h5>Low Stock</h5>
                    <h3>{{ $lowStock }}</h3>
                </div>
            </div>
        </div>

        <!-- Expiry Alerts -->
        <div class="col-md-4 mb-3 ">
            <div class="card shadow-sm border-left border-danger">
                <div class="card-body">
                    <h5>Expiry Alerts</h5>
                    <h3>{{ $expiryAlerts }}</h3>
                </div>
            </div>
        </div>

        <!-- Controlled Drugs -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left border-primary">
                <div class="card-body">
                    <h5>Controlled Drugs</h5>
                    <h3>{{ $controlledDrugs }}</h3>
                </div>
            </div>
        </div>

        <!-- Return Requests -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left border-success">
                <div class="card-body">
                    <h5>Return Requests</h5>
                    <h3>{{ $returnRequests }}</h3>
                </div>
            </div>
        </div>

    </div>
    <div class="card mt-3">
        <div class="card-body text-center">
            <h3>Stock Distribution</h3>
            <div style="width: 500px; height: 500px; margin: auto;">
                <canvas id="stockChart"></canvas>
            </div>   
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const stockCtx = document.getElementById('stockChart');

new Chart(stockCtx, {
    type: 'doughnut',
    data: {
        labels: ['Available', 'Low Stock', 'Out of Stock'],
        datasets: [{
            data: [
                {{ $availableStock }},
                {{ $lowStockCount }},
                {{ $outOfStock }}
            ],
            backgroundColor: [
                '#28a745', // green
                '#ffc107', // yellow
                '#dc3545'  // red
            ],
        }]
    },
});
</script>
@endsection
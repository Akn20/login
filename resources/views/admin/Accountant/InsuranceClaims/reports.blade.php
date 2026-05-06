@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="page-header mb-4">
        <h5>Insurance Reports</h5>
    </div>

    <div class="row">

        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h6>Total Claims</h6>
                <h4>{{ $totalClaims }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h6>Total Billed</h6>
                <h4>₹ {{ number_format($totalBilled, 2) }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h6>Total Approved</h6>
                <h4>₹ {{ number_format($totalApproved, 2) }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h6>Total Paid</h6>
                <h4>₹ {{ number_format($totalPaid, 2) }}</h4>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        <div class="col-md-3">
            <div class="card p-3 text-center bg-warning">
                <h6>Pending</h6>
                <h4>{{ $pendingClaims }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 text-center bg-info">
                <h6>Partial</h6>
                <h4>{{ $partialClaims }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 text-center bg-success">
                <h6>Approved</h6>
                <h4>{{ $approvedClaims }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 text-center bg-danger">
                <h6>Discrepancies</h6>
                <h4>{{ $discrepancies }}</h4>
            </div>
        </div>

    </div>
    <div class="row mt-4">

    {{-- Status Pie Chart --}}
    <div class="col-md-6">
        <div class="card p-3">
            <h6 class="text-center">Claim Status Distribution</h6>
            <canvas id="statusChart" style="height:300px;"></canvas>
        </div>
    </div>

    {{-- Financial Bar Chart --}}
    <div class="col-md-6">
        <div class="card p-3">
            <h6 class="text-center">Financial Overview</h6>
            <canvas id="financeChart" style="height:410px;"></canvas>
        </div>
    </div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const statusData = @json($statusData);

    const statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: ['Pending', 'Partial', 'Approved'],
            datasets: [{
                data: [
                    statusData.pending,
                    statusData.partial,
                    statusData.approved
                ]
            }]
        }
    });
</script>
<script>
    const financialData = @json($financialData);

    const financeChart = new Chart(document.getElementById('financeChart'), {
    type: 'bar',
    data: {
        labels: ['Billed', 'Approved', 'Paid'],
        datasets: [{
            label: 'Amount (₹)',
            data: [
                financialData.billed,
                financialData.approved,
                financialData.paid
            ]
        }]
    }
   
});
</script>
@endsection
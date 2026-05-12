@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="mb-4">
        <h4 class="fw-bold">Receptionist Dashboard</h4>
    </div>

    <!-- 🔹 ROW 1 -->
    <div class="row">

        <!-- Waiting Patients -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.tokens.index') }}" class="text-decoration-none text-dark">
                <div class="card dashboard-card border-start border-warning border-4 shadow-sm">
                    <div class="card-body">
                        <h6>Waiting Patients</h6>
                        <h3>{{ $waitingPatients }}</h3>
                    </div>
                </div>
            </a>
        </div>

        <!-- Token Queue -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.tokens.index') }}" class="text-decoration-none text-dark">
                <div class="card dashboard-card border-start border-info border-4 shadow-sm">
                    <div class="card-body">
                        <h6>Token Queue</h6>
                        <h5>Current: {{ $currentToken ?? 'N/A' }}</h5>
                        <small>Waiting: {{ $waitingTokens }}</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- New Registrations -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.patients.index') }}" class="text-decoration-none text-dark">
                <div class="card dashboard-card border-start border-success border-4 shadow-sm">
                    <div class="card-body">
                        <h6>New Registrations</h6>
                        <h3>{{ $newRegistrations }}</h3>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- 🔹 ROW 2 -->
    <div class="row">

        <!-- Pending Admissions -->
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card border-start border-danger border-4 shadow-sm">
                <div class="card-body">
                    <h6>Pending Admissions</h6>
                    <h3>{{ $pendingAdmissions }}</h3>
                </div>
            </div>
        </div>

        <!-- Doctor Availability -->
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card border-start border-secondary border-4 shadow-sm">
                <div class="card-body">
                    <h6>Doctors Available</h6>
                    <h3>{{ $availableDoctors }} / {{ $totalDoctors }}</h3>
                </div>
            </div>
        </div>

        <!-- Emergency -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.emergency.create') }}" class="text-decoration-none text-dark">
                <div class="card dashboard-card border-start border-danger border-4 shadow-sm">
                    <div class="card-body">
                        <h6>Emergency Arrivals</h6>
                        <h3>{{ $emergencyCount }}</h3>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- 🔹 ROW 3 (Charts instead of 2 cards) -->
    <div class="row">

        <!-- Appointments Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold">Today's Appointments (Last 7 Days)</h6>
                    <div id="appointmentsChart"></div>
                </div>
            </div>
        </div>

        <!-- Collection Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold">Daily Collection (Last 7 Days)</h6>
                    <div id="collectionChart"></div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection


@push('styles')
<style>
.dashboard-card {
    border-radius: 8px;
    transition: 0.2s;
}
.dashboard-card:hover {
    transform: translateY(-3px);
}
</style>
@endpush


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    // 📊 Appointments Chart
    new ApexCharts(document.querySelector("#appointmentsChart"), {
        chart: {
            type: 'area',
            height: 250
        },
        series: [{
            name: 'Appointments',
            data: @json($appointmentData)
        }],
        xaxis: {
            categories: @json($appointmentLabels)
        },
        stroke: {
            curve: 'smooth'
        },
        dataLabels: {
            enabled: false
        }
    }).render();

    // 💰 Collection Chart
    new ApexCharts(document.querySelector("#collectionChart"), {
        chart: {
            type: 'bar',
            height: 250
        },
        series: [{
            name: 'Collection',
            data: @json($collectionData)
        }],
        xaxis: {
            categories: @json($appointmentLabels)
        },
        dataLabels: {
            enabled: false
        }
    }).render();

});
</script>
@endpush
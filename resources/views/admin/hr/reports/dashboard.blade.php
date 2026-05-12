@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4 fw-bold">HR Reports Dashboard</h3>

    {{-- 🔥 KPI CARDS --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card shadow border-0 text-white" style="background: linear-gradient(45deg, #4facfe, #00f2fe);">
                <div class="card-body text-center">
                    <h6>Total Employees</h6>
                    <h2>{{ $totalEmployees }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 text-white" style="background: linear-gradient(45deg, #43e97b, #38f9d7);">
                <div class="card-body text-center">
                    <h6>Total Reports</h6>
                    <h2>6+</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- 🚀 REPORT CARDS --}}
    <div class="row mb-4">

        @php
        $cards = [
            ['route' => 'staff-strength', 'title' => 'Staff Strength', 'icon' => 'users'],
            ['route' => 'attendance', 'title' => 'Attendance', 'icon' => 'calendar'],
            ['route' => 'leave', 'title' => 'Leave Report', 'icon' => 'file-text'],
            ['route' => 'payroll', 'title' => 'Payroll', 'icon' => 'dollar-sign'],
            ['route' => 'overtime', 'title' => 'Overtime', 'icon' => 'clock'],
            ['route' => 'department-salary', 'title' => 'Department Salary', 'icon' => 'pie-chart'],
        ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.reports.' . $card['route']) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 hover-card">
                    <div class="card-body text-center">
                        <i class="feather-{{ $card['icon'] }} mb-2" style="font-size: 24px;"></i>
                        <h6 class="mb-0">{{ $card['title'] }}</h6>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

    </div>

    {{-- 📊 CHARTS --}}
    <div class="row">

        <div class="col-md-6">
            <div class="card shadow border-0 p-3">
                <h5 class="mb-3">Department Salary Distribution</h5>
                <canvas id="deptChart"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow border-0 p-3">
                <h5 class="mb-3">Attendance (Last 7 Days)</h5>
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

    </div>

</div>

@endsection

{{-- 🎨 CUSTOM STYLE --}}
<style>
.hover-card {
    transition: 0.3s;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
</style>

{{-- 📊 CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    new Chart(document.getElementById('deptChart'), {
        type: 'doughnut',
        data: {
            labels: @json($deptLabels),
            datasets: [{
                data: @json($deptValues),
                backgroundColor: ['#4facfe','#43e97b','#fa709a','#f7971e','#a18cd1']
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    new Chart(document.getElementById('attendanceChart'), {
        type: 'bar',
        data: {
            labels: @json($attLabels),
            datasets: [{
                label: 'Present',
                data: @json($attValues),
                backgroundColor: '#4facfe'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

});
</script>
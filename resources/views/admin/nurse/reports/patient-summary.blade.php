@extends('layouts.admin')

@section('page-title', 'Patient Summary | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">         
                    <h5 class="m-b-10">Patient Summary</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">Patient Summary</li>
                </ul>
            </div>
        </div>

        <div class="main-content mt-3">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- Filter -->
                    <form method="GET">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row align-items-end g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Select Patient</label>
                                        <select name="patient_id" class="form-control">
                                            <option value="">-- Select Patient --</option>
                                            @foreach($patients as $id => $name)
                                                <option value="{{ $id }}" {{ request('patient_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <button class="btn btn-primary w-100">View Summary</button>
                                    </div>

                                    <div class="col-md-3">
                                        <a href="{{ route('admin.nurse-reports.patient-summary') }}" class="btn btn-light w-100">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if($patient)

                    <!--Vitals -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-3">Recent Vitals</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Temp</th>
                                            <th>BP</th>
                                            <th>Pulse</th>
                                            <th>SpO2</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($vitals as $v)
                                        <tr>
                                            <td>{{ $v->temperature ?? '-' }}</td>
                                            <td>{{ $v->blood_pressure_systolic }}/{{ $v->blood_pressure_diastolic }}</td>
                                            <td>{{ $v->pulse_rate ?? '-' }}</td>
                                            <td>{{ $v->spo2 ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($v->recorded_at)->format('d M Y, h:i A') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No vitals available</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!--Medications -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-3">Recent Medications</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($medications as $m)
                                        <tr>
                                            <td>
                                                <span class="badge {{ $m->status == 'administered' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($m->status) }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($m->administered_time)->format('d M Y, h:i A') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">No medication records</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!--Nursing Notes -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-3">Nursing Notes</h6>

                            @forelse($notes as $n)
                                <div class="border rounded p-3 mb-2">
                                    <p class="mb-1">
                                        {{ $n->patient_condition ?? 'No condition noted' }}
                                    </p>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($n->created_at)->format('d M Y, h:i A') }}
                                    </small>
                                </div>
                            @empty
                                <p class="text-muted">No notes available</p>
                            @endforelse
                        </div>
                    </div>
                    @else
                        <div class="alert alert-info text-center">
                            Please select a patient to view summary.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
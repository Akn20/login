@extends('layouts.admin')

@section('page-title', 'Vitals Report | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">         
                    <h3 class="m-b-10">Vital Trends Report</h3>
                </div>

                
            </div>
        </div>

        <!--  Filters -->
        <form method="GET" class="row mb-3">
            <div class="col-md-3">
                <input type="text" name="patient_id" placeholder="Patient ID" class="form-control">
            </div>

            <div class="col-md-3">
                <input type="date" name="from" class="form-control">
            </div>

            <div class="col-md-3">
                <input type="date" name="to" class="form-control">
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <!-- 📋 Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Temperature</th>
                    <th>BP</th>
                    <th>Pulse</th>
                    <th>SpO2</th>
                    <th>Recorded At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vitals as $v)
                <tr>
                    <td>{{ $v->patient->name ?? 'N/A' }}</td>
                    <td>{{ $v->temperature ?? '-' }}</td>
                    <td>
                        {{ $v->blood_pressure_systolic }}/{{ $v->blood_pressure_diastolic }}
                    </td>
                    <td>{{ $v->pulse_rate ?? '-' }}</td>
                    <td>{{ $v->spo2 ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($v->recorded_at)->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No records found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $vitals->links() }}
    </div>
@endsection
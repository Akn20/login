@extends('layouts.admin')

@section('page-title', 'Vitals Report | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">         
                    <h5 class="m-b-10">Vital Trends Report</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">Vital Trends Report</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            
            <form method="GET">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-end g-3">

                            <div class="col-md-4">
                                <label class="form-label">Patient</label>
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
                                <label class="form-label"> Date</label>
                                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                            </div>

                            <div class="col-md-1">
                                <button class="btn btn-primary w-100">Filter</button>
                            </div>

                            <div class="col-md-1">
                                <a href="{{ route('admin.nurse-reports.vitals') }}" class="btn btn-light w-100">Reset</a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            <div class="row"> 
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive"> 
                                <table class="table table-hover">
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
                                            <td>{{ $v->patient_name ?? $v->patient_id }}</td>
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
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $vitals->links() }}
    </div>
@endsection
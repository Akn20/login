@extends('layouts.admin')

@section('page-title', 'Medication Report | ' . config('app.name'))

@section('content')
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">         
                    <h5 class="m-b-10">Medication Report</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">Medication Report</li>
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
                                <input type="text" name="patient_id" value="{{ request('patient_id') }}" placeholder="Patient ID" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All</option>
                                    <option value="administered" {{ request('status') == 'administered' ? 'selected' : '' }}>Administered</option>
                                    <option value="missed" {{ request('status') == 'missed' ? 'selected' : '' }}>Missed</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-primary w-100">Filter</button>
                            </div>

                            <div class="col-md-2">
                                <a href="{{ route('admin.nurse-reports.medications') }}" class="btn btn-light w-100">Reset</a>
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
                                            <th>Medication</th>
                                            <th>Status</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $m)
                                        <tr>
                                            <td>{{ $m->patient_name ?? 'N/A' }}</td>
                                            <td>{{ $m->medication_name ?? 'N/A' }}</td>
                                            <td>{{ $m->status }}</td>
                                            <td>{{ \Carbon\Carbon::parse($m->administered_time)->format('d M Y, h:i A') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{ $data->links() }}
        </div>
    </div>
@endsection
@extends('layouts.admin')

@section('content')

    <div class="nxl-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Discharge Preparation</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.nurse-discharge.index') }}">View Discharge Details</a>
                    </li>
                </ul>
            </div>
            <div class="page-header-right ms-auto d-flex gap-1">
                <a href="{{ route('admin.nurse-discharge.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>

        <!-- main content -->
        <div class="main-content">
            <div class="row mb-3">
                <div class="row justify-content-center">

                    <!-- Patient Info -->
                    <div class="col-md-5">
                        <div class="card shadow-sm mb-3">
                            <div class="card-header">
                                <h5>Patient Information</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Name:</strong>
                                    {{ $ipd->patient->first_name ?? '' }}
                                    {{ $ipd->patient->last_name ?? '' }}
                                </p>

                                <p><strong>Admission ID:</strong> {{ $ipd->admission_id }}</p>
                                <p><strong>Ward:</strong> {{ $ipd->ward->ward_name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-5">
                        <div class="card shadow-sm mb-3">
                            <div class="card-header">
                                <h5>Status</h5>
                            </div>
                            <div class="card-body">
                                <p>
                                    <strong>Status:</strong>
                                    @if($record->status == 'ready')
                                        <span class="badge bg-success">Ready</span>
                                    @elseif($record->status == 'in_progress')
                                        <span class="badge bg-warning text-dark">In Progress</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </p>

                                <p><strong>Prepared At:</strong> {{ $record->prepared_at ?? '-' }}</p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center ">
                    <!-- Checklist -->
                    <div class="col-md-5">
                        <div class="card shadow-sm mb-3">
                            <div class="card-header">
                                <h5>Checklist</h5>
                            </div>
                            <div class="card-body">
                                @if($record && $record->checklist)
                                    @foreach($record->checklist as $key => $value)
                                        <p>✔ {{ ucfirst(str_replace('_',' ', $key)) }}</p>
                                    @endforeach
                                @else
                                    <p>No checklist available</p>
                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- Belongings -->
                    <div class="col-md-5">
                        <div class="card shadow-sm mb-3">
                            <div class="card-header">
                                <h5>Belongings</h5>
                            </div>
                            <div class="card-body">
                                <p>
                                    {{ $record->belongings_status ? 'Returned' : 'Not Returned' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
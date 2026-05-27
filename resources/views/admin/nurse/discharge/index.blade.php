@extends('layouts.admin')

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">   
                    <h5 class="m-b-10">Discharge Preparation</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">Discharge preparation</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row"> 
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>sl No</th>
                                            <th>Patient Name</th>
                                            <th>Admission ID</th>
                                            <th>Ward</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($ipds as $index => $ipd)

                                            @php
                                                $record = $discharges[$ipd->id] ?? null;
                                            @endphp

                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $ipd->patient->first_name ?? '' }} {{ $ipd->patient->last_name ?? '' }}</td>
                                                <td>{{ $ipd->admission_id }}</td>
                                                <td>{{ $ipd->ward->ward_name ?? '-' }}</td>

                                                <td>
                                                    @if($record)
                                                        @if($record->status == 'ready')
                                                            <span class="badge bg-success">Ready</span>
                                                        @elseif($record->status == 'in_progress')
                                                            <span class="badge bg-warning text-dark">In Progress</span>
                                                        @else
                                                            <span class="badge bg-secondary">Pending</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-secondary">Not Started</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('admin.nurse-discharge.form', $ipd->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        Prepare
                                                    </a>
                                                </td>
                                                
                                                <td>
                                                    @if($record)
                                                        <a href="{{ route('admin.nurse-discharge.view', $ipd->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            View
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No admitted patients found</td>
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
    </div>
@endsection
@extends('layouts.admin')

@section('page-title', 'Lab & Report View | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
                <div class="page-header-left d-flex align-items-center">

                    <div class="page-header-title">
                        <h5 class="m-b-10">Lab & Report View</h5>
                    </div>

                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">Nurse</li>
                        <li class="breadcrumb-item">Lab & Reports</li>
                    </ul>
                </div>

                
            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.nurse-lab-reports.index') }}" class="btn btn-light">
                    Back
                </a>
            </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="row mb-3">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div class="card shadow-sm mb-3">
                            <div class="card-header">
                                <h5>Report Details</h5>
                            </div>
                        
                            <div class="card-body">
                                {{-- Patient and status --}}
                                <p><strong>Patient:</strong>
                                    {{ $type == 'lab' ? ($report->patient ?? 'N/A') : ($report->request->patient->first_name ?? 'N/A') }}
                                </p>

                                <p><strong>Status:</strong>
                                    <span class="badge bg-success">{{ $report->status }}</span>
                                </p>

                                <hr>

                                {{-- ================= LAB VIEW ================= --}}
                                @if($type == 'lab')

                                    <h5 class="mb-3">Test Results</h5>

                                    @php
                                        $results = json_decode($report->result_data, true);
                                    @endphp

                                    @if($results)
                                        <table class="table table-bordered table-sm align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Parameter</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($results as $key => $value)
                                                    <tr>
                                                        <td><strong>{{ $key }}</strong></td>
                                                        <td>{{ $value }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>No result data available</p>
                                    @endif

                                {{---------- RADIOLOGY VIEW -----------}}
                                @elseif($type == 'radiology')

                                    <p><strong>Observations:</strong> {{ $report->observations }}</p>
                                    <p><strong>Findings:</strong> {{ $report->findings }}</p>
                                    <p><strong>Diagnosis:</strong> {{ $report->diagnosis }}</p>

                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@extends('layouts.admin')

@section('page-title', 'Lab & Report View | ' . config('app.name'))

@section('content')
    <div class="nxl-content">
        
        <!--  Page Header -->
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
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">

                                <table class="table table-Hover">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($reports as $report)
                                        <tr>
                                            <td>{{ $report['patient'] }}</td>

                                            <td>{{ ucfirst($report['type']) }}</td>

                                            <td><span class="badge bg-warning">{{ $report['status'] }}</span> </td>

                                            <td>{{ \Carbon\Carbon::parse($report['date'])->format('d M Y') }}</td>

                                            <td>
                                                <a href="{{ route('admin.nurse-lab-reports.show', [$report['type'], $report['id']]) }}"
                                                class="avatar-text avatar-md action-icon action-edit"><i class="feather-eye"></i>
                                                    
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
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
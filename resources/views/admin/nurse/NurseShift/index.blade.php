@extends('layouts.admin')

@section('page-title', 'Shift Management | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">   
                    <h5 class="m-b-10">Shift Management</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">Shift Management</li>
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
                                                <th>Nurse</th>
                                                <th>Shift Name</th>
                                                <th>Time</th>
                                                <th>Date Range</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($shifts as $shift)
                                            <tr>
                                                <td>{{ $shift->nurse_name }}</td>
                                                <td>{{ $shift->shift_name }}</td>
                                                <td> {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} <strong>To</strong> {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}</td>
                                                <td>{{ $shift->start_date }} <strong>To </strong>{{ $shift->end_date }} </td>

                                                <td>
                                                    <a href="{{ route('admin.nurse-shifts.create', $shift->id) }}"
                                                    class="btn btn-neutral">
                                                       Add Handover
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.nurse-shifts.show', $shift->id) }}"
                                                    class="btn btn-neutral">
                                                        View Handover
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No shifts found</td>
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
    </div>
@endsection
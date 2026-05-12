@extends('layouts.admin')

@section('page-title', 'Isolation Records | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <!-- Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">
                    <h5 class="m-b-10">Isolation Management</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">Isolation</li>
                </ul>

            </div>

            <div class="page-header-right ms-auto d-flex gap-2">

                <a href="{{ route('admin.isolation.trash') }}" class="btn btn-neutral">
                    Deleted Records
                </a>

                <a href="{{ route('admin.isolation.create') }}" class="btn btn-neutral">
                    Add Isolation Record
                </a>

            </div>
        </div>

        <!-- Table -->
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table table-hover">

                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Patient</th>
                                            <th>Isolation Type</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($records as $index => $record)

                                            <tr>

                                                <td>{{ $index + 1 }}</td>

                                                <td>
                                                    {{ $record->patient->first_name ?? '' }}
                                                    {{ $record->patient->last_name ?? '' }}
                                                </td>

                                                <td>{{ $record->isolation_type }}</td>

                                                <td>{{ $record->start_date }}</td>

                                                <td>{{ $record->end_date ?? '-' }}</td>

                                                <td>
                                                    @if($record->status == 'Active')
                                                        <span class="badge bg-soft-warning text-warning">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-success text-success">Completed</span>
                                                    @endif
                                                </td>

                                                <td class="text-end">

                                                    <div class="hstack gap-2 justify-content-end">

                                                        {{-- Edit --}}
                                                        <a href="{{ route('admin.isolation.edit', $record->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        {{-- Delete --}}
                                                        <form action="{{ route('admin.isolation.delete', $record->id) }}"
                                                            method="POST" onsubmit="return confirm('Delete this record?')">

                                                            @csrf

                                                            <button class="avatar-text avatar-md action-icon action-delete">
                                                                <i class="feather-trash-2"></i>
                                                            </button>

                                                        </form>

                                                    </div>

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
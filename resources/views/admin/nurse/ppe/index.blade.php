@extends('layouts.admin')

@section('page-title', 'PPE Compliance | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <!-- Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">
                    <h5 class="m-b-10">PPE Compliance Management</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Nurse</li>
                    <li class="breadcrumb-item">PPE Compliance</li>
                </ul>

            </div>

            <div class="page-header-right ms-auto d-flex gap-2">

                <a href="{{ route('admin.ppe.trash') }}" class="btn btn-neutral">
                    Deleted Records
                </a>

                <a href="{{ route('admin.ppe.create') }}" class="btn btn-neutral">
                    Add PPE Record
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
                                            <th>PPE Used</th>
                                            <th>PPE Type</th>
                                            <th>Compliance Status</th>
                                            <th>Recorded At</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($logs as $index => $log)

                                            <tr>

                                                <td>{{ $index + 1 }}</td>

                                                <td>
                                                    {{ $log->patient->first_name ?? '' }}
                                                    {{ $log->patient->last_name ?? '' }}
                                                </td>

                                                <td>
                                                    @if($log->ppe_used)
                                                        <span class="badge bg-soft-success text-success">Yes</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">No</span>
                                                    @endif
                                                </td>

                                                <td>{{ $log->ppe_type ?? '-' }}</td>

                                                <td>
                                                    @if($log->compliance_status == 'Compliant')
                                                        <span class="badge bg-soft-success text-success">Compliant</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Non-compliant</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($log->recorded_at)->format('d-m-Y H:i') }}
                                                </td>

                                                <td class="text-end">

                                                    <div class="hstack gap-2 justify-content-end">

                                                        {{-- Edit --}}
                                                        <a href="{{ route('admin.ppe.edit', $log->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        {{-- Delete --}}
                                                        <form action="{{ route('admin.ppe.delete', $log->id) }}" method="POST"
                                                            onsubmit="return confirm('Delete this record?')">

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
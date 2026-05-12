@extends('layouts.admin')

@section('page-title', 'Deleted PPE Records')

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left">
                <h5>Deleted PPE Records</h5>
            </div>

            <div class="page-header-right ms-auto">
                <a href="{{ route('admin.ppe.index') }}" class="btn btn-neutral">Back</a>
            </div>
        </div>

        <div class="main-content">
            <div class="card">
                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Sl.No.</th>
                                    <th>Patient</th>
                                    <th>PPE Used</th>
                                    <th>PPE Type</th>
                                    <th>Compliance</th>
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
                                        <td>{{ $log->compliance_status }}</td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($log->recorded_at)->format('d-m-Y H:i') }}
                                        </td>

                                        <td class="text-end">

                                            <div class="hstack gap-2 justify-content-end">

                                                <a href="{{ route('admin.ppe.restore', $log->id) }}"
                                                    class="avatar-text avatar-md action-icon action-restore">
                                                    <i class="feather-refresh-ccw"></i>
                                                </a>

                                                <a href="{{ route('admin.ppe.forceDelete', $log->id) }}"
                                                    class="avatar-text avatar-md action-icon action-delete"
                                                    onclick="return confirm('Permanent delete?')">
                                                    <i class="feather-trash"></i>
                                                </a>

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

@endsection
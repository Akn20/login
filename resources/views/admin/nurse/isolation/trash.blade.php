@extends('layouts.admin')

@section('page-title', 'Deleted Isolation Records')

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left">
                <h5>Deleted Isolation Records</h5>
            </div>

            <div class="page-header-right ms-auto">
                <a href="{{ route('admin.isolation.index') }}" class="btn btn-neutral">Back</a>
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

                                                <a href="{{ route('admin.isolation.restore', $record->id) }}"
                                                    class="avatar-text avatar-md action-icon action-restore">
                                                    <i class="feather-refresh-ccw"></i>
                                                </a>

                                                <a href="{{ route('admin.isolation.forceDelete', $record->id) }}"
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
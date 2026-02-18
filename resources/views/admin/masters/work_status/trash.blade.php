@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5>Deleted Work Status</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.work-status.index') }}" class="btn btn-neutral">
                Back
            </a>
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
                                <th>Work Status Name</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($workStatuses as $index => $workStatus)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $workStatus->work_status_name }}</td>
                                <td>
                                    @if($workStatus->status == 'Active')
                                        <span class="badge bg-soft-success text-success">Active</span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <div class="hstack gap-2 justify-content-end">

                                        <a href="{{ route('admin.work-status.restore', $workStatus->id) }}"
                                            class="avatar-text avatar-md action-icon action-restore">
                                            <i class="feather-refresh-ccw"></i>
                                        </a>

                                        <a href="{{ route('admin.work-status.forceDelete', $workStatus->id) }}"
                                            class="avatar-text avatar-md action-icon action-delete"
                                            onclick="return confirm('This will permanently delete the record. Continue?')">
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

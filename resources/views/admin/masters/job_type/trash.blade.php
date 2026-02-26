@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5>Deleted Job Types</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.job-type.index') }}" class="btn btn-neutral">
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
                                <th>Job Type Name</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($jobTypes as $index => $jobType)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $jobType->job_type_name }}</td>
                                <td>
                                    @if($jobType->status == 'Active')
                                        <span class="badge bg-soft-success text-success">Active</span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <div class="hstack gap-2 justify-content-end">

                                        <a href="{{ route('admin.job-type.restore', $jobType->id) }}"
                                            class="avatar-text avatar-md action-icon action-restore">
                                            <i class="feather-refresh-ccw"></i>
                                        </a>

                                        <form action="{{ route('admin.job-type.forceDelete', $jobType->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this job type?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="avatar-text avatar-md action-icon action-delete">
                                                <i class="feather-trash-2"></i>
                                            </button>

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

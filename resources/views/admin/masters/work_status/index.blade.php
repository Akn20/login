@extends('layouts.admin')

@section('content')

 <div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Work Status Master</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item">Work Status</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.work-status.trash') }}" class="btn btn-neutral">
                Deleted Records
            </a>

            <a href="{{ route('admin.work-status.create') }}" class="btn btn-neutral">
                Add Work Status
            </a>
        </div>
    </div>

    <!-- Main Content -->
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
            <th>Code</th>
            <th>Work Status Name</th>
            <th>Description</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($workStatuses as $index => $workStatus)
        <tr>
            <td>{{ $index + 1 }}</td>

            <td>
                <span class="badge bg-soft-primary text-primary">
                    {{ $workStatus->work_status_code }}
                </span>
            </td>

            <td>{{ $workStatus->work_status_name }}</td>

            <td>
                {{ $workStatus->description ?? '-' }}
            </td>

            <td>
                @if($workStatus->status == 'Active')
                    <span class="badge bg-soft-success text-success">Active</span>
                @else
                    <span class="badge bg-soft-danger text-danger">Inactive</span>
                @endif
            </td>

            <td class="text-end">
                <div class="hstack gap-2 justify-content-end">

                    <a href="{{ route('admin.work-status.edit', $workStatus->id) }}"
                       class="avatar-text avatar-md action-icon action-edit">
                        <i class="feather-edit"></i>
                    </a>

                    <a href="{{ route('admin.work-status.delete', $workStatus->id) }}"
                       class="avatar-text avatar-md action-icon action-delete">
                        <i class="feather-trash-2"></i>
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
     </div>

</div>

 @endsection

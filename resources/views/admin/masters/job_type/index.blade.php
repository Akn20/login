@extends('layouts.admin')

@section('content')

<<<<<<< HEAD
    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Job Type Master</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item">Job Type</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.job-type.trash') }}" class="btn btn-neutral">
                    Deleted Records
                </a>

                <a href="{{ route('admin.job-type.create') }}" class="btn btn-neutral">
                    Add Job Type
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
                                            <th>Job Type Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($jobTypes as $index => $jobType)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>

                                                <td>
                                                    <span class="badge bg-soft-primary text-primary">
                                                        {{ $jobType->job_type_code }}
                                                    </span>
                                                </td>

                                                <td>{{ $jobType->job_type_name }}</td>

                                                <td>
                                                    {{ $jobType->description ?? '-' }}
                                                </td>

                                                <td>
                                                    @if($jobType->status == 'Active')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">

                                                        <a href="{{ route('admin.job-type.edit', $jobType->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        <form action="{{ route('admin.job-type.delete', $jobType->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this job type?');">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete"
                                                                title="Delete">
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
=======
<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Job Type Master</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item">Job Type</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.job-type.trash') }}" class="btn btn-neutral">
                Deleted Records
            </a>

            <a href="{{ route('admin.job-type.create') }}" class="btn btn-neutral">
                Add Job Type
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
            <th>Job Type Name</th>
            <th>Description</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($jobTypes as $index => $jobType)
        <tr>
            <td>{{ $index + 1 }}</td>

            <td>
                <span class="badge bg-soft-primary text-primary">
                    {{ $jobType->job_type_code }}
                </span>
            </td>

            <td>{{ $jobType->job_type_name }}</td>

            <td>
                {{ $jobType->description ?? '-' }}
            </td>

            <td>
                @if($jobType->status == 'Active')
                    <span class="badge bg-soft-success text-success">Active</span>
                @else
                    <span class="badge bg-soft-danger text-danger">Inactive</span>
                @endif
            </td>

            <td class="text-end">
                <div class="hstack gap-2 justify-content-end">

<a href="{{ route('admin.job-type.edit', $jobType->id) }}"
                        class="avatar-text avatar-md action-icon action-edit">
                        <i class="feather-edit"></i>
                    </a>

                    <a href="{{ route('admin.job-type.delete', $jobType->id) }}"
                       class="avatar-text avatar-md action-icon action-delete">
                        <i class="feather-trash-2"></i>
                    </a>

                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

>>>>>>> 5f0bf02b24999c4ebcafa7ae518a1d664ac37388
                        </div>
                    </div>
                </div>
            </div>
        </div>
<<<<<<< HEAD

    </div>

@endsection
=======
    </div>

</div>

@endsection
>>>>>>> 5f0bf02b24999c4ebcafa7ae518a1d664ac37388

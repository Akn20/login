@extends('layouts.admin')

@section('page-title', 'Designations | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Designation Master</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item">Designation</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.designation.trash') }}" class="btn btn-neutral">
                    Deleted Records
                </a>

                <a href="{{ route('admin.designation.create') }}" class="btn btn-neutral">
                    Add Designation
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
                                            <th>Designation Name</th>
                                            <th>Department</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($designations as $index => $designation)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>

                                                <td>{{ $designation->designation_code }}</td>

                                                <td>{{ $designation->designation_name }}</td>

                                                <td>{{ $designation->department->department_name ?? '-' }}</td>

                                                <td>{{ $designation->description ?? '-' }}</td>

                                                <td>
                                                    @if($designation->status == 1)
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <a href="{{ route('admin.designation.edit', $designation->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        <form action="{{ route('admin.designation.delete', $designation->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this designation?');">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
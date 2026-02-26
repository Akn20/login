@extends('layouts.admin')

@section('page-title', 'Deleted Designations | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5>Deleted Designations</h5>
                </div>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.designation.index') }}" class="btn btn-neutral">
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
                                            @if($designation->status == 'Active')
                                                <span class="badge bg-soft-success text-success">Active</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <div class="hstack gap-2 justify-content-end">

                                                <a href="{{ route('admin.designation.restore', $designation->id) }}"
                                                    class="avatar-text avatar-md action-icon action-restore">
                                                    <i class="feather-refresh-ccw"></i>
                                                </a>
                                               <form action="{{ route('admin.designation.forceDelete', $designation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this designation?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="avatar-text avatar-md action-icon action-delete">
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

@endsection
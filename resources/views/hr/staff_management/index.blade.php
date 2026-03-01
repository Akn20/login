@extends('layouts.admin')

@section('page-title', 'Staff Management | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Staff Management</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">HR</li>
                    <li class="breadcrumb-item">Staff Management</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('hr.staff-management.deleted') }}" class="btn btn-neutral">
                    Deleted Records
                </a>
                <a href="{{ route('hr.staff-management.create') }}" class="btn btn-neutral">
                    Add Staff
                </a>
            </div>
        </div>

        <div class="main-content">
             @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staffManagements as $i => $staff)
                                            <tr>
                                                <td>{{ $staffManagements->firstItem() + $i }}</td>
                                                <td class="fw-semibold">{{ $staff->employee_id }}</td>
                                                <td>{{ $staff->name }}</td>
                                                <!-- <td>{{ $staff->department->name ?? '-' }}</td>
                                                <td>{{ $staff->designation->name ?? '-' }}</td> -->
                                                <td>{{ $staff->department }}</td>
                                                <td>{{ $staff->designation }}</td>
                                                <td>
                                                    @if($staff->status === 'Active')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <!-- View -->
                                 <a href="{{ route('hr.staff-management.show', $staff->id) }}"
                                         class="avatar-text avatar-md action-icon"
                                            title="View">
                                         <i class="feather-eye"></i>
                                            </a>

                                                        <!-- Edit -->
                                                        <a href="{{ route('hr.staff-management.edit', $staff->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit" title="Edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        <!-- Delete -->
                                                        <form action="{{ route('hr.staff-management.destroy', $staff->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this staff?');">
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
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    No staff records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="mt-3">
                                {{ $staffManagements->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
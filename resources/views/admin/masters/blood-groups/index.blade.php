@extends('layouts.admin')

@section('page-title', 'Blood Groups | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Blood Groups</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item">Blood Groups</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.blood-groups.deleted') }}" class="btn btn-neutral">
                    Deleted Records
                </a>
                <a href="{{ route('admin.blood-groups.create') }}" class="btn btn-neutral">Add Blood Group</a>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Blood Group</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bloodGroups as $i => $bg)
                                            <tr>
                                                <td>{{ $bloodGroups->firstItem() + $i }}</td>
                                                <td class="fw-semibold">{{ $bg->blood_group_name }}</td>
                                                <td>
                                                    @if($bg->status === 'Active')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">

                                                    <!-- Edit -->
                                                    <a href="{{ route('admin.blood-groups.edit', $bg->id) }}"
                                                    class="avatar-text avatar-md action-icon action-edit"
                                                    title="Edit">
                                                        <i class="feather-edit"></i>
                                                    </a>

                                                    <!-- Delete -->
                                                    <form action="{{ route('admin.blood-groups.destroy', $bg->id) }}"
                                                        method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this blood group?');">
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
                                                <td colspan="4" class="text-center py-4">
                                                    No blood groups found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- Pagination --}}
                            <div class="mt-3">
                                {{ $bloodGroups->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
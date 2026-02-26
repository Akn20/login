@extends('layouts.admin')

@section('page-title', 'Deleted Staff | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header d-flex align-items-center justify-content-between">
            <div class="page-header-left">
                <h5 class="mb-0">Deleted Staff</h5>
            </div>
            <div class="page-header-right d-flex gap-2">
                <a href="{{ route('hr.staff-management.index') }}" class="btn btn-neutral">
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
                                    <th>S.No</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Deleted At</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staffs as $i => $staff)
                                    <tr>
                                        <td>{{ $staffs->firstItem() + $i }}</td>
                                        <td>{{ $staff->employee_id }}</td>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ $staff->department->name ?? '-' }}</td>
                                        <td>
                                            @if($staff->status === 'Active')
                                                <span class="badge bg-soft-success text-success">Active</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($staff->deleted_at)->format('d-m-Y H:i') }}</td>

                                        <td class="text-end">
                                            <div class="hstack gap-2 justify-content-end">

                                                {{-- Restore --}}
                                                <form action="{{ route('hr.staff-management.restore', $staff->id) }}"
                                                    method="POST" class="m-0 p-0">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="avatar-text avatar-md action-icon action-restore"
                                                        title="Restore">
                                                        <i class="feather-rotate-ccw"></i>
                                                    </button>
                                                </form>

                                                {{-- Permanent Delete --}}
                                                <form action="{{ route('hr.staff-management.forceDelete', $staff->id) }}"
                                                    method="POST" class="m-0 p-0"
                                                    onsubmit="return confirm('This will permanently delete the record. Continue?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="avatar-text avatar-md action-icon action-delete"
                                                        title="Delete Permanently">
                                                        <i class="feather-trash-2"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            No deleted staff records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="p-3">
                        {{ $staffs->links() }}
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
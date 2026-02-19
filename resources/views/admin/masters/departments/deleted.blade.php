@extends('layouts.admin')

@section('page-title', 'Deleted Departments | ' . config('app.name'))

@section('content')
<div class="nxl-content">

    <div class="page-header d-flex align-items-center justify-content-between mb-4">
        <div>
            <h5 class="mb-0">Deleted Departments</h5>
        </div>

        <a href="{{ route('admin.departments.index') }}" class="btn btn-light">Back to List</a>
    </div>

    
    <div class="main-content">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:80px;">S.No</th>
                                <th>Department Name</th>
                                <th>Department Code</th>
                                <th>Status</th>
                                <th>Deleted At</th>
                                <th class="text-end" style="width:180px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $i => $d)
                                <tr>
                                    <td>{{ $departments->firstItem() + $i }}</td>
                                    <td class="fw-semibold">{{ $d->department_name }}</td>
                                    <td>{{ $d->department_code }}</td>
                                    <td>
                                        @if($d->status)
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($d->deleted_at)->format('d-m-Y H:i') }}</td>

                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">

                                            {{-- Restore --}}
                                                <form action="{{ route('admin.departments.restore', $d->id) }}"
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
                                                <form action="{{ route('admin.departments.forceDelete', $d->id) }}"
                                                method="POST"
                                                class="m-0 p-0"
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
                                    <td colspan="6" class="text-center py-4">No deleted records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $departments->links() }}
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

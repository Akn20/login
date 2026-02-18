@extends('layouts.admin')
@section('page-title', 'Deleted Roles | ' .config('app.name'))
@section('content')
<div class="nxl-content">

    <div class="page-header d-flex align-items-center justify-content-between mb-4">
        <div>
            <h5 class="mb-0">Deleted Roles</h5>
        </div>

        <a href="{{ route('admin.roles.index') }}" class="btn btn-light">
            Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="main-content">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:80px;">S.No</th>
                                <th>Role Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Deleted At</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($roles as $i => $role)

                                <tr>
                                    <td>{{ $roles->firstItem() + $i }}</td>

                                    <td class="fw-semibold">
                                        {{ $role->name }}
                                    </td>

                                    <td>
                                        {{ $role->description ?? '-' }}
                                    </td>

                                    <td>
                                        @if($role->status=='active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ optional($role->deleted_at)->format('d-m-Y H:i') }}
                                    </td>

                                    <td class="text-end">

                                        <div class="d-flex justify-content-end gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('admin.roles.restore', $role->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                    class="avatar-text avatar-md action-icon action-restore"
                                                    title="Restore">
                                                    <i class="feather-rotate-ccw"></i>
                                                </button>
                                            </form>


                                            {{-- Permanent Delete --}}
                                            <form action="{{ route('admin.roles.forceDelete', $role->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('This will permanently delete record. Continue?')">

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
                                    <td colspan="6" class="text-center py-4">
                                        No deleted roles found
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $roles->links() }}
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

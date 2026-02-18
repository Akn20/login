@extends('layouts.admin')
@section('page-title', 'Deleted Users | ' . config('app.name'))
@section('content')
    <div class="nxl-content">

        <div class="page-header d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="mb-0">Deleted Users</h5>
            </div>

            <a href="{{ route('admin.users.index') }}" class="btn btn-light">
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Deleted At</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($users as $i => $user)

                                    <tr>
                                        <td>{{ $users->firstItem() + $i }}</td>

                                        <td class="fw-semibold">
                                            {{ $user->name }}
                                        </td>

                                        <td>
                                            {{ $user->email }}
                                        </td>

                                        <td>
                                            @if($user->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ optional($user->deleted_at)->format('d-m-Y H:i') }}
                                        </td>

                                        <td class="text-end">

                                            <div class="d-flex justify-content-end gap-2">

                                                {{-- Restore --}}
                                                <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit"
                                                        class="avatar-text avatar-md action-icon action-restore"
                                                        title="Restore">
                                                        <i class="feather-rotate-ccw"></i>
                                                    </button>
                                                </form>


                                                {{-- Permanent Delete --}}
                                                <form action="{{ route('admin.users.forceDelete', $user->id) }}" method="POST"
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
                                            No deleted users found
                                        </td>
                                    </tr>

                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
@extends('layouts.admin')

@section('page-title', 'Users | ' . config('app.name'))
@section('title', 'Users')

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex align-items-center w-100">
            <div class="page-header-title">
                <h5 class="m-b-10 mb-1">
                    <i class="feather-users me-2"></i>Users
                </h5>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Users</li>
                </ul>
            </div>

            <div class="ms-auto d-flex gap-2">
                @if (request()->routeIs('admin.users.deleted'))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="feather-users me-1"></i> Active Users
                    </a>
                @else
                    <a href="{{ route('admin.users.deleted') }}" class="btn btn-outline-secondary">
                        <i class="feather-trash-2 me-1"></i> Deleted Users
                    </a>
                @endif

                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="feather-user-plus me-1"></i> Add User
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card stretch stretch-full">
        <div class="card-body">
            @if ($users->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() ? $users->firstItem() + $index : $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ optional($user->role)->name ?? '-' }}</td>
                                    <td>
                                        @include('partials.status-toggle', [
                                            'id'      => $user->id,
                                            'url'     => route('admin.users.toggle-status', $user->id),
                                            'checked' => $user->status === 'active',
                                        ])
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">
                                            @if (request()->routeIs('admin.users.deleted'))
                                                {{-- Restore (on deleted page) --}}
                                                <form
                                                    action="{{ route('admin.users.restore', $user->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Restore this user?')"
                                                >
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-success btn-icon rounded-circle"
                                                        title="Restore"
                                                    >
                                                        <i class="feather-rotate-ccw"></i>
                                                    </button>
                                                </form>

                                                {{-- Force Delete --}}
                                                <form
                                                    action="{{ route('admin.users.forceDelete', $user->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Permanently delete this user?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-danger btn-icon rounded-circle"
                                                        title="Delete Permanently"
                                                    >
                                                        <i class="feather-trash-2"></i>
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Edit (on active page) --}}
                                                <a
                                                    href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-outline-secondary btn-icon rounded-circle"
                                                    title="Edit"
                                                >
                                                    <i class="feather-edit-2"></i>
                                                </a>

                                                {{-- Soft Delete --}}
                                                <form
                                                    action="{{ route('admin.users.destroy', $user->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Delete this user?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-danger btn-icon rounded-circle"
                                                        title="Delete"
                                                    >
                                                        <i class="feather-trash-2"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @else
                <p class="mb-0">No users found.</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function bindUserStatusToggles() {
        const toggles = document.querySelectorAll('.status-toggle-input[data-url*="users"]');

        toggles.forEach(toggle => {
            if (toggle.dataset.bound === '1') return;
            toggle.dataset.bound = '1';

            toggle.addEventListener('change', function () {
                const url     = this.getAttribute('data-url');
                const checked = this.checked;

                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to update status.');
                        this.checked = !checked;
                        return;
                    }

                    const textEl = this.nextElementSibling.querySelector('.status-toggle-text');
                    if (textEl) {
                        textEl.textContent = (data.status === 'active' || data.is_active)
                            ? 'Active'
                            : 'Inactive';
                    }
                })
                .catch(() => {
                    alert('Failed to update status.');
                    this.checked = !checked;
                });
            });
        });
    }

    bindUserStatusToggles();
});
</script>
@endpush

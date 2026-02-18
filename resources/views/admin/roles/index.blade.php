@extends('layouts.admin')

@section('page-title', 'Roles | ' . config('app.name'))
@section('title', 'Roles')

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex align-items-center w-100">
            <div class="page-header-title">
                <h5 class="m-b-10 mb-1">
                    <i class="feather-shield me-2"></i>Roles
                </h5>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Roles</li>
                </ul>
            </div>

            <div class="ms-auto d-flex gap-2">
                @if (request()->routeIs('admin.roles.deleted'))
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                        <i class="feather-shield me-1"></i> Active Roles
                    </a>
                @else
                    <a href="{{ route('admin.roles.deleted') }}" class="btn btn-outline-secondary">
                        <i class="feather-trash-2 me-1"></i> Deleted Roles
                    </a>
                @endif

                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-1"></i> Add Role
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
            @if ($roles->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $index => $role)
                                <tr>
                                    <td>{{ $roles->firstItem() ? $roles->firstItem() + $index : $index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description ?? '-' }}</td>
                                    <td>
                                        @include('partials.status-toggle', [
                                            'id'      => $role->id,
                                            'url'     => route('admin.roles.toggle-status', $role->id),
                                            'checked' => $role->status === 'active',
                                        ])
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">
                                            @if (request()->routeIs('admin.roles.deleted'))
                                                {{-- Restore on deleted page --}}
                                                <form
                                                    action="{{ route('admin.roles.restore', $role->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Restore this role?')"
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
                                                    action="{{ route('admin.roles.forceDelete', $role->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Permanently delete this role?')"
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
                                                {{-- Edit on active page --}}
                                                <a
                                                    href="{{ route('admin.roles.edit', $role->id) }}"
                                                    class="btn btn-outline-primary btn-icon rounded-circle"
                                                    title="Edit"
                                                >
                                                    <i class="feather-edit-2"></i>
                                                </a>

                                                {{-- Soft Delete --}}
                                                <form
                                                    action="{{ route('admin.roles.destroy', $role->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Delete this role?')"
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
                    {{ $roles->links() }}
                </div>
            @else
                <p class="mb-0">No roles found.</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function bindRoleStatusToggles() {
        const toggles = document.querySelectorAll('.status-toggle-input[data-url*="roles"]');

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

    bindRoleStatusToggles();
});
</script>
@endpush

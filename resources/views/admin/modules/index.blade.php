@extends('layouts.admin')

@section('page-title', 'Modules | ' . config('app.name'))
@section('title', 'Modules')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-grid me-2"></i>Modules
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Modules</li>
            </ul>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <form method="GET" action="{{ route('admin.modules.index') }}" class="d-flex">
                <input
                    type="text"
                    name="search"
                    class="form-control form-control-sm me-2"
                    placeholder="Search Module"
                    value="{{ request('search') }}"
                >
                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
            </form>

            <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
                <i class="feather-plus me-1"></i> Add Module
            </a>

            <a href="{{ route('admin.modules.deleted') }}" class="btn btn-danger">
                Deleted Modules
            </a>
        </div>
    </div>

    {{-- Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card mini-stat">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-1">Total Modules</h6>
                    <h3 class="mb-0 text-primary" id="total-modules-count">{{ $totalModules }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mini-stat">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-1">Active Modules</h6>
                    <h3 class="mb-0 text-success" id="active-modules-count">{{ $activeModules }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mini-stat">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-1">Inactive Modules</h6>
                    <h3 class="mb-0 text-danger" id="inactive-modules-count">{{ $inactiveModules }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card stretch stretch-full">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Module Label</th>
                            <th>Display Name</th>
                            <th>Parent</th>
                            <th>File Path</th>
                            <th>Access For</th>
                            <th>Page Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($modules->count())
                            @foreach ($modules as $index => $module)
                                <tr>
                                    <td>{{ $modules->firstItem() ? $modules->firstItem() + $index : $index + 1 }}</td>
                                    <td>{{ $module->module_label }}</td>
                                    <td>{{ $module->module_display_name }}</td>
                                    <td>{{ $module->parent_module ?? '-' }}</td>
                                    <td>{{ $module->file_url }}</td>
                                    <td>{{ ucfirst($module->access_for) }}</td>
                                    <td>{{ $module->page_name }}</td>
                                    <td>{{ ucfirst($module->type) }}</td>
                                    <td>
                                        @include('partials.status-toggle', [
                                            'id'      => $module->id,
                                            'url'     => route('admin.modules.toggleStatus', $module->id),
                                            'checked' => (bool) $module->status,
                                        ])
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">
                                            <a
                                                href="{{ route('admin.modules.show', $module->id) }}"
                                                class="btn btn-outline-secondary btn-icon rounded-circle"
                                                title="View"
                                            >
                                                <i class="feather-eye"></i>
                                            </a>

                                            <a
                                                href="{{ route('admin.modules.edit', $module->id) }}"
                                                class="btn btn-outline-secondary btn-icon rounded-circle"
                                                title="Edit"
                                            >
                                                <i class="feather-edit-2"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.modules.destroy', $module->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Delete this module?')"
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
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center">No Modules Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($modules->hasPages())
                <div class="mt-3 px-3 pb-3">
                    {{ $modules->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.status-toggle-input[data-url*="modules"]');

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
                    textEl.textContent =
                        (data.status === 'active' || data.is_active || data.status === 1)
                            ? 'Active'
                            : 'Inactive';
                }

                const totalEl    = document.getElementById('total-modules-count');
                const activeEl   = document.getElementById('active-modules-count');
                const inactiveEl = document.getElementById('inactive-modules-count');

                if (totalEl && typeof data.totalModules !== 'undefined') {
                    totalEl.textContent = data.totalModules;
                }
                if (activeEl && typeof data.activeModules !== 'undefined') {
                    activeEl.textContent = data.activeModules;
                }
                if (inactiveEl && typeof data.inactiveModules !== 'undefined') {
                    inactiveEl.textContent = data.inactiveModules;
                }
            })
            .catch(() => {
                alert('Failed to update status.');
                this.checked = !checked;
            });
        });
    });
});
</script>
@endpush

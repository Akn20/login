@extends('layouts.admin')

@section('page-title', 'Weekend Configurations | ' . config('app.name'))
@section('title', 'Weekend Configurations')

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
                <i class="feather-calendar me-2"></i>Weekend Configurations
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Weekend Configurations</li>
            </ul>
        </div>

        <div class="d-flex gap-2 align-items-center">
            {{-- Filter: status + search --}}
            <form method="GET" action="{{ route('admin.weekends.index') }}" class="d-flex">
                <select
                    name="status"
                    class="form-control form-control-sm me-2"
                >
                    <option value="">All Status</option>
                    <option value="active"   {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <input
                    type="text"
                    name="search"
                    class="form-control form-control-sm me-2"
                    placeholder="Search Configuration"
                    value="{{ request('search') }}"
                >

                <button class="btn btn-light-brand btn-sm">
                    <i class="feather-search"></i>
                </button>
            </form>

            <a href="{{ route('admin.weekends.create') }}" class="btn btn-primary">
                <i class="feather-plus me-1"></i> Add Weekend
            </a>

            <a href="{{ route('admin.weekends.deleted') }}" class="btn btn-danger">
                Deleted Weekends
            </a>
        </div>
    </div>

    <div class="card stretch stretch-full">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Configuration Name</th>
                            <th>Selected Days</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($weekends->count())
                            @foreach ($weekends as $index => $weekend)
                                <tr>
                                    <td>{{ $weekends->firstItem() ? $weekends->firstItem() + $index : $index + 1 }}</td>

                                    <td>{{ $weekend->name }}</td>

                                    <td>
                                        @php
                                            $days = is_array($weekend->days)
                                                ? $weekend->days
                                                : (json_decode($weekend->days, true) ?? []);
                                        @endphp
                                        {{ $days ? implode(', ', $days) : '-' }}
                                    </td>

                                    <td>
                                        @include('partials.status-toggle', [
                                            'id'      => $weekend->id,
                                            'url'     => route('admin.weekends.toggleStatus', $weekend->id),
                                            'checked' => $weekend->status === 'active',
                                        ])
                                    </td>

                                    <td>{{ $weekend->created_at?->format('d-m-Y H:i') }}</td>

                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">
                                            
                                            <a
                                                href="{{ route('admin.weekends.edit', $weekend->id) }}"
                                                class="btn btn-outline-secondary btn-icon rounded-circle"
                                                title="Edit"
                                            >
                                                <i class="feather-edit-2"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.weekends.delete', $weekend->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Move weekend configuration to trash?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip"
                                                    title="Trash"
                                                >
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No Weekend Configurations Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($weekends->hasPages())
                <div class="mt-3 px-3 pb-3">
                    {{ $weekends->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.status-toggle-input[data-url*="weekends"]');

    toggles.forEach(toggle => {
        if (toggle.dataset.bound === '1') return;
        toggle.dataset.bound = '1';

        toggle.addEventListener('change', function () {
            // if already loading, ignore this change
            if (this.dataset.loading === '1') {
                // revert visual change because we are ignoring this click
                this.checked = !this.checked;
                return;
            }

            const url     = this.getAttribute('data-url');
            const checked = this.checked;

            this.dataset.loading = '1';
            this.disabled = true;

            const textEl = this.nextElementSibling.querySelector('.status-toggle-text');
            const prevText = textEl ? textEl.textContent : '';

            if (textEl) textEl.textContent = '...';

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
                    if (textEl) textEl.textContent = prevText;
                    return;
                }

                if (textEl) {
                    textEl.textContent =
                        (data.status === 'active' || data.is_active || data.status === 1)
                            ? 'Active'
                            : 'Inactive';
                }
            })
            .catch(() => {
                alert('Failed to update status.');
                this.checked = !checked;
                if (textEl) textEl.textContent = prevText;
            })
            .finally(() => {
                this.disabled = false;
                this.dataset.loading = '0';
            });
        });
    });
});
</script>
@endpush


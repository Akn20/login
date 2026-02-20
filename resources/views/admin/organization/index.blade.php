@extends('layouts.admin')

@section('page-title', 'Organizations | ' . config('app.name'))
@section('title', 'Organizations')

@section('content')
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-plus-square me-2"></i>Organizations
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Organizations</li>
            </ul>
        </div>

        <div class="d-flex gap-2">
            {{-- Add --}}
            <a href="{{ route('admin.organization.create') }}" class="btn btn-primary btn-sm">
                <i class="feather-plus me-1"></i> Add Organization
            </a>

            {{-- Deleted --}}
            <a href="{{ route('admin.organization.deleted') }}" class="btn btn-danger btn-sm">
                Deleted Organizations
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card stretch stretch-full">
        <div class="card-body custom-card-action p-0">

            {{-- Search bar --}}
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <form method="GET" action="{{ route('admin.organization.index') }}" class="d-flex">
                    <input type="text"
                           name="search"
                           class="form-control form-control-sm me-2"
                           placeholder="Search Organization"
                           value="{{ request('search') }}">
                    <button class="btn btn-light-brand btn-sm">
                        <i class="feather-search"></i>
                    </button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr class="border-b">
                            <th>Sl.No</th>
                            <th>Organization Name</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($organizations as $index => $org)
                            <tr>
                                <td>{{ $organizations->firstItem() ? $organizations->firstItem() + $index : $index + 1 }}</td>

                                <td>
                                    <div class="fw-bold">{{ $org->name }}</div>
                                    <small class="text-muted">{{ $org->city }}</small>
                                </td>

                                <td>{{ $org->type }}</td>

                                <td>{{ $org->email }}</td>

                                <td>
                                    <span class="badge bg-soft-primary text-primary">
                                        {{ $org->plan_type }}
                                    </span>
                                </td>

                                <td>
                                    @include('partials.status-toggle', [
                                        'id'      => $org->id,
                                        'url'     => route('admin.organization.toggleStatus', $org->id),
                                        'checked' => (bool) $org->status,
                                    ])
                                </td>

                                <td class="text-end">
                                    <div class="hstack gap-2 justify-content-end">

                                        {{-- View --}}
                                        <a href="{{ route('admin.organization.show', $org->id) }}"
                                           class="avatar-text avatar-md" data-bs-toggle="tooltip" title="View">
                                            <i class="feather feather-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.organization.edit', $org->id) }}"
                                           class="avatar-text avatar-md" data-bs-toggle="tooltip" title="Edit">
                                            <i class="feather feather-edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.organization.destroy', $org->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this organization?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" title="Delete">
                                                <i class="feather feather-trash-2"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center p-4">
                                    No Organizations Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div class="card-footer">
            {{ $organizations->links() }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.status-toggle-input[data-url*="organization"]');

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
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                if (!data.success) {
                    alert('Failed to update status.');
                    this.checked = !checked;
                    return;
                }

                const textEl = this.parentElement.querySelector('.status-toggle-text');
                if (textEl) {
                    const active = (data.status === 'active' || data.is_active);
                    textEl.textContent = active ? 'Active' : 'Inactive';
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

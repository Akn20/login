@extends('layouts.admin')

@section('page-title', 'Staff Management | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Staff Management</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">HR</li>
                    <li class="breadcrumb-item">Staff Management</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('hr.staff-management.deleted') }}" class="btn btn-neutral">
                    Deleted Records
                </a>
                <a href="{{ route('hr.staff-management.create') }}" class="btn btn-neutral">
                    Add Staff
                </a>
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
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Department</th>
                                            <th>Date Joined</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staffManagements as $i => $staff)
                                            <tr>
                                                {{-- S.No --}}
                                                <td>{{ $staffManagements->firstItem() + $i }}</td>

                                                {{-- Employee ID --}}
                                                <td class="fw-semibold">
                                                    {{ $staff->employee_id ?? '-' }}
                                                </td>

                                                {{-- Name --}}
                                                <td>{{ $staff->name }}</td>

                                                {{-- Role --}}
                                                <td>{{ $staff->role ?? '-' }}</td>

                                                {{-- Department --}}
                                                <td>{{ $staff->department ?? '-' }}</td>

                                                {{-- Date Joined --}}
                                                <td>
                                                    @if($staff->joining_date)
                                                        {{ \Carbon\Carbon::parse($staff->joining_date)->format('d-m-Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- Status toggle --}}
                                                <td>
                                                    @include('partials.status-toggle', [
                                                        'id'      => $staff->id,
                                                        'url'     => route('hr.staff-management.toggleStatus', $staff->id),
                                                        'checked' => $staff->status === 'active' || $staff->status === 'Active',
                                                    ])
                                                </td>

                                                {{-- Actions --}}
                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">

                                                        {{-- Edit --}}
                                                        <a href="{{ route('hr.staff-management.edit', $staff->id) }}"
                                                           class="avatar-text avatar-md action-icon action-edit"
                                                           title="Edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        {{-- Delete (AJAX) --}}
                                                        <form action="{{ route('hr.staff-management.destroy', $staff->id) }}"
                                                              method="POST"
                                                              class="d-inline"
                                                              data-ajax="staff-delete">
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
                                                <td colspan="8" class="text-center py-4">
                                                    No staff records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="mt-3">
                                {{ $staffManagements->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle status via AJAX
    function bindStaffStatusToggles() {
        const toggles = document.querySelectorAll('.status-toggle-input[data-url*="staff-management"]');

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
                            (data.status === 'active' || data.status === 'Active')
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

    bindStaffStatusToggles();

    // AJAX delete without reload
    document.querySelectorAll('form[data-ajax="staff-delete"]').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!confirm('Delete this staff?')) return;

            const row    = this.closest('tr');
            const action = this.getAttribute('action');

            fetch(action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: new URLSearchParams(new FormData(this)),
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert('Failed to delete staff.');
                    return;
                }
                if (row) row.remove();
            })
            .catch(() => {
                alert('Failed to delete staff.');
            });
        });
    });
});
</script>
@endpush

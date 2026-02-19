@extends('layouts.admin')

@section('page-title', 'Hospitals | ' . config('app.name'))
@section('title', 'Hospitals')

@section('content')
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-title">
        <h5 class="m-b-10 mb-1">
            <i class="feather-plus-square me-2"></i>Hospitals
        </h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Hospitals</li>
        </ul>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.hospitals.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Hospital
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

{{-- Light cards, only numbers colored --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card mini-stat">
            <div class="card-body">
                <h6 class="text-uppercase text-muted mb-1">Total Hospitals</h6>
                <h3 class="mb-0 text-primary" id="total-hospitals-count">{{ $totalHospitals }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mini-stat">
            <div class="card-body">
                <h6 class="text-uppercase text-muted mb-1">Active Hospitals</h6>
                <h3 class="mb-0 text-success" id="active-hospitals-count">{{ $activeHospitals }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mini-stat">
            <div class="card-body">
                <h6 class="text-uppercase text-muted mb-1">Inactive Hospitals</h6>
                <h3 class="mb-0 text-danger" id="inactive-hospitals-count">{{ $inactiveHospitals }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card stretch stretch-full">
    <div class="card-body">
        @if ($hospitals->count())
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hospital</th>
                            <th>Code</th>
                            <th>Institution</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hospitals as $index => $hospital)
                            <tr>
                                <td>{{ $hospitals->firstItem() ? $hospitals->firstItem() + $index : $index + 1 }}</td>
                                <td>{{ $hospital->name }}</td>
                                <td>{{ $hospital->code }}</td>
                                <td>{{ optional($hospital->institution)->name ?? '-' }}</td>
                                <td>{{ $hospital->contact_number }}</td>
                                <td>
                                    @include('partials.status-toggle', [
                                        'id'      => $hospital->id,
                                        'url'     => route('admin.hospitals.toggle-status', $hospital->id),
                                        'checked' => (bool) $hospital->status,
                                    ])
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2 align-items-center">
                                        <a
                                            href="{{ route('admin.hospitals.edit', $hospital->id) }}"
                                            class="btn btn-outline-secondary btn-icon rounded-circle"
                                            title="Edit"
                                        >
                                            <i class="feather-edit-2"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.hospitals.destroy', $hospital->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this hospital?')"
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
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $hospitals->links() }}
            </div>
        @else
            <p class="mb-0">No hospitals found.</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.status-toggle-input[data-url*="hospitals"]');

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

                // Toggle label text
                const textEl = this.nextElementSibling.querySelector('.status-toggle-text');
                if (textEl) {
                    textEl.textContent = (data.status === 'active' || data.is_active || data.status === 1)
                        ? 'Active'
                        : 'Inactive';
                }

                // Update cards in real time
                const totalEl    = document.getElementById('total-hospitals-count');
                const activeEl   = document.getElementById('active-hospitals-count');
                const inactiveEl = document.getElementById('inactive-hospitals-count');

                if (totalEl && typeof data.totalHospitals !== 'undefined') {
                    totalEl.textContent = data.totalHospitals;
                }
                if (activeEl && typeof data.activeHospitals !== 'undefined') {
                    activeEl.textContent = data.activeHospitals;
                }
                if (inactiveEl && typeof data.inactiveHospitals !== 'undefined') {
                    inactiveEl.textContent = data.inactiveHospitals;
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

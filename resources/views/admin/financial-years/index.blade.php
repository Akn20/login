@extends('layouts.admin')

@section('page-title', 'Financial Years | ' . config('app.name'))
@section('title', 'Financial Years')

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex align-items-center w-100">
            <div class="page-header-title">
                <h5 class="m-b-10 mb-1">
                    <i class="feather-calendar me-2"></i>Financial Years
                </h5>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Financial Years</li>
                </ul>
            </div>

            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('admin.financial-years.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-1"></i> Add Financial Year
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

            {{-- Filters (always visible) --}}
            <form id="fy-filter-form" class="row g-2 align-items-end mb-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select" id="is_active">
                        <option value="" {{ request('is_active') === null ? 'selected' : '' }}>All</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Year (start year)</label>
                    <select name="start_year" class="form-select" id="start_year">
                        <option value="" {{ request('start_year') === null ? 'selected' : '' }}>All</option>
                        @for ($year = date('Y'); $year >= 2020; $year--)
                            <option
                                value="{{ $year }}"
                                {{ (string) request('start_year') === (string) $year ? 'selected' : '' }}
                            >
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" id="reset-filters" class="btn btn-light">
                        Reset
                    </button>
                </div>
            </form>

            {{-- Table wrapper that will be replaced via AJAX --}}
            <div id="fy-table-wrapper">
                @if ($financialYears->count())
                    <p class="mb-2">
                        Showing {{ $financialYears->firstItem() }} to {{ $financialYears->lastItem() }}
                        of {{ $financialYears->total() }} entries
                    </p>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($financialYears as $index => $fy)
                                    <tr>
                                        <td>{{ $financialYears->firstItem() + $index }}</td>
                                        <td>{{ $fy->code }}</td>
                                        <td>{{ $fy->start_date->format('d-m-Y') }}</td>
                                        <td>{{ $fy->end_date->format('d-m-Y') }}</td>
                                        <td>
                                            @include('partials.status-toggle', [
                                                'id'      => $fy->id,
                                                'url'     => route('admin.financial-years.toggle-status', $fy->id),
                                                'checked' => $fy->is_active,
                                            ])
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                                <a
                                                    href="{{ route('admin.financial-years.edit', $fy->id) }}"
                                                    class="btn btn-outline-secondary btn-icon rounded-circle"
                                                    title="Edit"
                                                >
                                                    <i class="feather-edit-2"></i>
                                                </a>

                                                <form
                                                    action="{{ route('admin.financial-years.destroy', $fy->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this financial year?');"
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
                        {{ $financialYears->appends(request()->query())->links() }}
                    </div>
                @else
                    <p class="mb-0">No financial years found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const status       = document.getElementById('is_active');
    const startYearEl  = document.getElementById('start_year');
    const tableWrapper = document.getElementById('fy-table-wrapper');
    const resetBtn     = document.getElementById('reset-filters');

    function buildUrl(pageUrl = null) {
        const params = new URLSearchParams();

        if (status.value !== '') {
            params.append('is_active', status.value);
        }
        if (startYearEl.value !== '') {
            params.append('start_year', startYearEl.value);
        }

        if (pageUrl) {
            const separator = pageUrl.includes('?') ? '&' : '?';
            return pageUrl + separator + params.toString();
        }

        return "{{ route('admin.financial-years.index') }}" + '?' + params.toString();
    }

    function fetchData(pageUrl = null) {
        const url = buildUrl(pageUrl);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser    = new DOMParser();
            const doc       = parser.parseFromString(html, 'text/html');
            const newWrapper = doc.querySelector('#fy-table-wrapper');

            if (newWrapper) {
                tableWrapper.innerHTML = newWrapper.innerHTML;
                bindPaginationLinks();
                bindStatusToggles();
            }
        })
        .catch(() => {
            alert('Failed to load data.');
        });
    }

    function bindPaginationLinks() {
        const links = tableWrapper.querySelectorAll('.pagination a');
        links.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                fetchData(this.getAttribute('href'));
            });
        });
    }

    function bindStatusToggles() {
        const toggles = tableWrapper.querySelectorAll('.status-toggle-input');

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
                        textEl.textContent = data.is_active ? 'Active' : 'Inactive';
                    }
                })
                .catch(() => {
                    alert('Failed to update status.');
                    this.checked = !checked;
                });
            });
        });
    }

    // initial bindings
    bindPaginationLinks();
    bindStatusToggles();

    // Auto-fetch on filter change
    status.addEventListener('change', function () {
        fetchData();
    });

    startYearEl.addEventListener('change', function () {
        fetchData();
    });

    // Reset without full reload
    resetBtn.addEventListener('click', function () {
        status.value      = '';
        startYearEl.value = '';
        fetchData();
    });
});
</script>
@endpush

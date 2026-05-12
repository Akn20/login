@extends('layouts.admin')

@section('page-title', 'Payroll Deductions | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Payroll Deductions</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">HR</li>
                    <li class="breadcrumb-item">Payroll</li>
                    <li class="breadcrumb-item">Deductions</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('hr.payroll.deduction.create') }}" class="btn btn-neutral">
                    Add Deduction
                </a>
                <a href="{{ route('hr.payroll.deduction.deleted') }}" class="btn btn-outline-danger">
                    Deleted Records
                </a>
            </div>
        </div>

        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">

                        <div class="card-header border-bottom px-4 py-3">
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-5 col-md-12">
                                    <label for="searchInput" class="form-label fw-semibold mb-2">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="feather-search text-muted"></i>
                                        </span>
                                        <input type="text" id="searchInput" class="form-control border-start-0"
                                            placeholder="Search by display name, code, description, policy..."
                                            value="{{ request('search') }}">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label for="statusFilter" class="form-label fw-semibold mb-2">Status</label>
                                    <select id="statusFilter" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="INACTIVE" {{ request('status') == 'INACTIVE' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label for="natureFilter" class="form-label fw-semibold mb-2">Nature</label>
                                    <select id="natureFilter" class="form-select">
                                        <option value="">All Nature</option>
                                        <option value="FIXED" {{ request('nature') == 'FIXED' ? 'selected' : '' }}>
                                            Fixed
                                        </option>
                                        <option value="VARIABLE" {{ request('nature') == 'VARIABLE' ? 'selected' : '' }}>
                                            Variable
                                        </option>
                                    </select>
                                </div>

                                <div class="col-lg-1 col-md-12">
                                    <button type="button" id="clearFilters" class="btn btn-light w-200">
                                        Clear
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Display Name</th>
                                            <th>Nature</th>
                                            <th>Category</th>
                                            <th>Prorata</th>
                                            <th>Policy</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="deductionTableBody">
                                        @forelse($deductions as $i => $deduction)
                                            <tr>
                                                <td>{{ $deductions->firstItem() + $i }}</td>
                                                <td class="fw-semibold">{{ $deduction->display_name }}</td>
                                                <td>{{ $deduction->nature === 'FIXED' ? 'Fixed' : 'Variable' }}</td>
                                                <td>
                                                    @if($deduction->category === 'RECURRING')
                                                        Recurring
                                                    @else
                                                        Ad-hoc (One-time)
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($deduction->prorata_applicable === 'YES')
                                                        <span class="badge bg-soft-success text-success">Yes</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">No</span>
                                                    @endif
                                                </td>
                                                <td>{{ $deduction->rule_set_code ?? '-' }}</td>
                                                <td>
                                                    @if($deduction->status === 'ACTIVE')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <a href="{{ route('hr.payroll.deduction.show', $deduction->id) }}"
                                                            class="avatar-text avatar-md action-icon" title="View">
                                                            <i class="feather-eye"></i>
                                                        </a>

                                                        <a href="{{ route('hr.payroll.deduction.edit', $deduction->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit" title="Edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                      <form action="{{ route('hr.payroll.deduction.destroy', $deduction->id) }}"
                        method="POST"
                        class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this deduction?');">

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
                                                    No deduction records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="px-4 py-3 border-top" id="paginationWrapper">
                                {{ $deductions->withQueryString()->links() }}
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
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const natureFilter = document.getElementById('natureFilter');
            const clearFilters = document.getElementById('clearFilters');
            const tableBody = document.getElementById('deductionTableBody');
            const paginationWrapper = document.getElementById('paginationWrapper');

            const showBaseUrl = "{{ url('hr/payroll/deduction') }}";
            const editBaseUrl = "{{ url('hr/payroll/deduction') }}";
            const deleteBaseUrl = "{{ url('hr/payroll/deduction') }}";
            const csrfToken = "{{ csrf_token() }}";

            let debounceTimer;

            function escapeHtml(value) {
                if (value === null || value === undefined) return '';
                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function buildUrl(page = 1) {
                const url = new URL("{{ route('hr.payroll.deduction.index') }}", window.location.origin);

                const search = searchInput.value.trim();
                const status = statusFilter.value;
                const nature = natureFilter.value;

                if (search) url.searchParams.set('search', search);
                if (status) url.searchParams.set('status', status);
                if (nature) url.searchParams.set('nature', nature);
                if (page) url.searchParams.set('page', page);

                return url.toString();
            }

            function renderRows(items, from) {
                if (!items.length) {
                    tableBody.innerHTML = `
                                            <tr>
                                                <td colspan="8" class="text-center py-4">No deduction records found.</td>
                                            </tr>
                                        `;
                    return;
                }

                tableBody.innerHTML = items.map((item, index) => {
                    const serial = (from || 1) + index;
                    const natureText = item.nature === 'FIXED' ? 'Fixed' : 'Variable';
                    const categoryText = item.category === 'RECURRING' ? 'Recurring' : 'Ad-hoc (One-time)';
                    const prorataBadge = item.prorata_applicable === 'YES'
                        ? '<span class="badge bg-soft-success text-success">Yes</span>'
                        : '<span class="badge bg-soft-danger text-danger">No</span>';
                    const statusBadge = item.status === 'ACTIVE'
                        ? '<span class="badge bg-soft-success text-success">Active</span>'
                        : '<span class="badge bg-soft-danger text-danger">Inactive</span>';
                    const policy = item.rule_set_code ? escapeHtml(item.rule_set_code) : '-';

                    return `
                                            <tr>
                                                <td>${serial}</td>
                                                <td class="fw-semibold">${escapeHtml(item.display_name)}</td>
                                                <td>${natureText}</td>
                                                <td>${categoryText}</td>
                                                <td>${prorataBadge}</td>
                                                <td>${policy}</td>
                                                <td>${statusBadge}</td>
                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <a href="${showBaseUrl}/${item.id}/show"
                                                           class="avatar-text avatar-md action-icon" title="View">
                                                            <i class="feather-eye"></i>
                                                        </a>

                                                        <a href="${editBaseUrl}/${item.id}/edit"
                                                           class="avatar-text avatar-md action-icon action-edit" title="Edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        <form action="${deleteBaseUrl}/${item.id}"
                                                              method="POST"
                                                              class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this deduction?');">
                                                            <input type="hidden" name="_token" value="${csrfToken}">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit"
                                                                    class="avatar-text avatar-md action-icon action-delete"
                                                                    title="Delete">
                                                                <i class="feather-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                }).join('');

                if (window.feather) {
                    feather.replace();
                }
            }

            function renderPagination(meta) {
                if (!meta || meta.last_page <= 1) {
                    paginationWrapper.innerHTML = '';
                    return;
                }

                let html = '<nav><ul class="pagination justify-content-end mb-0">';

                const prevDisabled = meta.current_page === 1 ? ' disabled' : '';
                html += `
                                        <li class="page-item${prevDisabled}">
                                            <a class="page-link" href="#" data-page="${meta.current_page - 1}">‹</a>
                                        </li>
                                    `;

                for (let page = 1; page <= meta.last_page; page++) {
                    const active = page === meta.current_page ? ' active' : '';
                    html += `
                                            <li class="page-item${active}">
                                                <a class="page-link" href="#" data-page="${page}">${page}</a>
                                            </li>
                                        `;
                }

                const nextDisabled = meta.current_page === meta.last_page ? ' disabled' : '';
                html += `
                                        <li class="page-item${nextDisabled}">
                                            <a class="page-link" href="#" data-page="${meta.current_page + 1}">›</a>
                                        </li>
                                    `;

                html += '</ul></nav>';
                paginationWrapper.innerHTML = html;
            }

            async function fetchDeductions(page = 1) {
                const url = buildUrl(page);

                tableBody.style.opacity = '0.6';
                paginationWrapper.style.opacity = '0.6';

                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to fetch deductions');
                    }

                    const result = await response.json();

                    renderRows(result.data.data, result.data.from);
                    renderPagination(result.data);

                    window.history.replaceState({}, '', url);
                } catch (error) {
                    console.error('Fetch error:', error);
                } finally {
                    tableBody.style.opacity = '1';
                    paginationWrapper.style.opacity = '1';
                }
            }

            function debounceFetch() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchDeductions(1);
                }, 300);
            }

            searchInput.addEventListener('input', debounceFetch);
            statusFilter.addEventListener('change', () => fetchDeductions(1));
            natureFilter.addEventListener('change', () => fetchDeductions(1));

            clearFilters.addEventListener('click', function () {
                searchInput.value = '';
                statusFilter.value = '';
                natureFilter.value = '';
                fetchDeductions(1);
            });

            paginationWrapper.addEventListener('click', function (e) {
                const link = e.target.closest('a[data-page]');
                if (!link) return;

                e.preventDefault();
                const page = parseInt(link.dataset.page, 10);

                if (!isNaN(page) && page > 0) {
                    fetchDeductions(page);
                }
            });
        });
    </script>
@endpush
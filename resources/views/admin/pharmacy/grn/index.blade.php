@extends('layouts.admin')

@section('title', 'GRN')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Goods Receipt Note (GRN)</h4>
            <small class="text-muted">Pharmacy → GRN</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.grn.trash') }}" class="btn btn-danger">
                <i class="feather-trash"></i> Trash
            </a>

            <a href="{{ route('admin.grn.create') }}" class="btn btn-primary">
                <i class="feather-plus"></i> Create GRN
            </a>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.grn.index') }}">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Vendor</label>
                        <select class="form-select" name="vendor">
                            <option value="">All Vendors</option>
                            @foreach($vendors as $v)
                                <option value="{{ $v }}" {{ request('vendor') == $v ? 'selected' : '' }}>
                                    {{ $v }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">All</option>
                            @foreach(['Draft','Submitted','Verified','Completed','Rejected'] as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 d-flex justify-content-end align-items-end gap-2">
                        <a href="{{ route('admin.grn.index') }}" class="btn btn-light">
                            <i class="feather-rotate-ccw"></i> Reset
                        </a>

                        <button type="submit" class="btn btn-success">
                            <i class="feather-filter"></i> Apply Filters
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">SL</th>
                        <th>GRN No</th>
                        <th>Vendor</th>
                        <th>Invoice No</th>
                        <th>Date</th>
                        <th class="text-end">Total (₹)</th>
                        <th>Status</th>
                        <th class="text-center" style="width:220px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($grns as $index => $g)

                    @php
                        $status = $g->status ?? 'Draft';

                        $badge = match($status) {
                            'Draft' => 'secondary',
                            'Submitted' => 'warning',
                            'Verified' => 'info',
                            'Completed' => 'success',
                            'Rejected' => 'danger',
                            default => 'dark'
                        };
                    @endphp

                    <tr>
                        {{-- If paginate: use firstItem() for correct SL --}}
                        <td>
                            {{ method_exists($grns, 'firstItem') ? ($grns->firstItem() + $index) : ($index + 1) }}
                        </td>

                        <td class="fw-semibold">{{ $g->grn_no ?? ('GRN-'.$g->id) }}</td>
                        <td>{{ $g->vendor_name ?? '-' }}</td>
                        <td>{{ $g->invoice_no ?? '-' }}</td>
                        <td>{{ $g->grn_date ?? '-' }}</td>
                        <td class="text-end">
                            {{ number_format((float)($g->grand_total ?? $g->total_amount ?? 0), 2) }}
                        </td>

                        <td>
                            <span class="badge bg-{{ $badge }} status-badge">
                                {{ $status }}
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="grn-action">
                            <div class="d-inline-flex align-items-center justify-content-center gap-2 action-wrap">

                                {{-- VIEW (always) --}}
                                <a href="{{ route('admin.grn.show', $g->id) }}"
                                class="btn btn-light btn-icon rounded-circle action-btn"
                                title="View">
                                    <i class="feather-eye text-dark"></i>
                                </a>

                                {{-- DRAFT -> Edit + Delete --}}
                                @if($status === 'Draft')
                                    <a href="{{ route('admin.grn.edit', $g->id) }}"
                                    class="btn btn-light btn-icon rounded-circle action-btn"
                                    title="Edit">
                                        <i class="feather-edit text-primary"></i>
                                    </a>

                                    <form action="{{ route('admin.grn.destroy', $g->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-light btn-icon rounded-circle action-btn"
                                                title="Delete"
                                                onclick="return confirm('Move this GRN to Trash?')">
                                            <i class="feather-trash text-danger"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- SUBMITTED -> Verify only --}}
                                @if($status === 'Submitted')
                                    <a href="{{ route('admin.grn.verify', $g->id) }}"
                                    class="btn btn-light btn-icon rounded-circle action-btn"
                                    title="Verify">
                                        <i class="feather-check-circle text-success"></i>
                                    </a>
                                @endif


                            </div>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            No GRNs found.
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

            {{-- Pagination (if controller uses paginate) --}}
            @if(method_exists($grns, 'links'))
                <div class="mt-3">
                    {{ $grns->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>

</div>
@endsection

<style>
.status-badge{
    min-width:110px;
    text-align:center;
    padding:6px 12px;
    font-weight:500;
}





/* fix icon alignment */
.action-wrap{ white-space:nowrap; }


.grn-action {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
}



.action-btn,
.grn-icon-btn{
    width:36px;
    height:36px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:0;
}

.action-wrap{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
}

.action-wrap form{
    margin:0;
    display:flex;
    align-items:center;
}
</style>
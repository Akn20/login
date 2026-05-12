@extends('layouts.admin')

@section('title', 'Sales Return & Refund')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Sales Return & Refund</h4>
            <small class="text-muted">Pharmacy → Sales Return & Refund</small>
        </div>

        <a href="{{ route('admin.salesReturn.create') }}" class="btn btn-primary">
            <i class="feather-plus"></i> Create Sales Return
        </a>
    </div>

    {{-- FILTERS --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.salesReturn.index') }}" class="row g-2">
                <div class="col-md-2">
                    <label class="form-label">From</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">To</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="Draft" @selected(request('status')=='Draft')>Draft</option>
                        <option value="Submitted" @selected(request('status')=='Submitted')>Submitted</option>
                        <option value="Approved" @selected(request('status')=='Approved')>Approved</option>
                        <option value="Rejected" @selected(request('status')=='Rejected')>Rejected</option>
                        <option value="Completed" @selected(request('status')=='Completed')>Completed</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="q" class="form-control"
                        placeholder="Return No / Bill No / Patient"
                        value="{{ request('q') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="feather-filter"></i> Filter
                    </button>
                    <a class="btn btn-light w-100" href="{{ route('admin.salesReturn.index') }}">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th style="width:60px;">SL</th>
                            <th>Return No</th>
                            <th>Bill No</th>
                            <th>Patient</th>
                            <th>Return Date</th>
                            <th>Total Refund</th>
                            <th>Status</th>
                            <th style="width:200px;">Actions</th>
                        </tr>
                    </thead>
                   <tbody>
@forelse($returns as $key => $return)
<tr>
    <td>{{ $returns->firstItem() + $key }}</td>
    <td>{{ $return->return_number }}</td>
    <td>{{ $return->bill->bill_number ?? '-' }}</td>
    <td>{{ $return->patient 
    ? $return->patient->first_name . ' ' . $return->patient->last_name 
    : '-' 
}}</td>
    <td>{{ $return->created_at->format('Y-m-d') }}</td>
    <td>₹ {{ number_format($return->total_refund, 2) }}</td>

    <td>
        @php
            $badge = [
                'Draft' => 'secondary',
                'Submitted' => 'warning',
                'Approved' => 'success',
                'Rejected' => 'danger',
                'Completed' => 'primary'
            ];
        @endphp

        <span class="badge bg-{{ $badge[$return->status] ?? 'secondary' }}">
            {{ $return->status }}
        </span>
    </td>

    <td class="text-center">
        <a href="{{ route('admin.salesReturn.show', $return->id) }}" class="text-info me-2">
            <i class="feather-eye"></i>
        </a>
        @if($return->status == 'Draft')
    <a href="{{ route('admin.salesReturn.edit', $return->id) }}" class="text-primary me-2">
        <i class="feather-edit"></i>
    </a>
@else
    <span class="text-muted me-2" title="Editing disabled">
        <i class="feather-edit"></i>
    </span>
@endif
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center text-muted">
        No Sales Returns Found
    </td>
</tr>
@endforelse
</tbody>
                </table>
                <div class="mt-3">
    {{ $returns->withQueryString()->links() }}
</div>
            </div>
        </div>
    </div>

</div>
<style>
td a i {
    font-size: 16px;
}
td a:hover {
    opacity: 0.7;
}
</style>
<style>
.status-badge {
    display: inline-block;
    min-width: 100px;      /* same width for all */
    text-align: center;    /* center text */
    padding: 6px 10px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 6px;
}
table {
    table-layout: fixed;
    width: 100%;
}

th, td {
    text-align: center;
    vertical-align: middle;
}
</style>
@endsection
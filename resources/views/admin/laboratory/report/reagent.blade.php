@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0">Reagent Usage Report</h5>
        <small class="text-muted">Reagent consumption and stock monitoring</small>
    </div>

    <div class="d-flex gap-2">
        {{-- FILTER BY REAGENT --}}
        <form method="GET" class="d-flex gap-2">
            <select name="item_id" class="form-control form-control-sm" onchange="this.form.submit()">
                <option value="">All Reagents</option>
                @foreach($reagents as $reagent)
                    <option value="{{ $reagent->id }}" {{ request('item_id') == $reagent->id ? 'selected' : '' }}>
                        {{ $reagent->name }}
                    </option>
                @endforeach
            </select>
            @if(request('from_date'))<input type="hidden" name="from_date" value="{{ request('from_date') }}">@endif
            @if(request('to_date'))<input type="hidden" name="to_date" value="{{ request('to_date') }}">@endif
        </form>

        {{-- DATE FILTER --}}
        <form method="GET" class="d-flex gap-2">
            <input type="date" name="from_date" class="form-control form-control-sm"
                   value="{{ request('from_date') }}" placeholder="From">
            <input type="date" name="to_date" class="form-control form-control-sm"
                   value="{{ request('to_date') }}" placeholder="To">
            @if(request('item_id'))<input type="hidden" name="item_id" value="{{ request('item_id') }}">@endif
            <button type="submit" class="btn btn-light-brand btn-sm">
                <i class="feather-search"></i>
            </button>
        </form>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">Total Usage Records</h6>
            <h4 class="fw-bold">{{ $logs->count() }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">Total Quantity Used</h6>
            <h4 class="fw-bold text-primary">{{ $totalUsed }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">High Usage Reagents</h6>
            <h4 class="fw-bold text-warning">{{ $highUsageReagents->count() }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="border rounded p-3 text-center">
            <h6 class="text-muted">Low Stock Alerts</h6>
            <h4 class="fw-bold text-danger">{{ $lowStockItems->count() }}</h4>
        </div>
    </div>
</div>

{{-- LOW STOCK ALERTS --}}
@if($lowStockItems->count() > 0)
<div class="alert alert-danger mb-4">
    <h6 class="alert-heading"><i class="feather-alert-triangle"></i> Low Stock Alerts</h6>
    <div class="row mt-2">
        @foreach($lowStockItems as $item)
        <div class="col-md-3">
            <strong>{{ $item->name }}</strong>: {{ $item->quantity }} {{ $item->unit }} remaining
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="card">
    <div class="card-body">

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="reagentTable">

                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Reagent Name</th>
                        <th>Quantity Used</th>
                        <th>Usage Date</th>
                        <th>Remaining Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse($logs as $log)

                        @php
                            $item = $log->item;
                            $isLowStock = $item && $item->quantity <= $item->threshold;
                        @endphp

                        <tr class="{{ $isLowStock ? 'table-warning' : '' }}">
                            <td>{{ $loop->iteration }}</td>

                            {{-- REAGENT NAME --}}
                            <td>
                                <strong>{{ $item->name ?? 'N/A' }}</strong>
                            </td>

                            {{-- QUANTITY USED --}}
                            <td class="fw-bold text-primary">
                                {{ $log->quantity ?? $log->quantity_used ?? 1 }}
                            </td>

                            {{-- USAGE DATE --}}
                            <td>
                                {{ $log->created_at ? $log->created_at->format('d M Y') : '-' }}
                            </td>

                            {{-- REMAINING STOCK --}}
                            <td>
                                {{ $item->quantity ?? '-' }} {{ $item->unit ?? '' }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($isLowStock)
                                    <span class="badge bg-danger">Low Stock</span>
                                @elseif($item && $item->quantity <= ($item->threshold * 1.5))
                                    <span class="badge bg-warning">Warning</span>
                                @else
                                    <span class="badge bg-success">OK</span>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No usage records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

{{-- USAGE PATTERN ANALYSIS --}}
@if($usageByReagent->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h6 class="mb-0">Usage Pattern Analysis</h6>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Reagent</th>
                    <th class="text-end">Total Quantity</th>
                    <th class="text-end">Usage Count</th>
                    <th class="text-end">First Use</th>
                    <th class="text-end">Last Use</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usageByReagent as $itemId => $usage)
                    @php
                        $item = \App\Models\InventoryItem::find($itemId);
                    @endphp
                    <tr>
                        <td>{{ $item->name ?? 'Unknown' }}</td>
                        <td class="text-end">{{ $usage['total_quantity'] }}</td>
                        <td class="text-end">{{ $usage['usage_count'] }}</td>
                        <td class="text-end">{{ $usage['first_use'] ? \Carbon\Carbon::parse($usage['first_use'])->format('d M Y') : '-' }}</td>
                        <td class="text-end">{{ $usage['last_use'] ? \Carbon\Carbon::parse($usage['last_use'])->format('d M Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
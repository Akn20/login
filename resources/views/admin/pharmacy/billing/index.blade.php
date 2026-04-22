@extends('layouts.admin')

@section('title', 'Pharmacy Billing')

@section('content')

<div class="container-fluid">

```
{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0">Pharmacy Billing</h4>
        <small class="text-muted">Pharmacy → Billing</small>
    </div>

{{--  
    <a href="{{ route('admin.pharmacy.billing.create') }}" class="btn btn-primary">
        <i class="feather-plus"></i> Create Invoice
    </a>
--}}

</div>

{{-- FILTERS --}}
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.pharmacy.billing.index') }}" class="row g-3">

            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Payment Status</label>
                <select class="form-select" name="payment_status">
                    <option value="">All</option>
                    <option value="Paid" {{ request('payment_status')=='Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Partially Paid" {{ request('payment_status')=='Partially Paid' ? 'selected' : '' }}>Partially Paid</option>
                    <option value="Unpaid" {{ request('payment_status')=='Unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Invoice Status</label>
                <select class="form-select" name="invoice_status">
                    <option value="">All</option>
                    <option value="Draft" {{ request('invoice_status')=='Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Finalized" {{ request('invoice_status')=='Finalized' ? 'selected' : '' }}>Finalized</option>
                    <option value="Cancelled" {{ request('invoice_status')=='Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input 
                    type="text" 
                    name="q" 
                    class="form-control"
                    placeholder="Invoice No / Prescription No / Patient ID"
                    value="{{ request('q') }}"
                >
            </div>

            <div class="col-md-12 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.pharmacy.billing.index') }}" class="btn btn-light">
                    <i class="feather-rotate-ccw"></i> Reset
                </a>

                <button type="submit" class="btn btn-success">
                    <i class="feather-filter"></i> Apply Filters
                </button>
            </div>

        </form>
    </div>
</div>

{{-- TABLE --}}
<div class="card">
    <div class="card-body table-responsive">

        <table class="table table-hover align-middle billing-table">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;">SL</th>
                    <th>Invoice No</th>
                    
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th class="text-end">Total (₹)</th>
                    <th class="text-end">Paid (₹)</th>
                    <th class="text-end">Balance (₹)</th>
                    <th>Payment Mode</th>
                    <th>Payment Status</th>
                    
                    <th class="text-center" style="width: 200px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($bills as $index => $bill)

                    @php
                        $paymentBadge = match($bill->payment_status) {
                            'Paid' => 'success',
                            'Partially Paid' => 'warning',
                            'Unpaid' => 'danger',
                            default => 'secondary'
                        };

                        $invoiceBadge = match($bill->invoice_status) {
                            'Draft' => 'secondary',
                            'Finalized' => 'primary',
                            'Cancelled' => 'danger',
                            default => 'secondary'
                        };
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $bill->bill_number }}</td>
                          
                       
                        {{-- 
                        <td>{{ $bill->patient_id }}</td>
                        --}}

                        <td>
                            {{ $bill->display_patient_name }}
                        </td>

                        {{--
                        <td>
                            {{ $bill->prescription 
                                ? $bill->prescription->prescription_number 
                                : '-' 
                            }}
                        </td>
                        --}}

                        <td>{{ \Carbon\Carbon::parse($bill->created_at)->format('Y-m-d') }}</td>

                        <td class="text-end">{{ number_format($bill->total_amount, 2) }}</td>
                        <td class="text-end">{{ number_format($bill->paid_amount, 2) }}</td>
                        <td class="text-end">{{ number_format($bill->balance_amount, 2) }}</td>

                        <td>{{ $bill->payment_mode ?? '-' }}</td>

                        <td>
                            <span class="badge bg-{{ $paymentBadge }}">
                                {{ $bill->payment_status }}
                            </span>
                        </td>

                        

                        <td class="text-center action-icons">

                            {{-- VIEW --}}
                            <a href="{{ route('admin.pharmacy.billing.view', $bill->bill_id) }}" title="View">
                                <i class="feather-eye text-info"></i>
                            </a>

                            {{-- EDIT --}}
                            @if($bill->invoice_status === 'Draft')
                            <a href="{{ route('admin.pharmacy.billing.edit', $bill->bill_id) }}" title="Edit">
                                <i class="feather-edit text-primary"></i>
                            </a>
                            @endif

                            {{-- PRINT --}}
                            <a href="{{ route('admin.pharmacy.billing.print', $bill->bill_id) }}" title="Print">
                                <i class="feather-printer text-dark"></i>
                            </a>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="12" class="text-center text-muted py-4">
                            No invoices found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
```

</div>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>

<style>
.billing-table th,
.billing-table td {
    vertical-align: middle;
    white-space: nowrap;
}

.table-responsive {
    overflow-x: auto;
}

.billing-table .btn {
    padding: 5px 8px;
    margin: 0 2px;
    border-radius: 6px;
}

.billing-table .btn:hover {
    background-color: #f1f3f5;
}

.action-icons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px; /* space between icons */
}

.action-icons a {
    text-decoration: none;
    font-size: 18px;
}

.action-icons i {
    cursor: pointer;
    transition: 0.2s;
}

.action-icons i:hover {
    transform: scale(1.2);
}
</style>

@endsection

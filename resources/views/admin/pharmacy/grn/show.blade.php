@extends('layouts.admin')

@section('title', 'View GRN')

@section('content')
<div class="container-fluid">

    @php
        $badge = match($grn->status) {
            'Draft' => 'secondary',
            'Submitted' => 'warning',
            'Verified' => 'info',
            'Completed' => 'success',
            'Cancelled' => 'danger',
            default => 'dark'
        };
    @endphp

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">View GRN</h4>
            <small class="text-muted">Pharmacy → GRN → {{ $grn->grn_no }}</small>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.grn.index') }}" class="btn btn-light">
                <i class="feather-arrow-left"></i> Back
            </a>

            <a href="{{ route('admin.grn.print', $grn->id) }}" 
            class="btn btn-dark">
                <i class="feather-printer"></i> Print PDF
            </a>

            {{-- DRAFT --}}
            @if($grn->status === 'Draft')
                <a href="{{ route('admin.grn.edit', $grn->id) }}" class="btn btn-primary">
                    <i class="feather-edit"></i> Edit
                </a>

                <form action="{{ route('admin.grn.destroy', $grn->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Move this GRN to Trash?')">
                        <i class="feather-trash-2"></i> Delete
                    </button>
                </form>
            @endif

            {{-- SUBMITTED --}}
            @if($grn->status === 'Submitted')
                <a href="{{ route('admin.grn.verify', $grn->id) }}" class="btn btn-success">
                    <i class="feather-check-circle"></i> Verify
                </a>
            @endif

            {{-- VERIFIED --}}
            @if($grn->status === 'Verified')
                <form action="{{ route('admin.grn.destroy', $grn->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Move this GRN to Trash?')">
                        <i class="feather-trash-2"></i> Delete
                    </button>
                </form>
            @endif

        </div>
    </div>

    {{-- STATUS CARD --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="fw-semibold">GRN Status</div>
            <span class="badge bg-{{ $badge }} status-badge">
                {{ $grn->status }}
            </span>
        </div>
    </div>

    {{-- GRN DETAILS --}}
    <div class="card mb-3">
        <div class="card-header">
            <strong>GRN Details</strong>
        </div>

        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-3">
                    <div class="text-muted small">GRN No</div>
                    <div class="fw-semibold">{{ $grn->grn_no }}</div>
                </div>

                <div class="col-md-3">
                    <div class="text-muted small">GRN Date</div>
                    <div class="fw-semibold">{{ $grn->grn_date }}</div>
                </div>

                <div class="col-md-3">
                    <div class="text-muted small">Vendor</div>
                    <div class="fw-semibold">{{ $grn->vendor_name }}</div>
                </div>

                <div class="col-md-3">
                    <div class="text-muted small">Purchase Order</div>
                    <div class="fw-semibold">{{ $grn->po_no ?: '-' }}</div>
                </div>

                <div class="col-md-3">
                    <div class="text-muted small">Invoice No</div>
                    <div class="fw-semibold">{{ $grn->invoice_no }}</div>
                </div>

                <div class="col-md-3">
                    <div class="text-muted small">Invoice Date</div>
                    <div class="fw-semibold">{{ $grn->invoice_date }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Remarks</div>
                    <div class="fw-semibold">{{ $grn->remarks ?: '-' }}</div>
                </div>

            </div>
        </div>
    </div>

    {{-- ITEMS --}}
    <div class="card mb-3">
        <div class="card-header">
            <strong>Items</strong>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">SL</th>
                        <th>Medicine</th>
                        <th>Batch</th>
                        <th>Expiry</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Free</th>
                        <th class="text-end">Rate</th>
                        <th class="text-end">Disc %</th>
                        <th class="text-end">Tax %</th>
                        <th class="text-end">Amount (₹)</th>
                    </tr>
                </thead>

                <tbody>
                            @php
                $subTotal = 0;
                $discTotal = 0;
                $taxTotal = 0;
                $grandTotal = 0;
            @endphp

            @foreach($grn->items as $i => $it)

                @php
                    // ✅ use your real DB columns
                    $qty   = (float)($it->qty ?? 0);
                    $rate  = (float)($it->purchase_rate ?? 0);
                    $discP = (float)($it->discount_percent ?? 0);
                    $taxP  = (float)($it->tax_percent ?? 0);

                    $base = $qty * $rate;
                    $disc = $base * ($discP / 100);
                    $after = $base - $disc;
                    $tax = $after * ($taxP / 100);

                    // if amount column exists, prefer it
                    $amt = isset($it->amount) ? (float)$it->amount : ($after + $tax);

                    $subTotal += $base;
                    $discTotal += $disc;
                    $taxTotal += $tax;
                    $grandTotal += $amt;
                @endphp

                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $it->medicine_name }}</td>
                    <td>{{ $it->batch_no ?? '-' }}</td>
                    <td>{{ $it->expiry ?? '-' }}</td>
                    <td class="text-end">{{ (int)$qty }}</td>
                    <td class="text-end">{{ (int)($it->free_qty ?? 0) }}</td>
                    <td class="text-end">{{ number_format($rate, 2) }}</td>
                    <td class="text-end">{{ number_format($discP, 2) }}</td>
                    <td class="text-end">{{ number_format($taxP, 2) }}</td>
                    <td class="text-end fw-semibold">{{ number_format($amt, 2) }}</td>
                </tr>
            @endforeach

                </tbody>
            </table>
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Summary</strong>
        </div>

        <div class="card-body">
            <div class="row g-3 justify-content-end">
                <div class="col-md-3">
                    <label class="form-label">Sub Total (₹)</label>
                    <input class="form-control text-end" value="{{ number_format($subTotal,2) }}" readonly>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Total Discount (₹)</label>
                    <input class="form-control text-end" value="{{ number_format($discTotal,2) }}" readonly>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Total Tax (₹)</label>
                    <input class="form-control text-end" value="{{ number_format($taxTotal,2) }}" readonly>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Grand Total (₹)</label>
                    <input class="form-control text-end fw-bold" value="{{ number_format($grandTotal,2) }}" readonly>
                </div>
            </div>
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
</style>
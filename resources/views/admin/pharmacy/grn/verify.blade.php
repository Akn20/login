@extends('layouts.admin')

@section('title', 'Verify GRN')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Verify GRN</h4>
            <small class="text-muted">Pharmacy → GRN → Verify ({{ $grn->grn_no }})</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.grn.show', $grn->id) }}" class="btn btn-light">
                <i class="feather-eye"></i> View
            </a>
            <a href="{{ route('admin.grn.index') }}" class="btn btn-light">
                <i class="feather-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- NOTE --}}
    <div class="alert alert-info">
        <strong>Note:</strong> Verification/Reject is allowed only when status is <b>Submitted</b>.
    </div>

    {{-- GRN + PO DETAILS --}}
    <div class="card mb-3">
        <div class="card-header">
            <strong>GRN & Purchase Order Details</strong>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="text-muted small">Vendor</div>
                    <div class="fw-semibold">{{ $grn->vendor_name }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">Invoice No</div>
                    <div class="fw-semibold">{{ $grn->invoice_no }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">Invoice Date</div>
                    <div class="fw-semibold">{{ $grn->invoice_date }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">GRN Date</div>
                    <div class="fw-semibold">{{ $grn->grn_date }}</div>
                </div>

                <div class="col-md-3">
                    <div class="text-muted small">PO No</div>
                    <div class="fw-semibold">{{ $grn->po_no ?: '-' }}</div>
                </div>

                <div class="col-md-9">
                    <div class="text-muted small">PO Note</div>
                    <div class="fw-semibold">{{ $po['note'] ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ITEMS TABLE --}}
    <div class="card mb-3">
        <div class="card-header">
            <strong>Items (Read Only)</strong>
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
                @php $grand = 0; @endphp
                @foreach($grn->items as $i => $it)
                    @php $grand += (float)($it->amount ?? 0); @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $it->medicine_name }}</td>
                        <td>{{ $it->batch_no ?: '-' }}</td>
                        <td>{{ $it->expiry ?: '-' }}</td>
                        <td class="text-end">{{ $it->qty }}</td>
                        <td class="text-end">{{ $it->free_qty }}</td>
                        <td class="text-end">{{ number_format((float)$it->purchase_rate,2) }}</td>
                        <td class="text-end">{{ number_format((float)$it->discount_percent,2) }}</td>
                        <td class="text-end">{{ number_format((float)$it->tax_percent,2) }}</td>
                        <td class="text-end fw-semibold">{{ number_format((float)$it->amount,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="text-end fw-bold">
                Grand Total: ₹ {{ number_format($grand,2) }}
            </div>
        </div>
    </div>

    {{-- ACTIONS: VERIFY + REJECT --}}
    <div class="row g-3">
        <div class="col-md-6">
            <form action="{{ route('admin.grn.verify.store', $grn->id) }}" method="POST" class="card">
                @csrf
                <div class="card-header">
                    <strong>Verify</strong>
                </div>
                <div class="card-body">
                    <label class="form-label">Verifier Remarks (optional)</label>
                    <textarea name="verify_remarks" class="form-control" rows="3" placeholder="Optional..."></textarea>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-success"
                            onclick="return confirm('Verify this GRN?')">
                        <i class="feather-check-circle"></i> Verify GRN
                    </button>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <form action="{{ route('admin.grn.reject.store', $grn->id) }}" method="POST" class="card border-danger">
                @csrf
                <div class="card-header bg-danger text-white">
                    <strong>Reject</strong>
                </div>
                <div class="card-body">
                    <label class="form-label">Reject Reason <span class="text-danger">*</span></label>
                    <textarea name="reject_reason" class="form-control" rows="3" required placeholder="Why rejected?"></textarea>
                    <small class="text-muted">This will set status to <b>Rejected</b>.</small>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Reject this GRN?')">
                        <i class="feather-x-circle"></i> Reject GRN
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
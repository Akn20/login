@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Create GRN</h5>
    </div>
</div>

<form action="{{ route('admin.inventory.grns.store') }}" method="POST">
@csrf

<input type="hidden" name="purchase_order_id" value="{{ $po->id }}">

<!-- PO Info -->
<div class="card mb-4">
<div class="card-body">

<div class="row">
    <div class="col-md-4">
        <strong>PO Number:</strong><br>
        {{ $po->po_number }}
    </div>

    <div class="col-md-4">
        <strong>Vendor:</strong><br>
        {{ $po->inventoryVendor->name ?? '-' }}
    </div>

    <div class="col-md-4">
        <strong>Order Date:</strong><br>
        {{ \Carbon\Carbon::parse($po->order_date)->format('d-m-Y') }}
    </div>

    <div class="col-md-4 mt-3">
        <label class="form-label">Received Date</label>
        <input type="date" name="received_date" class="form-control" required>
    </div>
</div>

</div>
</div>

<!-- Items -->
<div class="card">
<div class="card-body">

<h6>Items</h6>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Item</th>
            <th>Ordered Qty</th>
            <th>Received Qty</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>

        @foreach($po->items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>

            <td>
                {{ $item->item->name }}
                <input type="hidden" 
                       name="items[{{ $index }}][item_id]" 
                       value="{{ $item->item_id }}">
            </td>

            <td>
                {{ $item->quantity }}
                <input type="hidden"
                       name="items[{{ $index }}][ordered_quantity]"
                       value="{{ $item->quantity }}">
            </td>

            <td>
                <input type="number"
                       name="items[{{ $index }}][received_quantity]"
                       class="form-control received-qty"
                       max="{{ $item->quantity }}"
                       min="0"
                       required>
            </td>

            <td>
                ₹ {{ number_format($item->unit_price, 2) }}
                <input type="hidden"
                       name="items[{{ $index }}][unit_price]"
                       value="{{ $item->unit_price }}">
            </td>

            <td>
                <input type="text"
                       class="form-control line-total"
                       readonly>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

<div class="text-end mt-3">
    <h5>Grand Total: ₹ <span id="grandTotal">0.00</span></h5>
</div>

</div>
</div>

<div class="text-end mt-4">
    <button type="submit" class="btn btn-success">
        Save GRN
    </button>
</div>

</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    function calculateTotals() {
        let grandTotal = 0;

        document.querySelectorAll('tbody tr').forEach(row => {
            const qtyInput = row.querySelector('.received-qty');
            const unitPrice = parseFloat(
                row.querySelector('input[name*="[unit_price]"]').value
            );

            const qty = parseFloat(qtyInput.value) || 0;
            const total = qty * unitPrice;

            row.querySelector('.line-total').value =
                total ? total.toFixed(2) : '';

            grandTotal += total;
        });

        document.getElementById('grandTotal')
            .textContent = grandTotal.toFixed(2);
    }

    document.querySelectorAll('.received-qty')
        .forEach(input => {
            input.addEventListener('input', calculateTotals);
        });

});
</script>
@endpush
@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Create Purchase Order</h5>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.inventory.purchase-orders.store') }}" method="POST">
@csrf

<div class="card mb-4">
<div class="card-body">

<div class="row">

    <!-- Vendor -->
    <div class="col-md-4 mb-3">
        <label class="form-label">Vendor</label>
        <select name="vendor_id" class="form-select" required>
            <option value="">Select Vendor</option>
            @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}">
                    {{ $vendor->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Order Date -->
    <div class="col-md-4 mb-3">
        <label class="form-label">Order Date</label>
        <input type="date" name="order_date" class="form-control" required>
    </div>

    <!-- Expected Date -->
    <div class="col-md-4 mb-3">
        <label class="form-label">Expected Delivery Date</label>
        <input type="date" name="expected_date" class="form-control">
    </div>

</div>

</div>
</div>

<!-- Items Table -->
<div class="card">
<div class="card-body">

<h6>Items</h6>

<table class="table table-bordered" id="itemsTable">
    <thead class="table-light">
        <tr>
            <th width="30%">Item</th>
            <th width="15%">Quantity</th>
            <th width="20%">Unit Price</th>
            <th width="20%">Total</th>
            <th width="10%">Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<button type="button" class="btn btn-sm btn-success" id="addRow">
    + Add Item
</button>

<div class="text-end mt-3">
    <h5>Grand Total: ₹ <span id="grandTotal">0.00</span></h5>
</div>

</div>
</div>

<div class="text-end mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="feather-save me-2"></i> Save Purchase Order
    </button>
</div>

</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const items = @json($items);
    const addRowBtn = document.getElementById('addRow');
    const tableBody = document.querySelector('#itemsTable tbody');
    const grandTotalEl = document.getElementById('grandTotal');

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.line-total').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        grandTotalEl.textContent = total.toFixed(2);
    }

    let rowIndex = 0;

function createRow() {

    const tr = document.createElement('tr');

    tr.innerHTML = `
        <td>
            <select name="items[${rowIndex}][item_id]" class="form-select" required>
                <option value="">Select Item</option>
                ${items.map(item =>
                    `<option value="${item.id}">${item.name}</option>`
                ).join('')}
            </select>
        </td>
        <td>
            <input type="number" 
                name="items[${rowIndex}][quantity]"
                class="form-control qty" min="1" required>
        </td>
        <td>
            <input type="number"
                name="items[${rowIndex}][unit_price]"
                class="form-control price" step="0.01" required>
        </td>
        <td>
            <input type="text"
                class="form-control line-total" readonly>
        </td>
        <td>
            <button type="button"
                class="btn btn-danger btn-sm removeRow">
                X
            </button>
        </td>
    `;

    tableBody.appendChild(tr);
    rowIndex++;
}
    addRowBtn.addEventListener('click', function () {
        createRow();
    });

    tableBody.addEventListener('click', function (e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
            calculateGrandTotal();
        }
    });

    tableBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('qty') ||
            e.target.classList.contains('price')) {

            const row = e.target.closest('tr');
            const qty = row.querySelector('.qty').value;
            const price = row.querySelector('.price').value;
            const total = qty * price;

            row.querySelector('.line-total').value =
                total ? total.toFixed(2) : '';

            calculateGrandTotal();
        }
    });

});
</script>
@endpush
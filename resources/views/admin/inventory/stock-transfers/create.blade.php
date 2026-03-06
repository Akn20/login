@extends('layouts.admin')

@section('content')

<h5>Create Stock Transfer</h5>

<form method="POST" action="{{ route('admin.inventory.stock-transfers.store') }}">
@csrf

<div class="mb-3">
    <label>Transfer Date</label>
    <input type="date" name="transfer_date" class="form-control" required>
</div>

<table class="table" id="transferTable">
    <thead>
        <tr>
            <th>Item</th>
            <th>Available Stock</th>
            <th>Quantity</th>
            <th></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<button type="button" onclick="addRow()" class="btn btn-success">Add Item</button>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">Transfer</button>
</div>

</form>

<script>
let items = @json($items);

function updateStock(selectEl) {
    const id = selectEl.value;
    const item = items.find(i => i.id == id);
    const cell = selectEl.closest('tr').querySelector('.available-stock');
    cell.textContent = item ? item.stock : '';
}

function addRow() {
    // build options with stock data as data attribute (optional)
    let options = items.map(item =>
        `<option value="${item.id}" data-stock="${item.stock}">${item.name}</option>`
    ).join('');

    let initialStock = items.length ? items[0].stock : '';

    let row = `
        <tr>
            <td>
                <select name="items[][item_id]" class="form-control" onchange="updateStock(this)">
                    ${options}
                </select>
            </td>
            <td class="available-stock">${initialStock}</td>
            <td>
                <input type="number" name="items[][quantity]" 
                       class="form-control" min="1">
            </td>
            <td>
                <button type="button" onclick="this.closest('tr').remove()">X</button>
            </td>
        </tr>
    `;
    document.querySelector('#transferTable tbody').insertAdjacentHTML('beforeend', row);
}
</script>

@endsection
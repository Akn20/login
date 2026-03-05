@extends('layouts.admin')

@section('content')

<div class="container">
    <h2>Edit Purchase Order</h2>

    <form action="{{ route('admin.inventory.purchase-orders.update', $purchaseOrder->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>PO Number</label>
            <input type="text" name="po_number" 
                   value="{{ $purchaseOrder->po_number }}" 
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Supplier</label>
            <input type="text" name="supplier_name" 
                   value="{{ $purchaseOrder->supplier_name }}" 
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Total Amount</label>
            <input type="number" name="total_amount" 
                   value="{{ $purchaseOrder->total_amount }}" 
                   class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Update
        </button>
    </form>
</div>

@endsection
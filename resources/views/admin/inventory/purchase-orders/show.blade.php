@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Purchase Order Details</h5>
    </div>

    <div class="page-header-right">
        <a href="{{ route('admin.inventory.purchase-orders.index') }}" 
           class="btn btn-secondary">
            Back
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card mb-4">
<div class="card-body">

<div class="row">

    <div class="col-md-4">
        <strong>PO Number:</strong><br>
        {{ $purchaseOrder->po_number }}
    </div>

    <div class="col-md-4">
        <strong>Vendor:</strong><br>
        {{ $purchaseOrder->inventoryVendor->name ?? '-' }}
    </div>

    <div class="col-md-4">
        <strong>Status:</strong><br>

        @if($purchaseOrder->status == 'draft')
            <span class="badge bg-secondary">Draft</span>
        @elseif($purchaseOrder->status == 'approved')
            <span class="badge bg-info">Approved</span>
        @elseif($purchaseOrder->status == 'ordered')
            <span class="badge bg-primary">Ordered</span>
        @elseif($purchaseOrder->status == 'completed')
            <span class="badge bg-success">Completed</span>
        @elseif($purchaseOrder->status == 'cancelled')
            <span class="badge bg-danger">Cancelled</span>
        @endif

    </div>

    <div class="col-md-4 mt-3">
        <strong>Order Date:</strong><br>
        {{ \Carbon\Carbon::parse($purchaseOrder->order_date)->format('d-m-Y') }}
    </div>

    <div class="col-md-4 mt-3">
        <strong>Expected Date:</strong><br>
        {{ $purchaseOrder->expected_date 
            ? \Carbon\Carbon::parse($purchaseOrder->expected_date)->format('d-m-Y')
            : '-' }}
    </div>

    <div class="col-md-4 mt-3">
        <strong>Total Amount:</strong><br>
        ₹ {{ number_format($purchaseOrder->total_amount, 2) }}
    </div>

</div>

</div>
</div>

<!-- Items Table -->
<div class="card">
<div class="card-body table-responsive">

<h6>Items</h6>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchaseOrder->items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->item->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>₹ {{ number_format($item->unit_price, 2) }}</td>
            <td>₹ {{ number_format($item->total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>
</div>

<!-- Approval Button -->
@if($purchaseOrder->status == 'draft')
<div class="text-end mt-4">

    <form action="{{ route('admin.inventory.purchase-orders.update', $purchaseOrder->id) }}" 
          method="POST" 
          class="d-inline">
        @csrf
        @method('PUT')

        <input type="hidden" name="status" value="approved">

        <button type="submit" 
                onclick="return confirm('Approve this Purchase Order?')"
                class="btn btn-success">
            Approve Purchase Order
        </button>
    </form>

</div>
@endif


<!-- GRN Button -->
@if($purchaseOrder->status == 'approved')
<div class="text-end mt-3">
    <a href="{{ route('admin.inventory.grns.create', ['po_id' => $purchaseOrder->id]) }}"
       class="btn btn-primary">
        Create GRN
    </a>
</div>
@endif
@endsection
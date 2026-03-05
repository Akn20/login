@extends('layouts.admin')

@section('content')

<div class="nxl-content">
    <div class="page-header">
        <div class="page-header-left">
            <h5>Edit Purchase Order</h5>
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

    <form action="{{ route('admin.inventory.purchase-orders.update', $purchaseOrder->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Vendor</label>
                        <select name="inventory_vendor_id" class="form-select" required>
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ $purchaseOrder->inventory_vendor_id == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Order Date</label>
                        <input type="date" name="order_date" class="form-control" value="{{ $purchaseOrder->order_date->format('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Expected Delivery Date</label>
                        <input type="date" name="expected_date" class="form-control" value="{{ optional($purchaseOrder->expected_date)->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Items section could be added here if editable -->

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.inventory.purchase-orders.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
</div>

@endsection
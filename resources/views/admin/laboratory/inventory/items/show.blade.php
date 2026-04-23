@extends('layouts.admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h5>View Inventory Item</h5>

    <a href="{{ route('admin.laboratory.inventory.items.index') }}" class="btn btn-secondary">
        <i class="feather-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <div class="row g-4">

            <!-- ITEM NAME -->
            <div class="col-md-6">
                <label class="form-label text-muted">Item Name</label>
                <h6>{{ $item->name }}</h6>
            </div>

            <!-- CATEGORY -->
            <div class="col-md-6">
                <label class="form-label text-muted">Category</label>
                <h6>{{ $item->category ?? '-' }}</h6>
            </div>

            <!-- STOCK -->
            <div class="col-md-6">
                <label class="form-label text-muted">Available Stock</label>
                <h6>{{ $item->quantity}}</h6>
            </div>

            <!-- UNIT -->
            <div class="col-md-6">
                <label class="form-label text-muted">Unit</label>
                <h6>{{ $item->unit ?? '-' }}</h6>
            </div>

            <!-- MIN STOCK -->
            <div class="col-md-6">
                <label class="form-label text-muted">Minimum Stock</label>
                <h6>{{ $item->threshold }}</h6>
            </div>

            <!-- EXPIRY DATE -->
            <div class="col-md-6">
                <label class="form-label text-muted">Expiry Date</label>
                <h6>
                    {{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('d M Y') : '-' }}
                </h6>
            </div>

            <!-- STATUS -->
            <div class="col-md-6">
                <label class="form-label text-muted">Status</label>
                <br>
                @if($item->quantity <= $item->threshold)
                    <span class="badge bg-danger">Low Stock</span>
                @else
                    <span class="badge bg-success">In Stock</span>
                @endif
            </div>

            <!-- CREATED AT -->
            <div class="col-md-6">
                <label class="form-label text-muted">Added On</label>
                <h6>{{ $item->created_at->format('d M Y H:i') }}</h6>
            </div>

        </div>

    </div>
</div>

@endsection
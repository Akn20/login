@extends('layouts.admin')

@section('content')

<h3>Add New Item</h3>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.inventory.store') }}">
@csrf

<div class="card p-4">

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Item Name</label>
        <input type="text" name="name" class="form-control" 
               value="{{ old('name') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Item Code</label>
        <input type="text" name="code" class="form-control" 
               value="{{ old('code') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Category</label>
        <select name="category" class="form-control" required>
            <option value="">Select</option>
            <option>Medicine</option>
            <option>Equipment</option>
            <option>Consumable</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label>Unit</label>
        <input type="text" name="unit" class="form-control" 
               placeholder="Box / Piece / Bottle">
    </div>

    <div class="col-md-4 mb-3">
        <label>Reorder Level</label>
        <input type="number" name="reorder_level" 
               class="form-control" min="0">
    </div>

    <div class="col-md-4 mb-3">
        <label>Purchase Price</label>
        <input type="number" step="0.01" name="purchase_price" 
               class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Selling Price</label>
        <input type="number" step="0.01" name="selling_price" 
               class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
    <label class="form-label">Opening Stock</label>
    <input type="number"
           name="stock"
           class="form-control"
           min="0"
           value="{{ old('stock', 0) }}">
</div>

</div>

<button class="btn btn-success mt-3">Save Item</button>
<a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary mt-3">Cancel</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

</div>

</form>

@endsection
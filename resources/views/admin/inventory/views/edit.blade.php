@extends('layouts.admin')

@section('content')

<h3>Edit Item</h3>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.inventory.update',$item->id) }}">
@csrf
@method('PUT')

<div class="card p-4">

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Item Name</label>
        <input type="text" name="name" 
               class="form-control"
               value="{{ old('name',$item->name) }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Item Code</label>
        <input type="text" name="code"
               class="form-control"
               value="{{ old('code',$item->code) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Category</label>
        <select name="category" class="form-control">
            <option {{ $item->category=='Medicine'?'selected':'' }}>Medicine</option>
            <option {{ $item->category=='Equipment'?'selected':'' }}>Equipment</option>
            <option {{ $item->category=='Consumable'?'selected':'' }}>Consumable</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label>Unit</label>
        <input type="text" name="unit" 
               class="form-control"
               value="{{ old('unit',$item->unit) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Reorder Level</label>
        <input type="number" name="reorder_level"
               class="form-control"
               value="{{ old('reorder_level',$item->reorder_level) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Purchase Price</label>
        <input type="number" step="0.01"
               name="purchase_price"
               class="form-control"
               value="{{ old('purchase_price',$item->purchase_price) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Selling Price</label>
        <input type="number" step="0.01"
               name="selling_price"
               class="form-control"
               value="{{ old('selling_price',$item->selling_price) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" {{ $item->status=='active'?'selected':'' }}>Active</option>
            <option value="inactive" {{ $item->status=='inactive'?'selected':'' }}>Inactive</option>
        </select>
    </div>
   <div class="col-md-4 mb-3">
    <label class="form-label">Stock</label>
    <input type="number"
           name="stock"
           class="form-control"
           min="0"
           value="{{ old('stock', $item->stock) }}">
</div>

</div>

<button class="btn btn-success mt-3">Update Item</button>
<a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary mt-3">Cancel</a>

</div>

</form>

@endsection
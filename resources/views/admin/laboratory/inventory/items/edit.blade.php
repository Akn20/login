@extends('layouts.admin')

@section('content')

<h5>Edit Item</h5>

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.laboratory.inventory.items.update', $item->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" name="name" class="form-control" value="{{ $item->name }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
           <select name="category" class="form-control">
            <option value="">Select Category</option>
            <option value="Reagent" {{ $item->category == 'Reagent' ? 'selected' : '' }}>Reagent</option>
            <option value="Consumable" {{ $item->category == 'Consumable' ? 'selected' : '' }}>Consumable</option>
            <option value="Equipment" {{ $item->category == 'Equipment' ? 'selected' : '' }}>Equipment</option>
        </select>
        </div>


<div class="mb-3">
    <label class="form-label">Quantity</label>
    <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}">
</div>

<div class="mb-3">
    <label class="form-label">Unit</label>
    <input type="text" name="unit" class="form-control" value="{{ $item->unit }}">
</div>



<div class="mb-3">
    <label class="form-label">Minimum Stock</label>
    <input type="number" name="threshold" class="form-control" value="{{ $item->threshold }}">
</div>

<div class="mb-3">
    <label class="form-label">Expiry Date</label>
    <input type="date" name="expiry_date" class="form-control"
        value="{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('Y-m-d') : '' }}">
</div>

            <button class="btn btn-primary">Update</button>

        </form>

    </div>
</div>

@endsection
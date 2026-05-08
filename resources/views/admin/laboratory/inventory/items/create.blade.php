@extends('layouts.admin')

@section('content')

<h5>Add Inventory Item</h5>

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.laboratory.inventory.items.store') }}">
            @csrf

            <!-- NAME -->
            <div class="mb-3">
                <label class="form-label">Item Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- CATEGORY -->
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-control">
                <option value="">Select Category</option>
                <option value="Reagent">Reagent</option>
                <option value="Consumable">Consumable</option>
                <option value="Equipment">Equipment</option>
            </select>
            </div>
            <!-- QUANTITY -->
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>

            <!-- UNIT -->
            <div class="mb-3">
                <label class="form-label">Unit</label>
                <input type="text" name="unit" class="form-control" placeholder="e.g. ml, pieces">
            </div>

            <!-- MINIMUM STOCK -->
            <div class="mb-3">
                <label class="form-label">Minimum Stock (Threshold)</label>
                <input type="number" name="threshold" class="form-control">
            </div>

            <!-- EXPIRY DATE -->
            <div class="mb-3">
                <label class="form-label">Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control">
            </div>

            <button class="btn btn-success">Save</button>

        </form>

    </div>
</div>

@endsection
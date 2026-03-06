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
        <select name="category" id="category-select" class="form-control" required>
            <option value="">Select</option>
            @foreach($categories ?? [] as $cat)
                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
        <div class="mt-2" id="category-other-container" style="display: none;">
            <input type="text" name="category_other" id="category-other"
                   class="form-control" placeholder="Enter new category"
                   value="{{ old('category_other') }}">
        </div>
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

<div class="text-end mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="feather-save me-3"></i> Save Item
    </button>

    <button type="button" class="btn btn-secondary ms" onclick="window.location='{{ route('admin.inventory.index') }}'">
        <i class="feather-x me-4"></i> Cancel
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

</div>

</form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('category-select');
        const otherContainer = document.getElementById('category-other-container');
        const otherInput = document.getElementById('category-other');

        function toggleOther() {
            if (select.value === 'other') {
                otherContainer.style.display = '';
                otherInput.setAttribute('required', 'required');
            } else {
                otherContainer.style.display = 'none';
                otherInput.removeAttribute('required');
                otherInput.value = '';
            }
        }

        if (select) {
            select.addEventListener('change', toggleOther);
            // run on load in case old value is 'other'
            toggleOther();
        }
    });
</script>
@endpush
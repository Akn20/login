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
        <select name="category" id="category-select" class="form-control">
            <option value="">Select</option>
            @php
                $existingCategories = $categories ?? collect();
                $selectedCategory = old('category', $item->category);
                $isOther = $selectedCategory && !$existingCategories->contains($selectedCategory);
            @endphp
            @foreach($existingCategories as $cat)
                <option value="{{ $cat }}" {{ $selectedCategory == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
            <option value="other" {{ $isOther ? 'selected' : '' }}>Other</option>
        </select>
        <div class="mt-2" id="category-other-container" style="display: none;">
            <input type="text" name="category_other" id="category-other"
                   class="form-control" placeholder="Enter new category"
                   value="{{ $isOther ? $selectedCategory : old('category_other') }}">
        </div>
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

<div class="text-end mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="feather-save me-3"></i> Update Item
    </button>

    <button type="button" class="btn btn-secondary ms" onclick="window.location='{{ route('admin.inventory.index') }}'">
        <i class="feather-x me-4"></i> Cancel
    </button>
</div>

</div>

</form>

@endsection

@push('scripts')
<script>
// listen for status changes from other pages/tabs
window.addEventListener('storage', function (e) {
    if (!e.key || !e.key.startsWith('item-status-')) return;
    const id = e.key.replace('item-status-', '');
    // only act if it matches the current item being edited
    if (id == '{{ $item->id }}') {
        const select = document.querySelector('select[name="status"]');
        if (select) {
            select.value = e.newValue;
        }
    }
});

// when select changes here, broadcast to anyone else viewing index
const statusSelect = document.querySelector('select[name="status"]');
if (statusSelect) {
    statusSelect.addEventListener('change', function () {
        const newVal = this.value;
        localStorage.setItem('item-status-{{ $item->id }}', newVal);
    });
}

// category-other toggle
(function () {
    const select = document.getElementById('category-select');
    const otherContainer = document.getElementById('category-other-container');
    const otherInput = document.getElementById('category-other');

    function toggleOther() {
        if (select && select.value === 'other') {
            otherContainer.style.display = '';
            otherInput.setAttribute('required', 'required');
        } else if (otherContainer) {
            otherContainer.style.display = 'none';
            otherInput.removeAttribute('required');
            otherInput.value = '';
        }
    }

    if (select) {
        select.addEventListener('change', toggleOther);
        toggleOther();
    }
})();
</script>
@endpush
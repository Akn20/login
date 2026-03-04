{{-- Drug Name --}}
<div class="mb-4">
    <label class="form-label">
        Drug Name <span class="text-danger">*</span>
    </label>

    <input type="text" name="drug_name" class="form-control" value="{{ old('drug_name', $drug->drug_name ?? '') }}"
        placeholder="Enter drug name">
</div>

@error('drug_name')
    <small class="text-danger">{{ $message }}</small>
@enderror






{{-- Batch Number --}}
<div class="mb-4">
    <label class="form-label">
        Batch Number <span class="text-danger">*</span>
    </label>

    <input type="text" name="batch_number" class="form-control"
        value="{{ old('batch_number', $drug->batch_number ?? '') }}" placeholder="Enter batch number">
</div>

@error('batch_number')
    <small class="text-danger">{{ $message }}</small>
@enderror



{{-- Expiry Date --}}
<div class="mb-4">
    <label class="form-label">
        Expiry Date <span class="text-danger">*</span>
    </label>

    <input type="date" name="expiry_date" class="form-control"
        value="{{ old('expiry_date', $drug->expiry_date ?? '') }}">
</div>

@error('expiry_date')
    <small class="text-danger">{{ $message }}</small>
@enderror



{{-- Stock Quantity --}}
<div class="mb-4">
    <label class="form-label">
        Stock Quantity <span class="text-danger">*</span>
    </label>

    <input type="number" name="stock_quantity" class="form-control"
        value="{{ old('stock_quantity', $drug->stock_quantity ?? '') }}" placeholder="Enter stock quantity">
</div>

@error('stock_quantity')
    <small class="text-danger">{{ $message }}</small>
@enderror



{{-- Vendor name --}}
<div class="mb-4">
    <label class="form-label">
        Vendor Name
    </label>

    <select name="supplier_id" class="form-select" required>
        <option value="">Select Vendor</option>

        @foreach($vendors as $vendor)
            <option value="{{ $vendor->id }}">
                {{ $vendor->vendor_name }}
            </option>
        @endforeach
    </select>
</div>

@error('supplier_id')
    <small class="text-danger">{{ $message }}</small>
@enderror



{{-- Status --}}
<div class="mb-4">
    <label class="form-label">
        Status
    </label>

    <select name="status" class="form-select">

        <option value="Active" {{ old('status', $drug->status ?? '') == 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive" {{ old('status', $drug->status ?? '') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>

    </select>

</div>
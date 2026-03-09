<div class="mb-4">
    <label class="form-label">Medicine Name <span class="text-danger">*</span></label>
    <input type="text" name="medicine_name" class="form-control"
        value="{{ old('medicine_name', $expiry->medicine_name ?? '') }}">
</div>
@error('medicine_name')
<small class="text-danger">{{ $message }}</small>
@enderror

<div class="mb-4">
    <label class="form-label">Batch Number</label>
    <input type="text" name="batch_number" class="form-control"
        value="{{ old('batch_number', $expiry->batch_number ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Expiry Date <span class="text-danger">*</span></label>
    <input type="date" name="expiry_date" class="form-control"
        value="{{ old('expiry_date', $expiry->expiry_date ?? '') }}">
</div>
@error('expiry_date')
<small class="text-danger">{{ $message }}</small>
@enderror

<div class="mb-4">
    <label class="form-label">Quantity</label>
    <input type="number" name="quantity" class="form-control"
        value="{{ old('quantity', $expiry->quantity ?? '') }}">
</div>
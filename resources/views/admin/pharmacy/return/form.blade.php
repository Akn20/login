<div class="mb-4">
    <label class="form-label">Medicine Name <span class="text-danger">*</span></label>
    <input type="text" name="medicine_name" class="form-control"
        value="{{ old('medicine_name', $return->medicine_name ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Return Date <span class="text-danger">*</span></label>
    <input type="date" name="return_date" class="form-control"
        value="{{ old('return_date', $return->return_date ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Quantity</label>
    <input type="number" name="quantity" class="form-control"
        value="{{ old('quantity', $return->quantity ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Reason</label>
    <textarea name="reason" class="form-control"
        rows="3">{{ old('reason', $return->reason ?? '') }}</textarea>
</div>
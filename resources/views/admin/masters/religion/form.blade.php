<div class="mb-4">
    <label class="form-label">Religion Name</label>
    <input type="text" name="religion_name" class="form-control"
        value="{{ old('religion_name', $religion->religion_name ?? '') }}">
</div>
@error('religion_name')
    <small class="text-danger">{{ $message }}</small>
@enderror


<div class="mb-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="Active" {{ old('status', $religion->status ?? '') == 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive" {{ old('status', $religion->status ?? '') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>
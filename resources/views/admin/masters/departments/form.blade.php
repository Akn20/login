<div class="mb-4">
    <label class="form-label">Department Name <span class="text-danger">*</span></label>
    <input type="text" name="department_name" value="{{ old('department_name', $department->department_name ?? '') }}"
        class="form-control @error('department_name') is-invalid @enderror">
    @error('department_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
    <label class="form-label">Department Code <span class="text-danger">*</span></label>
    <input type="text" name="department_code" value="{{ old('department_code', $department->department_code ?? '') }}"
        class="form-control @error('department_code') is-invalid @enderror"
        placeholder="MED / NUR / ADM">
    @error('department_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
    <label class="form-label">Description</label>
    <textarea name="description" rows="3"
            class="form-control @error('description') is-invalid @enderror">{{ old('description', $department->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-4">
    <label class="form-label">Status <span class="text-danger">*</span></label>
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="1" {{ old('status', $department->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', $department->status ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

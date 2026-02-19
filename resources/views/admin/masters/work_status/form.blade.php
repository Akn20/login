<div class="mb-4">
    <label class="form-label">
        Work Status Code <span class="text-danger">*</span>
    </label>
    <input type="text" name="work_status_code" class="form-control"
        value="{{ old('work_status_code', $workStatus->work_status_code ?? '') }}">
    @error('work_status_code')
        <small class="text-danger">{{ $message }}</small>
    @enderror

</div>

<div class="mb-4">
    <label class="form-label">Work Status Name</label>
    <input type="text" name="work_status_name" class="form-control"
        value="{{ old('work_status_name', $workStatus->work_status_name ?? '') }}">
    @error('work_status_name')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label">Description</label>
    <textarea name="description"
        class="form-control">{{ old('description', $workStatus->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="Active" {{ old('status', $workStatus->status ?? '') == 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive" {{ old('status', $workStatus->status ?? '') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>
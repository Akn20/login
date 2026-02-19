<div class="mb-4">
    <label class="form-label">Job Type Code</label>
    <input type="text" name="job_type_code" class="form-control"
        value="{{ old('job_type_code', $jobType->job_type_code ?? '') }}">
    @error('job_type_code')
        <small class="text-danger">{{ $message }}</small>
    @enderror

</div>

<div class="mb-4">
    <label class="form-label">Job Type Name</label>
    <input type="text" name="job_type_name" class="form-control"
        value="{{ old('job_type_name', $jobType->job_type_name ?? '') }}">
    @error('job_type_name')
        <small class="text-danger">{{ $message }}</small>
    @enderror

</div>

<div class="mb-4">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $jobType->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="Active" {{ old('status', $jobType->status ?? '') == 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive" {{ old('status', $jobType->status ?? '') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>
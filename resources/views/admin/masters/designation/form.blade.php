<div class="mb-4">
    <label class="form-label">Designation Code</label>
    <input type="text" name="designation_code" class="form-control"
        value="{{ old('designation_code', $designation->designation_code ?? '') }}">
    @error('designation_code')
        <small class="text-danger">{{ $message }}</small>
    @enderror


</div>

<div class="mb-4">
    <label class="form-label">Designation Name</label>
    <input type="text" name="designation_name" class="form-control"
        value="{{ old('designation_name', $designation->designation_name ?? '') }}">
    @error('designation_name')
        <small class="text-danger">{{ $message }}</small>
    @enderror

</div>

<div class="mb-4">
    <label class="form-label">Department</label>
    <select name="department_id" class="form-select">
        <option value="">Select Department</option>

        @foreach($departments as $dept)
            <option value="{{ $dept->id }}" {{ old('department_id', $designation->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                {{ $dept->department_name }}
            </option>
        @endforeach
    </select>

</div>

<div class="mb-4">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $designation->description ?? '') }}
    </textarea>

</div>


<div class="mb-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="Active" {{ old('status', $designation->status ?? '') == 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive" {{ old('status', $designation->status ?? '') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>

</div>
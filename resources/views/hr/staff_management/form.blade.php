<div class="mb-4">
    <label class="form-label">
        Employee ID <span class="text-danger">*</span>
    </label>

    <input type="text" name="employee_id"
        value="{{ old('employee_id', $staffManagement->employee_id ?? '') }}"
        class="form-control @error('employee_id') is-invalid @enderror"
        placeholder="Enter Employee ID">

    @error('employee_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="mb-4">
    <label class="form-label">
        Full Name <span class="text-danger">*</span>
    </label>

    <input type="text" name="name"
        value="{{ old('name', $staffManagement->name ?? '') }}"
        class="form-control @error('name') is-invalid @enderror"
        placeholder="Enter Full Name">

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="mb-4">
    <label class="form-label">
        Joining Date <span class="text-danger">*</span>
    </label>

    <input type="date" name="joining_date"
        value="{{ old('joining_date', $staffManagement->joining_date ?? '') }}"
        class="form-control @error('joining_date') is-invalid @enderror">

    @error('joining_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="mb-4">
    <label class="form-label">
        Status <span class="text-danger">*</span>
    </label>

    <select name="status"
        class="form-select @error('status') is-invalid @enderror">

        <option value="Active"
            {{ old('status', $staffManagement->status ?? '') == 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive"
            {{ old('status', $staffManagement->status ?? '') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>

    </select>

    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-4">
    <label class="form-label">
        Full Name <span class="text-danger">*</span>
    </label>

    <input type="text" name="name" value="{{ old('name', $staffManagement->name ?? '') }}"
        class="form-control @error('name') is-invalid @enderror" placeholder="Enter Full Name">

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label">
        Role <span class="text-danger">*</span>
    </label>

    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">
        <option value="">Select a Role</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ old('role_id', $staffManagement->role_id ?? '') == $role->id ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    @error('role_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="mb-4">
    <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
    <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror"
        value="{{ old('mobile', $staffManagement->user->mobile ?? '') }}">
    @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
    <label class="form-label">Email Address</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $staffManagement->user->email ?? '') }}">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>


<div class="mb-4">
    <label class="form-label">
        Department <span class="text-danger">*</span>
    </label>

    <select name="department" class="form-select @error('department') is-invalid @enderror">
        <option value="">Select Department</option>

        @foreach($departments as $dept)
            <option value="{{ $dept->department_name }}"
                {{ old('department', $staffManagement->department ?? '') == $dept->department_name ? 'selected' : '' }}>
                {{ $dept->department_name }}
            </option>
        @endforeach
    </select>

    @error('department')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="mb-4">
    <label class="form-label">
        Designation <span class="text-danger">*</span>
    </label>

    <select name="designation" class="form-select @error('designation') is-invalid @enderror">
        <option value="">Select Designation</option>

        @foreach($designations as $designation)
            <option value="{{ $designation->designation_name }}"
                {{ old('designation', $staffManagement->designation ?? '') == $designation->designation_name ? 'selected' : '' }}>
                {{ $designation->designation_name }}
            </option>
        @endforeach
    </select>

    @error('designation')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="mb-4">
    <label class="form-label">
        Joining Date <span class="text-danger">*</span>
    </label>

    <input type="date" name="joining_date" value="{{ old('joining_date', $staffManagement->joining_date ?? '') }}"
        class="form-control @error('joining_date') is-invalid @enderror">

    @error('joining_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label">
        Status <span class="text-danger">*</span>
    </label>

    <select name="status" class="form-select @error('status') is-invalid @enderror">

        <option value="Active" {{ old('status', $staffManagement->status ?? '') == 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive" {{ old('status', $staffManagement->status ?? '') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>

    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
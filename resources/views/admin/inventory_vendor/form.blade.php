<div class="mb-4">
    <label class="form-label">Vendor Name <span class="text-danger">*</span></label>
    <input type="text" name="vendor_name" class="form-control"
        value="{{ old('vendor_name', $vendor->vendor_name ?? '') }}"
        placeholder="Enter vendor name">
</div>
@error('vendor_name')
    <small class="text-danger">{{ $message }}</small>
@enderror

<div class="mb-4">
    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
    <input type="text" name="phone_number" class="form-control"
        value="{{ old('phone_number', $vendor->phone_number ?? '') }}"
        placeholder="Enter 10-digit phone number" maxlength="10" minlength="10" pattern="\d{10}" required>
</div>
@error('phone_number')
    <small class="text-danger">{{ $message }}</small>
@enderror

<div class="mb-4">
    <label class="form-label">Email <span class="text-danger">*</span></label>
    <input type="email" name="email" class="form-control"
        value="{{ old('email', $vendor->email ?? '') }}"
        placeholder="Enter email address" required>
</div>
@error('email')
    <small class="text-danger">{{ $message }}</small>
@enderror

<div class="mb-4">
    <label class="form-label">Address <span class="text-danger">*</span></label>
    <textarea name="address" class="form-control" rows="3"
        placeholder="Enter address" required>{{ old('address', $vendor->address ?? '') }}</textarea>
</div>
@error('address')
    <small class="text-danger">{{ $message }}</small>
@enderror

<div class="mb-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="Active" {{ old('status', $vendor->status ?? '') == 'Active' ? 'selected' : '' }}>
            Active
        </option>
        <option value="Inactive" {{ old('status', $vendor->status ?? '') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>

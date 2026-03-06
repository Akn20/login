<div class="main-content">
    <div class="row">

        {{-- ================= WARD DETAILS ================= --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Ward Details</h5>
                </div>

                <div class="card-body row g-3">

                    {{-- Ward Name --}}
                    <div class="col-md-6">
                        <label>Ward Name *</label>
                        <input type="text" name="ward_name" class="form-control"
                            value="{{ old('ward_name', $ward->ward_name ?? '') }}" required>
                    </div>

                    {{-- Ward Type --}}
                    <div class="col-md-6">
                        <label>Ward Type *</label>
                        <select name="ward_type" class="form-control" required>

                            <option value="">Select Type</option>

                            <option value="General" {{ old('ward_type', $ward->ward_type ?? '') == 'General' ? 'selected' : '' }}>
                                General
                            </option>

                            <option value="ICU" {{ old('ward_type', $ward->ward_type ?? '') == 'ICU' ? 'selected' : '' }}>
                                ICU
                            </option>

                            <option value="Private" {{ old('ward_type', $ward->ward_type ?? '') == 'Private' ? 'selected' : '' }}>
                                Private
                            </option>

                            <option value="Semi-Private" {{ old('ward_type', $ward->ward_type ?? '') == 'Semi-Private' ? 'selected' : '' }}>
                                Semi-Private
                            </option>
                        </select>
                    </div>

                    {{-- Floor --}}
                    <div class="col-md-6">
                        <label>Floor Number *</label>
                        <input type="number" name="floor_number" class="form-control"
                            value="{{ old('floor_number', $ward->floor_number ?? '') }}" min="0" required>
                    </div>

                    {{-- Total Beds --}}
                    <div class="col-md-6">
                        <label>Total Beds</label>
                        <input type="number" name="total_beds" class="form-control"
                            value="{{ isset($ward) ? $ward->beds()->count() : 0 }}" readonly>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label>Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="1" {{ old('status', $ward->status ?? 1) == 1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ old('status', $ward->status ?? 1) == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
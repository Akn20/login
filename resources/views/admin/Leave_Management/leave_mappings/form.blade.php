{{-- Section 1: Core Mapping --}}
<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Leave Type *</label>
        <select name="leave_type_id" class="form-control" required>
            @foreach($leaveTypes as $type)
                <option value="{{ $type->id }}" {{ old('leave_type_id', $mapping->leave_type_id ?? '') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Priority *</label>
        <input type="number" name="priority" class="form-control" value="{{ old('priority', $mapping->priority ?? 1) }}" required>
    </div>
</div>

{{-- Section 2: Eligibility Scope --}}
<div class="mb-3">
    <label class="form-label">Employee Status (Multi-select) *</label>
    <select name="employee_status[]" class="form-control select2" multiple required>
        <option value="Permanent" {{ in_array('Permanent', old('employee_status', $mapping->employee_status ?? [])) ? 'selected' : '' }}>Permanent</option>
        <option value="Probation" {{ in_array('Probation', old('employee_status', $mapping->employee_status ?? [])) ? 'selected' : '' }}>Probation</option>
        <option value="Contract" {{ in_array('Contract', old('employee_status', $mapping->employee_status ?? [])) ? 'selected' : '' }}>Contract</option>
    </select> [cite: 38, 39, 40, 41]
</div>

{{-- Section 5: Carry Forward (Dynamic UI) --}}
<div class="card bg-light mb-3">
    <div class="card-body">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" id="cf_toggle" name="carry_forward_allowed" value="1" 
                   {{ old('carry_forward_allowed', $mapping->carry_forward_allowed ?? 0) ? 'checked' : '' }}>
            <label class="form-check-label" for="cf_toggle">Carry Forward Allowed?</label> [cite: 61, 178]
        </div>

        <div id="cf_fields" style="display: {{ old('carry_forward_allowed', $mapping->carry_forward_allowed ?? 0) ? 'block' : 'none' }}">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Limit</label>
                    <input type="number" name="carry_forward_limit" class="form-control" value="{{ $mapping->carry_forward_limit ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Expiry (Days)</label>
                    <input type="number" name="carry_forward_expiry_days" class="form-control" value="{{ $mapping->carry_forward_expiry_days ?? '' }}">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple JS for showing/hiding fields [cite: 179]
    document.getElementById('cf_toggle').addEventListener('change', function() {
        document.getElementById('cf_fields').style.display = this.checked ? 'block' : 'none';
    });
</script>
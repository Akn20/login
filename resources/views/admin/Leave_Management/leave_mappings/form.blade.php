{{-- Section 1: Core Mapping --}}
<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Leave Type *</label>
        {{-- Forcing standard form-control to avoid invisible text in library dropdowns --}}
        <select name="leave_type_id" class="form-control" style="color: #333 !important;" required>
    <option value="">-- Select --</option>
    @if(isset($leaveTypes) && count($leaveTypes) > 0)
        @foreach($leaveTypes as $type)
            <option value="{{ $type->id }}">
                {{ $type->display_name }}{{ $type->name }} {{-- Ensure 'name' is the correct column in your leave_types table --}}
            </option>
        @endforeach
    @endif
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
    </select>
</div>

{{-- Section 3: Accrual Rules ---}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Accrual Frequency *</label>
        <select name="accrual_frequency" class="form-control" required>
            <option value="Monthly" {{ (old('accrual_frequency', $mapping->accrual_frequency ?? '') == 'Monthly') ? 'selected' : '' }}>Monthly</option>
            <option value="Yearly" {{ (old('accrual_frequency', $mapping->accrual_frequency ?? '') == 'Yearly') ? 'selected' : '' }}>Yearly</option>
            <option value="Event Based" {{ (old('accrual_frequency', $mapping->accrual_frequency ?? '') == 'Event Based') ? 'selected' : '' }}>Event Based</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Accrual Value (Quantity) *</label>
        <input type="number" name="accrual_value" class="form-control" value="{{ old('accrual_value', $mapping->accrual_value ?? 0) }}" required>
    </div>
</div>

{{-- Section 4: Payroll Impact  --}}
<div class="mb-3">
    <label class="form-label d-block">Leave Nature *</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="leave_nature" id="paid" value="Paid" {{ old('leave_nature', $mapping->leave_nature ?? 'Paid') == 'Paid' ? 'checked' : '' }}>
        <label class="form-check-label" for="paid">Paid</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="leave_nature" id="unpaid" value="Unpaid" {{ old('leave_nature', $mapping->leave_nature ?? '') == 'Unpaid' ? 'checked' : '' }}>
        <label class="form-check-label" for="unpaid">Unpaid</label>
    </div>
</div>

{{-- Section 5: Carry Forward  --}}
<div class="card bg-light mb-3">
    <div class="card-body">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" id="cf_toggle" name="carry_forward_allowed" value="1" 
                   {{ old('carry_forward_allowed', $mapping->carry_forward_allowed ?? 0) ? 'checked' : '' }}>
            <label class="form-check-label" for="cf_toggle">Carry Forward Allowed?</label> 
        </div>

        <div id="cf_fields" style="display: {{ old('carry_forward_allowed', $mapping->carry_forward_allowed ?? 0) ? 'block' : 'none' }}">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Limit</label>
                    <input type="number" name="carry_forward_limit" class="form-control" value="{{ old('carry_forward_limit', $mapping->carry_forward_limit ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Expiry (Days)</label>
                    <input type="number" name="carry_forward_expiry_days" class="form-control" value="{{ old('carry_forward_expiry_days', $mapping->carry_forward_expiry_days ?? '') }}">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Section 7: Application Controls  --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Min Leave Per Application</label>
        <input type="number" name="min_leave_per_application" class="form-control" value="{{ old('min_leave_per_application', $mapping->min_leave_per_application ?? 1) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Max Leave Per Application</label>
        <input type="number" name="max_leave_per_application" class="form-control" value="{{ old('max_leave_per_application', $mapping->max_leave_per_application ?? '') }}">
    </div>
</div>

{{-- Form Actions  --}}
<div class="mt-4 d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary btn-sm px-4">
        <i class="feather-save me-1"></i> {{ isset($mapping) ? 'Update' : 'Save' }}
    </button>
    <a href="{{ route('admin.leave-mappings.index') }}" class="btn btn-light btn-sm px-4">
        Cancel
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cfToggle = document.getElementById('cf_toggle');
        const cfFields = document.getElementById('cf_fields');
        
        if(cfToggle && cfFields) {
            cfToggle.addEventListener('change', function() {
                cfFields.style.display = this.checked ? 'block' : 'none';
            });
        }
    });
</script>
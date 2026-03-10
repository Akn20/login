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
<div class="mb-3">
<label class="form-label">Target Designation </label>
{{--
CHANGE: Removed 'multiple' and name is now 'designations' (single)
This prevents the "must be an array" validation error on the frontend.
--}}
<select name="designations" class="form-control select2" required>
<option value="">-- Select Designation --</option>
@foreach($designations as $designation)
@php
// Logic to handle 'selected' state whether database has a string or an array
$selectedDesignations = old('designations', $mapping->designations ?? []);
$isSelected = false;

            if (is_array($selectedDesignations)) {
                $isSelected = in_array($designation->id, $selectedDesignations);
            } else {
                $isSelected = ($selectedDesignations == $designation->id);
            }
        @endphp
        <option value="{{ $designation->id }}" {{ $isSelected ? 'selected' : '' }}>
            {{ $designation->designation_name }}
        </option>
    @endforeach
</select>
@error('designations')
    <div class="text-danger small">{{ $message }}</div>
@enderror


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
<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" name="encashment_allowed" id="encashment_allowed" value="1" 
                {{ old('encashment_allowed', $mapping->encashment_allowed ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="encashment_allowed">Encashment Allowed</label>
        </div>
    </div>
    
    <div id="encashment_trigger_section" class="col-md-6" style="display: {{ old('encashment_allowed', $mapping->encashment_allowed ?? false) ? 'block' : 'none' }};">
        <label class="form-label">Encashment Trigger</label>
        <select name="encashment_trigger" class="form-control">
            <option value="">Select Trigger</option>
            <option value="Year-end" {{ old('encashment_trigger', $mapping->encashment_trigger ?? '') == 'Year-end' ? 'selected' : '' }}>Year-end</option>
            <option value="Exit" {{ old('encashment_trigger', $mapping->encashment_trigger ?? '') == 'Exit' ? 'selected' : '' }}>Exit</option>
            <option value="Specific Date" {{ old('encashment_trigger', $mapping->encashment_trigger ?? '') == 'Specific Date' ? 'selected' : '' }}>Specific Date</option>
        </select>
    </div>
</div>

{{-- Section 7: Application Controls  --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Min Leave Per Application *</label>
        <input type="number" name="min_leave_per_application" 
               class="form-control @error('min_leave_per_application') is-invalid @enderror" 
               value="{{ old('min_leave_per_application', $mapping->min_leave_per_application ?? 1) }}" min="1">
        @error('min_leave_per_application')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Max Leave Per Application</label>
        <input type="number" name="max_leave_per_application" 
               class="form-control @error('max_leave_per_application') is-invalid @enderror" 
               value="{{ old('max_leave_per_application', $mapping->max_leave_per_application ?? '') }}">
        @error('max_leave_per_application')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
{{-- Form Actions  --}}
<div class="mt-4 d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary btn-sm px-4">
        <i class="feather-save me-1"></i> {{ isset($mapping) ? 'Update' : 'Save' }}
    </button>
    <a href="{{ route('hr.leave-mappings.index') }}" class="btn btn-light btn-sm px-4">
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
        document.getElementById('encashment_allowed').addEventListener('change', function() {
    const triggerSection = document.getElementById('encashment_trigger_section');
    if (this.checked) {
        triggerSection.style.display = 'block';
    } else {
        triggerSection.style.display = 'none';
        // Optional: Clear the value if hidden
        triggerSection.querySelector('select').value = '';
    }
    });
})
</script>
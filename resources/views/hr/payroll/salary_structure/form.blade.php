@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

    <!-- Code -->
    <div class="col-md-6 mb-3">
        <label>Salary Structure Code *</label>
        <input type="text" name="salary_structure_code"
            class="form-control @error('salary_structure_code') is-invalid @enderror"
            value="{{ old('salary_structure_code', $record->salary_structure_code ?? '') }}">
    </div>

    <!-- Name -->
    <div class="col-md-6 mb-3">
        <label>Salary Structure Name *</label>
        <input type="text" name="salary_structure_name"
            class="form-control"
            value="{{ old('salary_structure_name', $record->salary_structure_name ?? '') }}">
    </div>

    <!-- Category -->
    <div class="col-md-6 mb-3">
        <label>Category *</label>
       <select name="structure_category" class="form-control">
    <option value="">Select</option>

    <option value="monthly"
        {{ old('structure_category', $record->structure_category ?? '') == 'monthly' ? 'selected' : '' }}>
        Monthly
    </option>

    <option value="hourly"
        {{ old('structure_category', $record->structure_category ?? '') == 'hourly' ? 'selected' : '' }}>
        Hourly
    </option>
</select>
    </div>

    <!-- Status -->
    <div class="col-md-6 mb-3">
        <label>Status *</label>
        <select name="status" class="form-control">

    <option value="active"
        {{ old('status', $record->status ?? '') == 'active' ? 'selected' : '' }}>
        Active
    </option>

    <option value="inactive"
        {{ old('status', $record->status ?? '') == 'inactive' ? 'selected' : '' }}>
        Inactive
    </option>

</select>
    </div>
<div class="row">

    <div class="col-md-6 mb-3">
        <label>Effective From *</label>
        <input type="date" name="effective_from"
            class="form-control @error('effective_from') is-invalid @enderror"
            value="{{ old('effective_from', isset($record->effective_from) ? \Carbon\Carbon::parse($record->effective_from)->format('Y-m-d') : '') }}">

        @error('effective_from')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label>Effective To</label>
        <input type="date" name="effective_to"
            class="form-control"
            value="{{ old('effective_to', isset($record->effective_to) ? \Carbon\Carbon::parse($record->effective_to)->format('Y-m-d') : '') }}">
    </div>

</div>
</div>

<hr>

<h6>Earnings Setup</h6>

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Fixed Allowances</label>
    @php
$selected = old('fixed_allowance_components', $record->fixed_allowance_components ?? []);
$selected = is_array($selected) ? $selected : [];
@endphp

<select name="fixed_allowance_components[]" multiple class="form-control">

    @foreach($allowances as $allowance)
        <option value="{{ $allowance->id }}"
            {{ in_array($allowance->id, $selected) ? 'selected' : '' }}>
            {{ $allowance->display_name ?? $allowance->name }}
        </option>
    @endforeach

</select>

    </div>
<div class="col-md-6 mb-3">
    <label>Residual Component *</label>
  <select name="residual_component_id"
    class="form-control @error('residual_component_id') is-invalid @enderror">

    <option value="">Select</option>

    @foreach($allowances as $allowance)
        <option value="{{ $allowance->id }}"
            {{ old('residual_component_id', $record->residual_component_id ?? '') == $allowance->id ? 'selected' : '' }}>
            {{ $allowance->display_name ?? $allowance->name }}
        </option>
    @endforeach

</select>

    @error('residual_component_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


    <div class="col-md-6 mb-3">
        <label>Variable Allowance</label>
      <select name="variable_allowance_allowed" class="form-control">

    <option value="1"
        {{ old('variable_allowance_allowed', $record->variable_allowance_allowed ?? '') == 1 ? 'selected' : '' }}>
        Yes
    </option>

    <option value="0"
        {{ old('variable_allowance_allowed', $record->variable_allowance_allowed ?? '') == 0 ? 'selected' : '' }}>
        No
    </option>

</select>
    </div>

</div>
<hr>

<h6>Deductions Setup</h6>

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Fixed Deductions</label>

        @php
            $selectedDeductions = old('fixed_deduction_components', $record->fixed_deduction_components ?? []);
        @endphp

        <select name="fixed_deduction_components[]" multiple class="form-control">

            @foreach($deductions as $deduction)
                <option value="{{ $deduction->id }}"
                    {{ in_array($deduction->id, $selectedDeductions) ? 'selected' : '' }}>
                    {{ $deduction->display_name ?? $deduction->name }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Variable Deduction</label>

        <select name="variable_deduction_allowed" class="form-control">

            <option value="1"
                {{ old('variable_deduction_allowed', $record->variable_deduction_allowed ?? '') == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ old('variable_deduction_allowed', $record->variable_deduction_allowed ?? '') == 0 ? 'selected' : '' }}>
                No
            </option>

        </select>
    </div>

</div>
<hr>

<h6>Time Based</h6>

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Hourly Pay</label>
        <select name="hourly_pay_eligible" class="form-control">
            <option value="1"
    {{ old('hourly_pay_eligible', $record->hourly_pay_eligible ?? '') == 1 ? 'selected' : '' }}>
    Yes
</option>

<option value="0"
    {{ old('hourly_pay_eligible', $record->hourly_pay_eligible ?? '') == 0 ? 'selected' : '' }}>
    No
</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Overtime</label>
        <select name="overtime_eligible" class="form-control">
           <option value="1"
    {{ old('overtime_eligible', $record->overtime_eligible ?? '') == 1 ? 'selected' : '' }}>
    Yes
</option>

<option value="0"
    {{ old('overtime_eligible', $record->overtime_eligible ?? '') == 0 ? 'selected' : '' }}>
    No
</option>
        </select>
    </div>

</div>

<hr>

<h6>Statutory</h6>

<div class="row">

    <div class="col-md-3">
      <input type="checkbox" name="pf_applicable" value="1"
    {{ old('pf_applicable', $record->pf_applicable ?? false) ? 'checked' : '' }}> PF
    </div>

    <div class="col-md-3">
        <input type="checkbox" name="esi_applicable" value="1"
    {{ old('esi_applicable', $record->esi_applicable ?? false) ? 'checked' : '' }}> ESI
    </div>

    <div class="col-md-3">
        <input type="checkbox" name="pt_applicable" value="1"
    {{ old('pt_applicable', $record->pt_applicable ?? false) ? 'checked' : '' }} > PT
    </div>

    <div class="col-md-3">
        <input type="checkbox" name="tds_applicable" value="1"
    {{ old('tds_applicable', $record->tds_applicable ?? false) ? 'checked' : '' }} > TDS
    </div>

</div>

<hr>

<div class="d-flex justify-content-end gap-2">

    <button type="submit" class="btn btn-primary">
        Save
    </button>

    <a href="{{ route('hr.payroll.salary-structure.index') }}" class="btn btn-light">
        Cancel
    </a>

</div>
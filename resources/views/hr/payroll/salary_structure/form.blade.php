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
        <label>Structure Code *</label>
        <input type="text" name="salary_structure_code"
            class="form-control @error('salary_structure_code') is-invalid @enderror"
            value="{{ old('salary_structure_code', $record->salary_structure_code ?? '') }}">
    </div>

    <!-- Name -->
    <div class="col-md-6 mb-3">
        <label>Structure Name *</label>
        <input type="text" name="salary_structure_name"
            class="form-control"
            value="{{ old('salary_structure_name', $record->salary_structure_name ?? '') }}">
    </div>

    <!-- Category -->
    <div class="col-md-6 mb-3">
        <label>Category *</label>
        <select name="structure_category" class="form-control">
            <option value="">Select</option>
            <option value="monthly">Monthly</option>
            <option value="hourly">Hourly</option>
        </select>
    </div>

    <!-- Status -->
    <div class="col-md-6 mb-3">
        <label>Status *</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

</div>

<hr>

<h6>Earnings Setup</h6>

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Fixed Allowances</label>
        <select name="fixed_allowance_components[]" multiple class="form-control">
            <option value="BASIC">BASIC</option>
            <option value="HRA">HRA</option>
            <option value="DA">DA</option>
        </select>
    </div>
<div class="col-md-6 mb-3">
    <label>Residual Component *</label>
    <select name="residual_component_id"
        class="form-control @error('residual_component_id') is-invalid @enderror">

        <option value="">Select</option>
        <option value="basic" {{ old('residual_component_id') == 'basic' ? 'selected' : '' }}>Basic</option>
        <option value="hra" {{ old('residual_component_id') == 'hra' ? 'selected' : '' }}>HRA</option>
        <option value="da" {{ old('residual_component_id') == 'da' ? 'selected' : '' }}>DA</option>

    </select>

    @error('residual_component_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
    <div class="col-md-6 mb-3">
        <label>Variable Allowance</label>
        <select name="variable_allowance_allowed" class="form-control">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

</div>

<hr>

<h6>Time Based</h6>

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Hourly Pay</label>
        <select name="hourly_pay_eligible" class="form-control">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Overtime</label>
        <select name="overtime_eligible" class="form-control">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

</div>

<hr>

<h6>Statutory</h6>

<div class="row">

    <div class="col-md-3">
        <input type="checkbox" name="pf_applicable" value="1"> PF
    </div>

    <div class="col-md-3">
        <input type="checkbox" name="esi_applicable" value="1"> ESI
    </div>

    <div class="col-md-3">
        <input type="checkbox" name="pt_applicable" value="1"> PT
    </div>

    <div class="col-md-3">
        <input type="checkbox" name="tds_applicable" value="1"> TDS
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
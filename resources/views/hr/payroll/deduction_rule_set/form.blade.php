<div class="card mb-3">
    <div class="card-header">Deduction Rule Details</div>
    <div class="card-body">

        <div class="row">

            <!-- Rule Code -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Rule Code *</label>
                <input type="text" name="rule_set_code" class="form-control"
                    value="{{ old('rule_set_code', $rule->rule_set_code ?? '') }}" required>
            </div>

            <!-- Rule Name -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Rule Name *</label>
                <input type="text" name="rule_set_name" class="form-control"
                    value="{{ old('rule_set_name', $rule->rule_set_name ?? '') }}" required>
            </div>

            <!-- Category -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Category *</label>
                <select name="rule_category" class="form-select" required>

    <option value=""
        {{ old('rule_category', $rule->rule_category ?? '') == '' ? 'selected' : '' }}>
        Select
    </option>

    <option value="Statutory"
        {{ old('rule_category', $rule->rule_category ?? '') == 'Statutory' ? 'selected' : '' }}>
        Statutory
    </option>

    <option value="Loan"
        {{ old('rule_category', $rule->rule_category ?? '') == 'Loan' ? 'selected' : '' }}>
        Loan
    </option>

    <option value="Recovery"
        {{ old('rule_category', $rule->rule_category ?? '') == 'Recovery' ? 'selected' : '' }}>
        Recovery
    </option>

    <option value="Ad-hoc"
        {{ old('rule_category', $rule->rule_category ?? '') == 'Ad-hoc' ? 'selected' : '' }}>
        Ad-hoc
    </option>

</select>
            </div>

            <!-- Calculation Type -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Calculation Type *</label>
            <select name="calculation_type" class="form-select" required>

    <option value=""
        {{ old('calculation_type', $rule->calculation_type ?? '') == '' ? 'selected' : '' }}>
        Select
    </option>

    <option value="Fixed"
        {{ old('calculation_type', $rule->calculation_type ?? '') == 'Fixed' ? 'selected' : '' }}>
        Fixed
    </option>

    <option value="Percentage"
        {{ old('calculation_type', $rule->calculation_type ?? '') == 'Percentage' ? 'selected' : '' }}>
        Percentage
    </option>

    <option value="Slab"
        {{ old('calculation_type', $rule->calculation_type ?? '') == 'Slab' ? 'selected' : '' }}>
        Slab
    </option>

    <option value="EMI"
        {{ old('calculation_type', $rule->calculation_type ?? '') == 'EMI' ? 'selected' : '' }}>
        EMI
    </option>

</select>
            </div>

            <!-- Calculation Base -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Calculation Base</label>
               <select name="calculation_base" class="form-select">

    <option value=""
        {{ old('calculation_base', $rule->calculation_base ?? '') == '' ? 'selected' : '' }}>
        Select
    </option>

    <option value="Basic" {{ old('calculation_base', $rule->calculation_base ?? '') == 'Basic' ? 'selected' : '' }}>Basic</option>
    <option value="Gross" {{ old('calculation_base', $rule->calculation_base ?? '') == 'Gross' ? 'selected' : '' }}>Gross</option>
    <option value="CTC" {{ old('calculation_base', $rule->calculation_base ?? '') == 'CTC' ? 'selected' : '' }}>CTC</option>
    <option value="Net" {{ old('calculation_base', $rule->calculation_base ?? '') == 'Net' ? 'selected' : '' }}>Net</option>

</select>
            </div>

            <!-- Calculation Value -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Calculation Value</label>
                <input type="number" name="calculation_value" class="form-control"
                    value="{{ old('calculation_value', $rule->calculation_value ?? '') }}">
            </div>

            <!-- Applies On -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Applies On *</label>
              <select name="calculation_applies_on" class="form-select" required>

    <option value=""
        {{ old('calculation_applies_on', $rule->calculation_applies_on ?? '') == '' ? 'selected' : '' }}>
        Select
    </option>

    <option value="Pre"
        {{ old('calculation_applies_on', $rule->calculation_applies_on ?? '') == 'Pre' ? 'selected' : '' }}>
        Gross (Pre-Allowance)
    </option>

    <option value="Post"
        {{ old('calculation_applies_on', $rule->calculation_applies_on ?? '') == 'Post' ? 'selected' : '' }}>
        Gross (Post-Allowance)
    </option>

</select>
            </div>

            <!-- Slab Reference -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Slab Reference</label>
             <input type="text" name="slab_reference" class="form-control"
    value="{{ old('slab_reference', $rule->slab_reference ?? '') }}">
            </div>

            <!-- Max Limit -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Maximum Limit</label>
          
<input type="number" name="maximum_limit" class="form-control"
    value="{{ old('maximum_limit', $rule->maximum_limit ?? '') }}">
            </div>

            <!-- Min Limit -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Minimum Limit</label>
               <input type="number" name="minimum_limit" class="form-control"
    value="{{ old('minimum_limit', $rule->minimum_limit ?? '') }}">

            </div>

            <!-- Rounding -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Rounding</label>
               <select name="rounding_rule" class="form-select">

    <option value=""
        {{ old('rounding_rule', $rule->rounding_rule ?? '') == '' ? 'selected' : '' }}>
        Select
    </option>

    <option value="Nearest" {{ old('rounding_rule', $rule->rounding_rule ?? '') == 'Nearest' ? 'selected' : '' }}>Nearest</option>
    <option value="Up" {{ old('rounding_rule', $rule->rounding_rule ?? '') == 'Up' ? 'selected' : '' }}>Up</option>
    <option value="Down" {{ old('rounding_rule', $rule->rounding_rule ?? '') == 'Down' ? 'selected' : '' }}>Down</option>

</select>
            </div>

            <!-- Effective Dates -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Effective From *</label>
               <input type="date" name="effective_from" class="form-control"
    value="{{ old('effective_from', isset($rule) ? \Carbon\Carbon::parse($rule->effective_from)->format('Y-m-d') : '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Effective To</label>
               <input type="date" name="effective_to" class="form-control"
    value="{{ old('effective_to', isset($rule) && $rule->effective_to ? \Carbon\Carbon::parse($rule->effective_to)->format('Y-m-d') : '') }}">
            </div>

        </div>

        <hr>

        <h6>Payroll Behaviour</h6>

        <div class="row">
            <div class="col-md-3 form-check">
                <input type="checkbox" name="prorata_applicable" value="1"
    {{ old('prorata_applicable', $rule->prorata_applicable ?? 0) ? 'checked' : '' }}>
                <label class="form-check-label">Prorata</label>
            </div>

            <div class="col-md-3 form-check">
             <input type="checkbox" name="lop_impact" value="1"
    {{ old('lop_impact', $rule->lop_impact ?? 0) ? 'checked' : '' }}>
                <label class="form-check-label">LOP Impact</label>
            </div>

            <div class="col-md-3 form-check">
           <input type="checkbox" name="editable_at_payroll" value="1"
    {{ old('editable_at_payroll', $rule->editable_at_payroll ?? 0) ? 'checked' : '' }}>

                <label class="form-check-label">Editable</label>
            </div>

            <div class="col-md-3 form-check">
            <input type="checkbox" name="skip_if_insufficient_salary" value="1"
    {{ old('skip_if_insufficient_salary', $rule->skip_if_insufficient_salary ?? 0) ? 'checked' : '' }}>
                <label class="form-check-label">Skip If Insufficient</label>
            </div>
        </div>

        <hr>

        <div class="row">

            <!-- Priority -->
            <div class="col-md-4 mb-3">
                <label class="form-label">Priority</label>
                <input type="number" name="priority" class="form-control"
    value="{{ old('priority', $rule->priority ?? '') }}">
            </div>

            <!-- Max % -->
            <div class="col-md-4 mb-3">
                <label class="form-label">Max % of Net Salary</label>
             <input type="number" name="max_percent_net_salary" class="form-control"
    value="{{ old('max_percent_net_salary', $rule->max_percent_net_salary ?? '') }}">
            </div>

            <!-- Status -->
            <div class="col-md-4 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">

    <option value=""
        {{ old('status', $rule->status ?? '') == '' ? 'selected' : '' }}>
        Select
    </option>

    <option value="active" {{ old('status', $rule->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
    <option value="inactive" {{ old('status', $rule->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>

</select>
            </div>

        </div>

        <!-- Remarks -->
        <div class="mb-3">
            <label class="form-label">Remarks</label>
            <textarea name="remarks" class="form-control">{{ old('remarks', $rule->remarks ?? '') }}</textarea>
        </div>

    </div>
</div>

<div class="mt-3 d-flex justify-content-end gap-2">

    <button type="submit" class="btn btn-primary btn-sm px-4">
        <i class="feather-save me-1"></i> Save
    </button>

    <a href="{{ route('hr.payroll.deduction-rule-set.index') }}"
       class="btn btn-light btn-sm px-4">
        Cancel
    </a>

</div>
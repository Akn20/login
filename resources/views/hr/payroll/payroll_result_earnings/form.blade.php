@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<div class="page-header mb-4 d-flex justify-content-between">
     <h5>Add Earning</h5>
<a href="{{ route('hr.payroll.payroll-result-earnings.index') }}"
       class="btn btn-secondary btn-sm">
        Back
    </a></div>
{{-- DUMMY Payroll Result ID --}}
<input type="hidden" name="payroll_result_id" value="1">

<div class="row">

    <!-- Code -->
    <div class="col-md-6 mb-3">
        <label>Earning Code *</label>
        <input type="text" name="earning_code" class="form-control"
            value="{{ old('earning_code', $record->earning_code ?? '') }}">
    </div>

    <!-- Name -->
    <div class="col-md-6 mb-3">
        <label>Earning Name *</label>
        <input type="text" name="earning_name" class="form-control"
            value="{{ old('earning_name', $record->earning_name ?? '') }}">
    </div>

    <!-- Type -->
    <div class="col-md-6 mb-3">
        <label>Earning Type *</label>
        <select name="earning_type" class="form-control">
            <option value="Fixed"
                {{ old('earning_type', $record->earning_type ?? '') == 'Fixed' ? 'selected' : '' }}>
                Fixed
            </option>
            <option value="Variable"
                {{ old('earning_type', $record->earning_type ?? '') == 'Variable' ? 'selected' : '' }}>
                Variable
            </option>
            <option value="OT"
                {{ old('earning_type', $record->earning_type ?? '') == 'OT' ? 'selected' : '' }}>
                OT
            </option>
        </select>
    </div>

</div>

<hr>

<h6>Calculation</h6>

<div class="row">

    <!-- Base -->
    <div class="col-md-6 mb-3">
        <label>Calculation Base</label>
        <select name="calculation_base" class="form-control" id="calculation_base">
            <option value="">Select</option>

            <option value="basic"
                {{ old('calculation_base', $record->calculation_base ?? '') == 'basic' ? 'selected' : '' }}>
                Basic
            </option>

            <option value="gross"
                {{ old('calculation_base', $record->calculation_base ?? '') == 'gross' ? 'selected' : '' }}>
                Gross
            </option>
        </select>
    </div>

    <!-- Value -->
    <div class="col-md-6 mb-3">
        <label>Calculation Value (%)</label>
        <input type="number" step="0.01" name="calculation_value" class="form-control"
            id="calculation_value"
            value="{{ old('calculation_value', $record->calculation_value ?? '') }}">
    </div>

    <!-- Amount -->
    <div class="col-md-6 mb-3">
        <label>Amount *</label>
        <input type="number" step="0.01" name="amount" class="form-control"
            id="amount"
            value="{{ old('amount', $record->amount ?? '') }}">
    </div>

</div>

<hr>

<h6>Statutory</h6>

<div class="row">

    <div class="col-md-4">
        <label>Taxable</label>
        <select name="taxable" class="form-control">
            <option value="1"
                {{ old('taxable', $record->taxable ?? '') == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0"
                {{ old('taxable', $record->taxable ?? '') == 0 ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>PF Applicable</label>
        <select name="pf_applicable" class="form-control">
            <option value="1"
                {{ old('pf_applicable', $record->pf_applicable ?? '') == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0"
                {{ old('pf_applicable', $record->pf_applicable ?? '') == 0 ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>ESI Applicable</label>
        <select name="esi_applicable" class="form-control">
            <option value="1"
                {{ old('esi_applicable', $record->esi_applicable ?? '') == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0"
                {{ old('esi_applicable', $record->esi_applicable ?? '') == 0 ? 'selected' : '' }}>No</option>
        </select>
    </div>

</div>

<hr>

<div class="col-md-4 mb-3">
    <label>Display Order</label>
    <input type="number" name="display_order" class="form-control"
        value="{{ old('display_order', $record->display_order ?? '') }}">
</div>

<hr>

<div class="d-flex justify-content-end">
    <button class="btn btn-primary">Save</button>
</div>


{{-- 🔥 AUTO CALCULATION SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const baseSelect = document.getElementById('calculation_base');
    const valueInput = document.getElementById('calculation_value');
    const amountInput = document.getElementById('amount');

    // 🔹 Dummy values (replace later with real data)
    const baseValues = {
        basic: 20000,
        gross: 30000
    };

    function calculateAmount() {
        let baseKey = baseSelect.value;
        let baseAmount = baseValues[baseKey] || 0;
        let percent = parseFloat(valueInput.value) || 0;

        if (baseAmount > 0 && percent > 0) {
            let result = (baseAmount * percent) / 100;
            amountInput.value = result.toFixed(2);
        }
    }

    baseSelect.addEventListener('change', calculateAmount);
    valueInput.addEventListener('input', calculateAmount);

});
</script>
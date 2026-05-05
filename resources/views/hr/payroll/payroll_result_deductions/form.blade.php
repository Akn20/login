@if ($errors->any())

<div class="alert alert-danger">
    <ul class="mb-0">

        @foreach ($errors->all() as $error)

        <li>{{ $error }}</li>

        @endforeach

    </ul>
</div>

@endif


<div class="page-header mb-4 d-flex justify-content-between">

    <h5>
        {{ isset($record) ? 'Edit Deduction' : 'Add Deduction' }}
    </h5>

    <a href="{{ route('hr.payroll.payroll-result-deductions.index') }}"
       class="btn btn-secondary btn-sm">
        Back
    </a>

</div>

<div class="card">
    <div class="card-body">


{{-- PAYROLL RESULT --}}
<div class="col-md-6 mb-3">

    <label>Payroll Result *</label>

    <select name="payroll_result_id"
            class="form-control"
            id="payroll_result_id">

        <option value="">Select</option>

        @foreach($payrollResults as $result)

        <option value="{{ $result->id }}"
            {{ old('payroll_result_id', $record->payroll_result_id ?? '') == $result->id ? 'selected' : '' }}>

            {{ $result->payroll_month }}
            -
            {{ $result->staff_id }}

        </option>

        @endforeach

    </select>

</div>


<div class="row">

    {{-- DEDUCTION CODE --}}
    <div class="col-md-6 mb-3">

        <label>Deduction Code *</label>

        <input type="text"
               name="deduction_code"
               class="form-control"
               value="{{ old('deduction_code', $record->deduction_code ?? '') }}">

    </div>


    {{-- DEDUCTION NAME --}}
    <div class="col-md-6 mb-3">

        <label>Deduction Name *</label>

        <input type="text"
               name="deduction_name"
               class="form-control"
               value="{{ old('deduction_name', $record->deduction_name ?? '') }}">

    </div>


    {{-- DEDUCTION TYPE --}}
    <div class="col-md-6 mb-3">

        <label>Deduction Type *</label>

        <select name="deduction_type"
                class="form-control"
                id="deduction_type">

            <option value="Fixed"
                {{ old('deduction_type', $record->deduction_type ?? '') == 'Fixed' ? 'selected' : '' }}>

                Fixed

            </option>

            <option value="Variable"
                {{ old('deduction_type', $record->deduction_type ?? '') == 'Variable' ? 'selected' : '' }}>

                Variable

            </option>

            <option value="Statutory"
                {{ old('deduction_type', $record->deduction_type ?? '') == 'Statutory' ? 'selected' : '' }}>

                Statutory

            </option>

        </select>

    </div>


    {{-- RULE SET CODE --}}
    <div class="col-md-6 mb-3">

      <select name="rule_set_code" class="form-control" id="rule_set_code">

    <option value="">Select Rule</option>

    @foreach($ruleSets as $rule)

        <option value="{{ $rule->rule_set_code }}"
            {{ old('rule_set_code', $record->rule_set_code ?? '') == $rule->rule_set_code ? 'selected' : '' }}>

            {{ $rule->rule_set_name }}

        </option>

    @endforeach

</select>

    </div>

</div>


<hr>

<h6>Calculation</h6>

<div class="row">

    {{-- CALCULATION BASE --}}
    <div class="col-md-6 mb-3">

        <label>Calculation Base</label>

        <select name="calculation_base"
                class="form-control"
                id="calculation_base">

            <option value="">Select</option>

            <option value="Gross"
                {{ old('calculation_base', $record->calculation_base ?? '') == 'Gross' ? 'selected' : '' }}>

                Gross Earnings

            </option>

        </select>

    </div>


    {{-- CALCULATION LOGIC --}}
    <div class="col-md-6 mb-3">

        <label>Calculation Logic</label>

        <select name="calculation_logic"
                class="form-control"
                id="calculation_logic">

            <option value="">Select</option>

            <option value="%"
                {{ old('calculation_logic', $record->calculation_logic ?? '') == '%' ? 'selected' : '' }}>

                Percentage (%)

            </option>

            <option value="Slab"
                {{ old('calculation_logic', $record->calculation_logic ?? '') == 'Slab' ? 'selected' : '' }}>

                Slab

            </option>

            <option value="EMI"
                {{ old('calculation_logic', $record->calculation_logic ?? '') == 'EMI' ? 'selected' : '' }}>

                EMI

            </option>

        </select>

    </div>


    {{-- CALCULATION VALUE --}}
    <div class="col-md-6 mb-3">

        <label>Calculation Value</label>

        <input type="number"
               step="0.01"
               name="calculation_value"
               id="calculation_value"
               class="form-control"
               value="{{ old('calculation_value', $record->calculation_value ?? '') }}">

    </div>


    {{-- AMOUNT --}}
    <div class="col-md-6 mb-3">

        <label>Amount *</label>

        <input type="number"
               step="0.01"
               name="amount"
               id="amount"
               class="form-control"
               value="{{ old('amount', $record->amount ?? '') }}">

    </div>

</div>


<hr>

<h6>Control</h6>

<div class="row">

    {{-- EDITABLE --}}
    <div class="col-md-6 mb-3">

        <label>Editable Flag *</label>

        <select name="editable_flag"
                class="form-control">

            <option value="1"
                {{ old('editable_flag', $record->editable_flag ?? '') == 1 ? 'selected' : '' }}>

                Yes

            </option>

            <option value="0"
                {{ old('editable_flag', $record->editable_flag ?? '') == 0 ? 'selected' : '' }}>

                No

            </option>

        </select>

    </div>


    {{-- DISPLAY ORDER --}}
    <div class="col-md-6 mb-3">

        <label>Display Order</label>

        <input type="number"
               name="display_order"
               class="form-control"
               value="{{ old('display_order', $record->display_order ?? '') }}">

    </div>

</div>


<hr>

<div class="d-flex justify-content-end">

    <button class="btn btn-primary">
        Save
    </button>

</div>
  </div>
</div>


{{-- AUTO CALCULATION --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const payrollResultSelect = document.getElementById('payroll_result_id');
    const deductionType       = document.getElementById('deduction_type');
    const ruleSetSelect       = document.getElementById('rule_set_code');

    const calculationBase     = document.getElementById('calculation_base');
    const calculationLogic    = document.getElementById('calculation_logic');
    const calculationValue    = document.getElementById('calculation_value');

    const amountInput         = document.getElementById('amount');

    // 🔥 REAL DATA FROM BACKEND
    const payrollData = @json($payrollResults->keyBy('id'));
    const ruleSets    = @json($ruleSets->keyBy('rule_set_code'));

    // ✅ ENABLE / DISABLE FIELDS
    function toggleCalculationFields() {

        let isFixed = deductionType.value === 'Fixed';

        calculationBase.disabled  = isFixed;
        calculationLogic.disabled = isFixed;
        calculationValue.disabled = isFixed;

        if (isFixed) {
            calculationBase.value  = '';
            calculationLogic.value = '';
            calculationValue.value = '';
        }
    }

    // ✅ GET BASE AMOUNT (from Payroll Result)
    function getBaseAmount() {

        let payrollId = payrollResultSelect.value;

        if (!payrollId) return 0;

        let payroll = payrollData[payrollId];

        if (!payroll) return 0;

        // currently using Gross Earnings
        return parseFloat(payroll.gross_earnings || 0);
    }

    // ✅ AUTO-FILL FROM RULE SET
    function applyRuleSet() {

        let selected = ruleSets[ruleSetSelect.value];

        if (!selected) return;

        // fill fields
        calculationLogic.value = selected.calculation_type || '';
        calculationBase.value  = selected.calculation_base || '';
        calculationValue.value = selected.calculation_value || '';

        calculateAmount();
    }

    // ✅ MAIN CALCULATION
    function calculateAmount() {

        // Fixed → manual entry only
        if (deductionType.value === 'Fixed') {
            return;
        }

        let logic = calculationLogic.value;
        let value = parseFloat(calculationValue.value);
        let baseAmount = getBaseAmount();

        if (!logic || isNaN(value)) {
            return;
        }

        // % LOGIC
        if (logic === '%') {

            let result = (baseAmount * value) / 100;

            amountInput.value = result.toFixed(2);
        }

        // EMI LOGIC (fixed monthly deduction)
        else if (logic === 'EMI') {

            amountInput.value = value.toFixed(2);
        }

        // SLAB (TEMP FIX)
        else if (logic === 'Slab') {

            // until slab module integrated
            amountInput.value = value.toFixed(2);
        }
    }

    // INIT
    toggleCalculationFields();

    // EVENTS
    deductionType.addEventListener('change', function () {
        toggleCalculationFields();
        calculateAmount();
    });

    ruleSetSelect.addEventListener('change', applyRuleSet);

    payrollResultSelect.addEventListener('change', calculateAmount);
    calculationBase.addEventListener('change', calculateAmount);
    calculationLogic.addEventListener('change', calculateAmount);
    calculationValue.addEventListener('input', calculateAmount);

});
</script>
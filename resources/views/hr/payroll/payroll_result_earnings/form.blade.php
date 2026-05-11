@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>
        <h5 class="mb-1">
            {{ isset($record) ? 'Edit Earning' : 'Add Earning' }}
        </h5>
    </div>

    <a href="{{ route('hr.payroll.payroll-result-earnings.index') }}"
       class="btn btn-secondary btn-sm">
        Back
    </a>

</div>

<div class="card">
<div class="card-body">

<div class="row">

    {{-- PAYROLL RESULT --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Payroll Result *</label>

        <select name="payroll_result_id"
                class="form-control">

            <option value="">Select Payroll Result</option>

            @foreach($payrollResults as $result)

            <option value="{{ $result->id }}"
                {{ old('payroll_result_id', $record->payroll_result_id ?? '') == $result->id ? 'selected' : '' }}>

                {{ $result->payroll_month }}
                -
                {{ $result->payroll_run_id }}
                -
                Staff: {{ $result->staff_id }}

            </option>

            @endforeach

        </select>
    </div>

</div>

<hr>

<h6 class="mb-3">Earning Details</h6>

<div class="row">

    {{-- CODE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Earning Code *</label>

        <input type="text"
               name="earning_code"
               class="form-control"
               value="{{ old('earning_code', $record->earning_code ?? '') }}">
    </div>

    {{-- NAME --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Earning Name *</label>

        <input type="text"
               name="earning_name"
               class="form-control"
               value="{{ old('earning_name', $record->earning_name ?? '') }}">
    </div>

    {{-- TYPE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Earning Type *</label>

        <select name="earning_type"
                class="form-control"
                id="earning_type">

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

<h6 class="mb-3">Calculation</h6>

<div class="row">

    {{-- BASE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Calculation Base</label>

        <select name="calculation_base"
                class="form-control"
                id="calculation_base">

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

    {{-- VALUE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">
            Calculation Value (%)
        </label>

        <input type="number"
               step="0.01"
               name="calculation_value"
               class="form-control"
               id="calculation_value"
               value="{{ old('calculation_value', $record->calculation_value ?? '') }}">
    </div>

    {{-- AMOUNT --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Amount *</label>

        <input type="number"
               step="0.01"
               name="amount"
               class="form-control"
               id="amount"
               value="{{ old('amount', $record->amount ?? '') }}">
    </div>

</div>

<hr>

<h6 class="mb-3">Statutory Flags</h6>

<div class="row">

    {{-- TAXABLE --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Taxable</label>

        <select name="taxable"
                class="form-control">

            <option value="1"
                {{ old('taxable', $record->taxable ?? 1) == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ old('taxable', $record->taxable ?? 1) == 0 ? 'selected' : '' }}>
                No
            </option>

        </select>
    </div>

    {{-- PF --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">PF Applicable</label>

        <select name="pf_applicable"
                class="form-control">

            <option value="1"
                {{ old('pf_applicable', $record->pf_applicable ?? 0) == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ old('pf_applicable', $record->pf_applicable ?? 0) == 0 ? 'selected' : '' }}>
                No
            </option>

        </select>
    </div>

    {{-- ESI --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">ESI Applicable</label>

        <select name="esi_applicable"
                class="form-control">

            <option value="1"
                {{ old('esi_applicable', $record->esi_applicable ?? 0) == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ old('esi_applicable', $record->esi_applicable ?? 0) == 0 ? 'selected' : '' }}>
                No
            </option>

        </select>
    </div>

</div>

<hr>

<div class="row">

    {{-- DISPLAY ORDER --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Display Order</label>

        <input type="number"
               name="display_order"
               class="form-control"
               value="{{ old('display_order', $record->display_order ?? '') }}">
    </div>

</div>

<hr>

<div class="d-flex justify-content-end">
    <button class="btn btn-primary">
        {{ isset($record) ? 'Update' : 'Save' }}
    </button>
</div>

</div>
</div>

{{-- AUTO CALCULATION --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const payrollResultSelect =
        document.querySelector('[name="payroll_result_id"]');

    const earningType =
        document.getElementById('earning_type');

    const baseSelect =
        document.getElementById('calculation_base');

    const valueInput =
        document.getElementById('calculation_value');

    const amountInput =
        document.getElementById('amount');

    // ✅ FLAG to stop recalculation
    let isManualAmount = false;

    // PAYROLL RESULT DATA
    const payrollData = @json(
        $payrollResults->keyBy('id')
    );

    function getBaseAmount() {

        let payrollId = payrollResultSelect.value;
        let baseKey = baseSelect.value;

        if (!payrollId || !baseKey) return 0;

        let payroll = payrollData[payrollId];

        if (!payroll) return 0;

        if (baseKey === 'basic') {
            return parseFloat(payroll.fixed_earnings_total || 0);
        }

        if (baseKey === 'gross') {
            return parseFloat(payroll.gross_earnings || 0);
        }

        return 0;
    }

    function calculateAmount() {

        // ❌ stop if user manually edited
        if (isManualAmount) return;

        if (earningType.value === 'Fixed') return;

        let baseAmount = getBaseAmount();
        let percent = parseFloat(valueInput.value);

        if (!baseAmount || isNaN(percent)) return;

        let result = (baseAmount * percent) / 100;

        amountInput.value = result.toFixed(2);
    }

    function toggleCalculationFields() {

        let isFixed = earningType.value === 'Fixed';

        baseSelect.disabled = isFixed;
        valueInput.disabled = isFixed;

        if (isFixed) {
            baseSelect.value = '';
            valueInput.value = '';
        }
    }

    // 🔥 If user types manually → lock auto calc
    amountInput.addEventListener('input', function () {
        isManualAmount = true;
    });

    // 🔄 If user changes calculation → unlock auto calc
    baseSelect.addEventListener('change', function () {
        isManualAmount = false;
        calculateAmount();
    });

    valueInput.addEventListener('input', function () {
        isManualAmount = false;
        calculateAmount();
    });

    payrollResultSelect.addEventListener('change', function () {
        isManualAmount = false;
        calculateAmount();
    });

    earningType.addEventListener('change', function () {
        isManualAmount = false;
        toggleCalculationFields();
        calculateAmount();
    });

    toggleCalculationFields();

});

</script>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<input type="hidden" name="payroll_result_id" value="1">

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Deduction Code *</label>
        <input type="text"
               name="deduction_code"
               class="form-control"
               value="{{ old('deduction_code', $record->deduction_code ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Deduction Name *</label>
        <input type="text"
               name="deduction_name"
               class="form-control"
               value="{{ old('deduction_name', $record->deduction_name ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Deduction Type *</label>

        <select name="deduction_type" class="form-control">

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

    <div class="col-md-6 mb-3">
        <label>Rule Set Code</label>

        <input type="text"
               name="rule_set_code"
               class="form-control"
               value="{{ old('rule_set_code', $record->rule_set_code ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Calculation Logic *</label>

        <select name="calculation_logic" class="form-control">

            <option value="%"
                {{ old('calculation_logic', $record->calculation_logic ?? '') == '%' ? 'selected' : '' }}>
                %
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

    <div class="col-md-6 mb-3">
        <label>Amount *</label>

        <input type="number"
               step="0.01"
               name="amount"
               class="form-control"
               value="{{ old('amount', $record->amount ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Editable Flag *</label>

        <select name="editable_flag" class="form-control">

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
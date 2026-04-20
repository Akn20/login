
<div class="row">

    <!-- Employee -->
    <div class="col-md-6 mb-3">
        <label>Employee *</label>
        <select name="employee_id" class="form-control">
            <option value="">Select</option>
            @foreach($employees as $id => $name)
                <option value="{{ $id }}"
                    {{ old('employee_id', $record->employee_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Salary Structure -->
    <div class="col-md-6 mb-3">
        <label>Salary Structure *</label>
        <select name="salary_structure_id" class="form-control">
            <option value="">Select</option>
            @foreach($structures as $id => $name)
                <option value="{{ $id }}"
                    {{ old('salary_structure_id', $record->salary_structure_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Salary Amount -->
    <div class="col-md-6 mb-3">
        <label>Salary Amount *</label>
        <input type="number" name="salary_amount" class="form-control"
            value="{{ old('salary_amount', $record->salary_amount ?? '') }}">
    </div>

    <!-- Salary Basis -->
    <div class="col-md-6 mb-3">
        <label>Salary Basis *</label>
        <select name="salary_basis" class="form-control">
            <option value="Ctc" {{ old('salary_basis') == 'Ctc' ? 'selected' : '' }}>Ctc</option>
            <option value="Gross" {{ old('salary_basis') == 'Gross' ? 'selected' : '' }}>Gross</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
    <label>Currency *</label>
   <select name="currency" class="form-control">
    <option value="">Select Currency</option>

    <option value="INR"
        {{ old('currency', $record->currency ?? '') == 'INR' ? 'selected' : '' }}>
        INR
    </option>

    <option value="USD"
        {{ old('currency', $record->currency ?? '') == 'USD' ? 'selected' : '' }}>
        USD
    </option>
</select>
</div>
<div class="col-md-6 mb-3">
    <label>Status *</label>
    <select name="status" class="form-control">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
</div>

    <!-- Pay Frequency -->
    <div class="col-md-6 mb-3">
        <label>Pay Frequency *</label>
       <select name="pay_frequency" class="form-control">

    <option value="Monthly"
        {{ old('pay_frequency', $record->pay_frequency ?? '') == 'Monthly' ? 'selected' : '' }}>
        Monthly
    </option>

    <option value="Weekly"
        {{ old('pay_frequency', $record->pay_frequency ?? '') == 'Weekly' ? 'selected' : '' }}>
        Weekly
    </option>

</select>
    </div>

</div>

<hr>

<h6>Date Range</h6>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Effective From *</label>
        <input type="date" name="effective_from" class="form-control"
            value="{{ old('effective_from', $record->effective_from ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Effective To</label>
        <input type="date" name="effective_to" class="form-control"
            value="{{ old('effective_to', $record->effective_to ?? '') }}">
    </div>
</div>

<hr>

<h6>Work Conditions</h6>

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
    <label>Work Types</label>

   @php
    $selectedWorkTypes = old(
        'allowed_work_types',
        isset($record->allowed_work_types)
            ? json_decode($record->allowed_work_types, true)
            : []
    );
@endphp

<select name="allowed_work_types[]" multiple class="form-control">
    @foreach($workTypes as $id => $name)
        <option value="{{ $id }}"
            {{ in_array($id, $selectedWorkTypes ?? []) ? 'selected' : '' }}>
            {{ $name }}
        </option>
    @endforeach
</select>
@error('allowed_work_types')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>

    <div class="col-md-6 mb-3">
        <label>Overtime Eligible</label>
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

<div class="d-flex justify-content-end gap-2">
    
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const hourlyDropdown = document.querySelector('[name="hourly_pay_eligible"]');
    const workTypeDropdown = document.querySelector('[name="allowed_work_types[]"]');

    function toggleWorkTypes() {

        if (!hourlyDropdown || !workTypeDropdown) return;

        if (hourlyDropdown.value == "1") {
            workTypeDropdown.disabled = false;
        } else {
            workTypeDropdown.disabled = true;

            // clear selection properly
            Array.from(workTypeDropdown.options).forEach(option => option.selected = false);
        }
    }

    // run on page load
    toggleWorkTypes();

    // run on change
    hourlyDropdown.addEventListener('change', toggleWorkTypes);

});
</script>
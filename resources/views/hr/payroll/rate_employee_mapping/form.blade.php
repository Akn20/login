{{-- ================= IDENTIFICATION ================= --}}

<div class="card mb-3">

<div class="card-header">
Identification Details
</div>

<div class="card-body">

<div class="row">

{{-- Rule Set Code --}}
<div class="col-md-6 mb-3">

<label class="form-label">
Rule Set Code *
</label>

<select name="rule_set_code"
id="rule_set_code"
class="form-select"
required>

<option value="">
Select Rule Set Code
</option>

@foreach($ruleSets ?? [] as $rule)

<option value="{{ $rule->rule_set_code }}"
data-name="{{ $rule->rule_set_name }}"
@if(old('rule_set_code', $rateMapping->rule_set_code ?? '') == $rule->rule_set_code)
selected
@endif>

{{ $rule->rule_set_code }} — {{ $rule->rule_set_name }}

</option>

@endforeach

</select>

</div>



{{-- Rule Set Name --}}
<div class="col-md-6 mb-3">

<label class="form-label">
Rule Set Name *
</label>

<input type="text"
name="rule_set_name"
id="rule_set_name"
class="form-control"
value="{{ old('rule_set_name', $rateMapping->rule_set_name ?? '') }}"
required>

</div>

</div>



<div class="row">

{{-- Work Type --}}
<div class="col-md-6 mb-3">

<label class="form-label">
Work Type *
</label>

<select name="work_type_code"
class="form-select"
required>

<option value="">
Select Work Type
</option>

@foreach($workTypes ?? [] as $workType)

<option value="{{ $workType->code }}"
@if(old('work_type_code', $rateMapping->work_type_code ?? '') == $workType->code)
selected
@endif>

{{ $workType->code }} — {{ $workType->name }}

</option>

@endforeach

</select>

</div>

</div>

</div>

</div>



{{-- ================= CALCULATION LOGIC ================= --}}

<div class="card mb-3">

<div class="card-header">
Calculation Logic
</div>

<div class="card-body">

<div class="row">

{{-- Rate Type --}}
<div class="col-md-4 mb-3">

<label class="form-label">
Rate Type *
</label>

<select name="rate_type"
class="form-select"
required>

<option value="">Select Rate Type</option>

<option value="Flat"
@if(old('rate_type', $rateMapping->rate_type ?? '') == 'Flat')
selected
@endif>
Flat
</option>

<option value="Multiplier"
@if(old('rate_type', $rateMapping->rate_type ?? '') == 'Multiplier')
selected
@endif>
Multiplier
</option>

</select>

</div>



{{-- Base Rate Source --}}
<div class="col-md-4 mb-3">

<label class="form-label">
Base Rate Source *
</label>

<select name="base_rate_source"
class="form-select"
required>

<option value="">Select Source</option>

<option value="Employee Rate"
@if(old('base_rate_source', $rateMapping->base_rate_source ?? '') == 'Employee Rate')
selected
@endif>
Employee Rate
</option>

<option value="Rule Rate"
@if(old('base_rate_source', $rateMapping->base_rate_source ?? '') == 'Rule Rate')
selected
@endif>
Rule Rate
</option>

</select>

</div>



{{-- Base Rate Value --}}
<div class="col-md-4 mb-3">

<label class="form-label">
Base Rate Value
</label>

<input type="number"
step="0.01"
name="base_rate_value"
class="form-control"
value="{{ old('base_rate_value', $rateMapping->base_rate_value ?? '') }}">

</div>

</div>



<div class="row">

{{-- Multiplier --}}
<div class="col-md-4 mb-3">

<label class="form-label">
Multiplier Value
</label>

<input type="number"
step="0.01"
name="multiplier_value"
class="form-control"
value="{{ old('multiplier_value', $rateMapping->multiplier_value ?? '') }}">

</div>



{{-- Maximum Hours --}}
<div class="col-md-4 mb-3">

<label class="form-label">
Maximum Hours
</label>

<input type="number"
name="maximum_hours"
class="form-control"
value="{{ old('maximum_hours', $rateMapping->maximum_hours ?? '') }}">

</div>



{{-- Round Off --}}
<div class="col-md-4 mb-3">

<label class="form-label">
Round Off Rule
</label>

<select name="round_off_rule"
class="form-select">

<option value="">Select Rule</option>

<option value="Nearest"
@if(old('round_off_rule', $rateMapping->round_off_rule ?? '') == 'Nearest')
selected
@endif>
Nearest
</option>

<option value="Up"
@if(old('round_off_rule', $rateMapping->round_off_rule ?? '') == 'Up')
selected
@endif>
Up
</option>

<option value="Down"
@if(old('round_off_rule', $rateMapping->round_off_rule ?? '') == 'Down')
selected
@endif>
Down
</option>

</select>

</div>

</div>

</div>

</div>



{{-- ================= APPLICABILITY ================= --}}

<div class="card mb-3">

<div class="card-header">
Applicability
</div>

<div class="card-body">

<div class="row">

{{-- Employee Type --}}
<div class="col-md-4 mb-3">

<label class="form-label">
Employee Type *
</label>

<select name="employee_type"
class="form-select"
required>

<option value="">
Select Type
</option>

@foreach($employeeTypes ?? [] as $type)

<option value="{{ $type }}"
@if(old('employee_type', $rateMapping->employee_type ?? '') == $type)
selected
@endif>

{{ $type }}

</option>

@endforeach

</select>

</div>



{{-- Employee --}}
<div class="col-md-4 mb-3">

<label class="form-label">
Employee
</label>

<select name="employee_id"
class="form-select">

<option value="">
Select Employee
</option>

@foreach($employees ?? [] as $employee)

<option value="{{ $employee->id }}"
@if(old('employee_id', $rateMapping->employee_id ?? '') == $employee->id)
selected
@endif>

{{ $employee->name }}

</option>

@endforeach

</select>

</div>



{{-- Employee Category --}}
<div class="col-md-4 mb-3">

<label class="form-label">
Employee Category
</label>

<select name="employee_category"
class="form-select">

<option value="">
Select Category
</option>

@foreach($employeeCategories ?? [] as $category)

<option value="{{ $category }}"
@if(old('employee_category', $rateMapping->employee_category ?? '') == $category)
selected
@endif>

{{ $category }}

</option>

@endforeach

</select>

</div>

</div>

</div>

</div>



{{-- ================= AUTO FILL SCRIPT ================= --}}

<script>

document.addEventListener("DOMContentLoaded", function () {

    const ruleCode =
        document.getElementById("rule_set_code");

    const ruleName =
        document.getElementById("rule_set_name");

    if (ruleCode) {

        ruleCode.addEventListener("change", function () {

            const selectedOption =
                ruleCode.options[ruleCode.selectedIndex];

            const name =
                selectedOption.getAttribute("data-name");

            if (name) {

                ruleName.value = name;

            }

        });

    }

});

</script>
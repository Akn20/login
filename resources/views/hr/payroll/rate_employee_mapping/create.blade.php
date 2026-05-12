@extends('layouts.admin')

@section('page-title', 'Add Rate Employee Mapping')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="row">
<div class="col-12">

<div class="card stretch stretch-full">

<!-- HEADER -->

<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">

<div>

<h5 class="mb-1">
Add Rate Employee Mapping
</h5>

<ul class="breadcrumb mb-0">

<li class="breadcrumb-item">
<a href="{{ route('admin.dashboard') }}">
Dashboard
</a>
</li>

<li class="breadcrumb-item">
<a href="{{ route('hr.payroll.rate-employee-mapping.index') }}">
Rate Employee Mapping
</a>
</li>

<li class="breadcrumb-item active">
Create
</li>

</ul>

</div>


<div class="d-flex align-items-center gap-2 flex-nowrap">

<button type="submit"
form="rateMappingForm"
class="btn btn-primary">
Save
</button>

<a href="{{ route('hr.payroll.rate-employee-mapping.index') }}"
class="btn btn-secondary">
Cancel
</a>

</div>

</div>



<!-- BODY -->

<div class="card-body">

<form 
id="rateMappingForm"
action="{{ route('hr.payroll.rate-employee-mapping.store') }}"
method="POST"
>

@csrf

@include('hr.payroll.rate_employee_mapping.form')

</form>

</div>

</div>

</div>

</div>

@endsection



<script>

document.addEventListener("DOMContentLoaded", function () {



/*
====================================
RULE SET AUTO-FILL  ✅ RESTORED
====================================
*/

const ruleSetDropdown =
document.querySelector('select[name="rule_set_code"]');

const ruleSetNameField =
document.querySelector('input[name="rule_set_name"]');

if (ruleSetDropdown && ruleSetNameField) {

ruleSetDropdown.addEventListener("change", function () {

let selectedText =
this.options[this.selectedIndex].text;

if (selectedText.includes('—')) {

let parts =
selectedText.split('—');

ruleSetNameField.value =
parts[1].trim();

}

});

}



/*
====================================
FIELD SELECTORS
====================================
*/

const rateTypeField =
document.querySelector('[name="rate_type"]');

const baseSourceField =
document.querySelector('[name="base_rate_source"]');

const baseRateField =
document.querySelector('[name="base_rate_value"]');

const multiplierField =
document.querySelector('[name="multiplier_value"]');

const maxHoursField =
document.querySelector('[name="maximum_hours"]');



/*
====================================
RATE TYPE + SOURCE LOGIC
====================================
*/

function handleFieldLogic() {

if (!rateTypeField) return;

let rateType =
rateTypeField.value;

let baseSource =
baseSourceField
? baseSourceField.value
: "";


/* FLAT */

if (rateType === "Flat") {

baseRateField.disabled = false;

multiplierField.disabled = true;
multiplierField.required = false;
multiplierField.value = "";

if (baseSource === "Rule Rate") {

baseRateField.required = true;

}
else {

baseRateField.required = false;

}

}


/* MULTIPLIER */

else if (rateType === "Multiplier") {

multiplierField.disabled = false;
multiplierField.required = true;

baseRateField.disabled = true;
baseRateField.required = false;
baseRateField.value = "";

}


/* DEFAULT */

else {

baseRateField.disabled = false;
multiplierField.disabled = false;

baseRateField.required = false;
multiplierField.required = false;

}

}




/*
====================================
NUMERIC VALIDATION
====================================
*/

function allowNumbersOnly(field) {

if (!field) return;

field.addEventListener("input", function () {

this.value =
this.value.replace(/[^0-9.]/g, '');

});

}

allowNumbersOnly(baseRateField);
allowNumbersOnly(multiplierField);
allowNumbersOnly(maxHoursField);



/*
====================================
MAX HOURS VALIDATION
====================================
*/

if (maxHoursField) {

maxHoursField.addEventListener("blur", function () {

if (
this.value &&
parseInt(this.value) < 1
) {

alert("Maximum Hours must be greater than 0");

this.value = "";

}

});

}



/*
====================================
EVENT BINDING
====================================
*/

if (rateTypeField) {

rateTypeField.addEventListener(
"change",
handleFieldLogic
);

}

if (baseSourceField) {

baseSourceField.addEventListener(
"change",
handleFieldLogic
);

}

handleFieldLogic();



});

</script>
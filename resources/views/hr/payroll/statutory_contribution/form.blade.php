{{-- ================= VALIDATION ERRORS ================= --}}

@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach ($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif



{{-- ================= BASIC DETAILS ================= --}}

<div class="card mb-4">

<div class="card-header">
<h6 class="mb-0">Basic Details</h6>
</div>

<div class="card-body">
<div class="row">


{{-- Contribution Code --}}
<div class="col-md-4 mb-3">

<label>Contribution Code *</label>

<input type="text"
name="contribution_code"
class="form-control"
value="{{ old('contribution_code', $statutoryContribution->contribution_code ?? '') }}"
required>

</div>



{{-- Contribution Name --}}
<div class="col-md-4 mb-3">

<label>Contribution Name *</label>

<input type="text"
name="contribution_name"
class="form-control"
value="{{ old('contribution_name', $statutoryContribution->contribution_name ?? '') }}"
required>

</div>



{{-- Statutory Category --}}
<div class="col-md-4 mb-3">

<label>Statutory Category *</label>

<select name="statutory_category"
class="form-control"
required>

<option value="">Select Category</option>

<option value="PF"
{{ old('statutory_category', $statutoryContribution->statutory_category ?? '') == 'PF' ? 'selected' : '' }}>
PF
</option>

<option value="ESI"
{{ old('statutory_category', $statutoryContribution->statutory_category ?? '') == 'ESI' ? 'selected' : '' }}>
ESI
</option>

<option value="PT"
{{ old('statutory_category', $statutoryContribution->statutory_category ?? '') == 'PT' ? 'selected' : '' }}>
PT
</option>

</select>

</div>



{{-- Rule Set Code --}}
<div class="col-md-4 mb-3">

<label>Rule Set Code *</label>

<select name="rule_set_code"
class="form-control"
required>

<option value="">Select Rule Set</option>

@foreach($ruleSets as $code)

<option value="{{ $code }}"
{{ old('rule_set_code', $statutoryContribution->rule_set_code ?? '') == $code ? 'selected' : '' }}>

{{ $code }}

</option>

@endforeach

</select>

</div>



{{-- Eligibility Flag --}}
<div class="col-md-4 mb-3">

<label>Eligibility Flag</label>

<select name="eligibility_flag"
class="form-control">

<option value="1"
{{ old('eligibility_flag', $statutoryContribution->eligibility_flag ?? '') == '1' ? 'selected' : '' }}>
Yes
</option>

<option value="0"
{{ old('eligibility_flag', $statutoryContribution->eligibility_flag ?? '') == '0' ? 'selected' : '' }}>
No
</option>

</select>

</div>



{{-- Status --}}
<div class="col-md-4 mb-3">

<label>Status *</label>

<select name="status"
class="form-control"
required>

<option value="Active"
{{ old('status', $statutoryContribution->status ?? '') == 'Active' ? 'selected' : '' }}>
Active
</option>

<option value="Inactive"
{{ old('status', $statutoryContribution->status ?? '') == 'Inactive' ? 'selected' : '' }}>
Inactive
</option>

</select>

</div>

</div>
</div>

</div>

{{-- ================= SALARY CONFIG ================= --}}

<div class="card mb-4">

<div class="card-header">
<h6 class="mb-0">Salary & State Configuration</h6>
</div>

<div class="card-body">
<div class="row">

{{-- Salary Ceiling Applicable --}}
<div class="col-md-4 mb-3">

<label>Salary Ceiling Applicable</label>

<select name="salary_ceiling_applicable"
        class="form-control">

<option value="1"
{{ old('salary_ceiling_applicable',
$statutoryContribution->salary_ceiling_applicable ?? '') == '1'
? 'selected' : '' }}>
Yes
</option>

<option value="0"
{{ old('salary_ceiling_applicable',
$statutoryContribution->salary_ceiling_applicable ?? '') == '0'
? 'selected' : '' }}>
No
</option>

</select>

</div>


{{-- Salary Ceiling Amount --}}
<div class="col-md-4 mb-3">

<label>Salary Ceiling Amount</label>

<input type="number"
name="salary_ceiling_amount"
class="form-control"
value="{{ old('salary_ceiling_amount',
$statutoryContribution->salary_ceiling_amount ?? '') }}">

</div>


{{-- State Applicable --}}
<div class="col-md-4 mb-3">

<label>State Applicable</label>

<select name="state_applicable"
        class="form-control">

<option value="1"
{{ old('state_applicable',
$statutoryContribution->state_applicable ?? '') == '1'
? 'selected' : '' }}>
Yes
</option>

<option value="0"
{{ old('state_applicable',
$statutoryContribution->state_applicable ?? '') == '0'
? 'selected' : '' }}>
No
</option>

</select>

</div>

{{-- Applicable States (MULTI SELECT) --}}
<div class="col-md-12 mb-3">

<label>Applicable States</label>

@php

$selectedStates = [];

/* Decode JSON when editing */
if(isset($statutoryContribution->applicable_states)) {

$selectedStates =
json_decode(
$statutoryContribution->applicable_states,
true
) ?? [];

}

@endphp

<select name="applicable_states[]"
        class="form-control"
        multiple
        size="5">


<option value="KA"
{{ in_array('KA', old('applicable_states', $selectedStates)) ? 'selected' : '' }}>
Karnataka
</option>


<option value="TN"
{{ in_array('TN', old('applicable_states', $selectedStates)) ? 'selected' : '' }}>
Tamil Nadu
</option>


<option value="KL"
{{ in_array('KL', old('applicable_states', $selectedStates)) ? 'selected' : '' }}>
Kerala
</option>


<option value="AP"
{{ in_array('AP', old('applicable_states', $selectedStates)) ? 'selected' : '' }}>
Andhra Pradesh
</option>


<option value="TS"
{{ in_array('TS', old('applicable_states', $selectedStates)) ? 'selected' : '' }}>
Telangana
</option>


</select>

<small class="text-muted">
Hold Ctrl to select multiple states
</small>

</div>

</div>
</div>

</div>



{{-- ================= PAYROLL ================= --}}

<div class="card mb-4">

<div class="card-header">
<h6 class="mb-0">Payroll Behaviour</h6>
</div>

<div class="card-body">
<div class="row">


{{-- Prorata --}}
<div class="col-md-4 mb-3">

<label>Prorata Applicable</label>

<select name="prorata_applicable"
class="form-control">

<option value="1"
{{ old('prorata_applicable', $statutoryContribution->prorata_applicable ?? '') == '1' ? 'selected' : '' }}>
Yes
</option>

<option value="0"
{{ old('prorata_applicable', $statutoryContribution->prorata_applicable ?? '') == '0' ? 'selected' : '' }}>
No
</option>

</select>

</div>



{{-- LOP Impact --}}
<div class="col-md-4 mb-3">

<label>LOP Impact</label>

<select name="lop_impact"
class="form-control">

<option value="1"
{{ old('lop_impact', $statutoryContribution->lop_impact ?? '') == '1' ? 'selected' : '' }}>
Yes
</option>

<option value="0"
{{ old('lop_impact', $statutoryContribution->lop_impact ?? '') == '0' ? 'selected' : '' }}>
No
</option>

</select>

</div>



{{-- Rounding Rule --}}
<div class="col-md-4 mb-3">

<label>Rounding Rule</label>

<input type="text"
name="rounding_rule"
class="form-control"
value="{{ old('rounding_rule', $statutoryContribution->rounding_rule ?? '') }}">

</div>

</div>
</div>

</div>



{{-- ================= PAYSLIP ================= --}}

<div class="card mb-4">

<div class="card-header">
<h6 class="mb-0">Payslip Settings</h6>
</div>

<div class="card-body">
<div class="row">


<div class="col-md-4 mb-3">

<label>Show in Payslip</label>

<select name="show_in_payslip"
class="form-control">

<option value="1">Yes</option>
<option value="0">No</option>

</select>

</div>



<div class="col-md-4 mb-3">

<label>Payslip Order</label>

<input type="number"
name="payslip_order"
class="form-control">

</div>



<div class="col-md-4 mb-3">

<label>Included in CTC</label>

<select name="included_in_ctc"
class="form-control">

<option value="1">Yes</option>
<option value="0">No</option>

</select>

</div>

</div>
</div>

</div>



{{-- ================= COMPLIANCE ================= --}}

<div class="card mb-4">

<div class="card-header">
<h6 class="mb-0">Compliance Details</h6>
</div>

<div class="card-body">
<div class="row">


<div class="col-md-6 mb-3">

<label>Compliance Head *</label>

<input type="text"
name="compliance_head"
class="form-control"
value="{{ old('compliance_head', $statutoryContribution->compliance_head ?? '') }}"
required>

</div>



<div class="col-md-6 mb-3">

<label>Statutory Code *</label>

<input type="text"
name="statutory_code"
class="form-control"
value="{{ old('statutory_code', $statutoryContribution->statutory_code ?? '') }}"
required>

</div>

</div>
</div>

</div>
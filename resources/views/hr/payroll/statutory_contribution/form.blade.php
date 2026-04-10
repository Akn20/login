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
       required>

</div>



{{-- Contribution Name --}}

<div class="col-md-4 mb-3">

<label>Contribution Name *</label>

<input type="text"
       name="contribution_name"
       class="form-control"
       required>

</div>



{{-- Statutory Category --}}

<div class="col-md-4 mb-3">

<label>Statutory Category *</label>

<select name="statutory_category"
        class="form-control"
        required>

<option value="">Select Category</option>

<option value="PF">PF</option>

<option value="ESI">ESI</option>

<option value="PT">PT</option>

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

<option value="{{ $code }}">

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

<option value="1">Yes</option>

<option value="0">No</option>

</select>

</div>



{{-- Status --}}

<div class="col-md-4 mb-3">

<label>Status *</label>

<select name="status"
        class="form-control"
        required>

<option value="Active">Active</option>

<option value="Inactive">Inactive</option>

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

<option value="1">Yes</option>

<option value="0">No</option>

</select>

</div>



{{-- Salary Ceiling Amount --}}

<div class="col-md-4 mb-3">

<label>Salary Ceiling Amount</label>

<input type="number"
       name="salary_ceiling_amount"
       class="form-control">

</div>



{{-- State Applicable --}}

<div class="col-md-4 mb-3">

<label>State Applicable</label>

<select name="state_applicable"
        class="form-control">

<option value="1">Yes</option>

<option value="0">No</option>

</select>

</div>

</div>

</div>

</div>



{{-- ================= PAYROLL BEHAVIOUR ================= --}}

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

<option value="1">Yes</option>

<option value="0">No</option>

</select>

</div>



{{-- LOP Impact --}}

<div class="col-md-4 mb-3">

<label>LOP Impact</label>

<select name="lop_impact"
        class="form-control">

<option value="1">Yes</option>

<option value="0">No</option>

</select>

</div>



{{-- Rounding Rule --}}

<div class="col-md-4 mb-3">

<label>Rounding Rule</label>

<input type="text"
       name="rounding_rule"
       class="form-control">

</div>

</div>

</div>

</div>



{{-- ================= PAYSLIP ================= --}}

<div class="card mb-4">

<div class="card-header">

<h6 class="mb-0">Payslip Configuration</h6>

</div>

<div class="card-body">

<div class="row">

{{-- Show in Payslip --}}

<div class="col-md-4 mb-3">

<label>Show in Payslip</label>

<select name="show_in_payslip"
        class="form-control">

<option value="1">Yes</option>

<option value="0">No</option>

</select>

</div>



{{-- Payslip Order --}}

<div class="col-md-4 mb-3">

<label>Payslip Order</label>

<input type="number"
       name="payslip_order"
       class="form-control">

</div>



{{-- Included in CTC --}}

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
       required>

</div>



<div class="col-md-6 mb-3">

<label>Statutory Code *</label>

<input type="text"
       name="statutory_code"
       class="form-control"
       required>

</div>

</div>

</div>

</div>
{{-- ================= IDENTIFICATION ================= --}}

<h6 class="fw-bold mb-3">Identification</h6>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Employee *</label>

<select name="employee_id"
class="form-control">

<option value="">Select Employee</option>

@foreach($employees ?? [] as $employee)

<option value="{{ $employee->id }}"
{{ old('employee_id', $entry->employee_id ?? '') == $employee->id ? 'selected' : '' }}>

{{ $employee->name ?? $employee->employee_name }}

</option>

@endforeach

</select>

</div>


<div class="col-md-6 mb-3">

<label class="form-label">Work Type *</label>

<select name="work_type_code"
class="form-control">

<option value="OT"
{{ old('work_type_code', $entry->work_type_code ?? '') == 'OT' ? 'selected' : '' }}>

OT

</option>

<option value="HRLY"
{{ old('work_type_code', $entry->work_type_code ?? '') == 'HRLY' ? 'selected' : '' }}>

HRLY

</option>

</select>

</div>

</div>



<hr>



{{-- ================= TIME REFERENCE ================= --}}

<h6 class="fw-bold mb-3">Time Reference</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">Payroll Month *</label>

<input type="month"
name="payroll_month"
class="form-control"
value="{{ old('payroll_month', $entry->payroll_month ?? '') }}">

</div>


<div class="col-md-4 mb-3">

<label class="form-label">Attendance Date *</label>

<input type="date"
name="attendance_date"
class="form-control"
value="{{ old('attendance_date', $entry->attendance_date ?? '') }}">

</div>


<div class="col-md-4 mb-3">

<label class="form-label">Approved Hours *</label>

<input type="number"
step="0.1"
name="approved_hours"
class="form-control"
value="{{ old('approved_hours', $entry->approved_hours ?? '') }}">

</div>

</div>



<hr>



{{-- ================= TIME CONTEXT ================= --}}

<h6 class="fw-bold mb-3">Time Context</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">Shift Code</label>

<input type="text"
name="shift_code"
class="form-control"
value="{{ old('shift_code', $entry->shift_code ?? '') }}">

</div>


<div class="col-md-4 mb-3">

<label class="form-label">Day Type</label>

<select name="day_type"
class="form-control">

<option value="Working"
{{ old('day_type', $entry->day_type ?? '') == 'Working' ? 'selected' : '' }}>

Working

</option>

<option value="Weekend"
{{ old('day_type', $entry->day_type ?? '') == 'Weekend' ? 'selected' : '' }}>

Weekend

</option>

<option value="Holiday"
{{ old('day_type', $entry->day_type ?? '') == 'Holiday' ? 'selected' : '' }}>

Holiday

</option>

</select>

</div>


<div class="col-md-4 mb-3">

<label class="form-label">Source Type *</label>

<select name="source_type"
class="form-control">

<option value="Biometric"
{{ old('source_type', $entry->source_type ?? '') == 'Biometric' ? 'selected' : '' }}>

Biometric

</option>

<option value="Manual"
{{ old('source_type', $entry->source_type ?? '') == 'Manual' ? 'selected' : '' }}>

Manual

</option>

</select>

</div>

</div>



<hr>



{{-- ================= APPROVAL ================= --}}

<h6 class="fw-bold mb-3">Approval</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">Approval Status</label>

<select name="approval_status"
class="form-control">

<option value="Pending"
{{ old('approval_status', $entry->approval_status ?? '') == 'Pending' ? 'selected' : '' }}>

Pending

</option>

<option value="Approved"
{{ old('approval_status', $entry->approval_status ?? '') == 'Approved' ? 'selected' : '' }}>

Approved

</option>

<option value="Rejected"
{{ old('approval_status', $entry->approval_status ?? '') == 'Rejected' ? 'selected' : '' }}>

Rejected

</option>

</select>

</div>


<div class="col-md-4 mb-3">

<label class="form-label">Approved By</label>

<input type="text"
name="approved_by"
class="form-control"
value="{{ old('approved_by', $entry->approved_by ?? '') }}">

</div>


<div class="col-md-4 mb-3">

<label class="form-label">Approved Date</label>

<input type="date"
name="approved_date"
class="form-control"
value="{{ old('approved_date', $entry->approved_date ?? '') }}">

</div>

</div>



<hr>



{{-- ================= PAYROLL LOCK ================= --}}

<h6 class="fw-bold mb-3">Payroll Lock</h6>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">Locked for Payroll</label>

<select name="locked_for_payroll"
class="form-control">

<option value="0"
{{ old('locked_for_payroll', $entry->locked_for_payroll ?? '') == 0 ? 'selected' : '' }}>

No

</option>

<option value="1"
{{ old('locked_for_payroll', $entry->locked_for_payroll ?? '') == 1 ? 'selected' : '' }}>

Yes

</option>

</select>

</div>

</div>
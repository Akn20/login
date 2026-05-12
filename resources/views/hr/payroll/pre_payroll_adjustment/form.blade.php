@php
    $isReadonly = isset($record) && $record->status == 'Approved';
@endphp

<div class="card mb-3">
    <div class="card-header">Pre Payroll Adjustment</div>
    <div class="card-body">

        {{--  ERROR BLOCK --}}
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

            {{--  Employee --}}
            <div class="col-md-6 mb-3">
                <label>Employee *</label>
   <select name="employee_id"
        class="form-control @error('employee_id') is-invalid @enderror"
        {{ $isReadonly ? 'disabled' : '' }}>
                    <option value="">Select</option>
                    @foreach($employees as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('employee_id', $record->employee_id ?? '') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('employee_id')
    <small class="text-danger">{{ $message }}</small>
@enderror
            </div>

            {{--  Salary Assignment --}}
            <div class="col-md-6 mb-3">
                <label>Salary Assignment *</label>
<select name="salary_assignment_id"
        class="form-control @error('salary_assignment_id') is-invalid @enderror"
        {{ $isReadonly ? 'disabled' : '' }}>
                    <option value="">Select</option>
                @foreach($assignments as $item)
    <option value="{{ $item->id }}"
        {{ old('salary_assignment_id', $record->salary_assignment_id ?? '') == $item->id ? 'selected' : '' }}>
        
  {{ $item->salaryStructure->salary_structure_name ?? 'No Name' }}
        
    </option>
@endforeach
                </select>
                @error('salary_assignment_id')
    <small class="text-danger">{{ $message }}</small>
@enderror
            </div>

            {{--  Payroll Month --}}
            <div class="col-md-6 mb-3">
                <label>Payroll Month *</label>
             <input type="month" name="payroll_month"
       class="form-control @error('payroll_month') is-invalid @enderror"{{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('payroll_month', $record->payroll_month ?? '') }}">
                @error('payroll_month')
    <small class="text-danger">{{ $message }}</small>
@enderror
            </div>

            {{--  Pay Type --}}
            <div class="col-md-6 mb-3">
                <label>Pay Type *</label>
                <select name="pay_type" class="form-control" {{ $isReadonly ? 'disabled' : '' }}>
                    <option value="Monthly"
                        {{ old('pay_type', $record->pay_type ?? '') == 'Monthly' ? 'selected' : '' }}>
                        Monthly
                    </option>
                    <option value="Hourly"
                        {{ old('pay_type', $record->pay_type ?? '') == 'Hourly' ? 'selected' : '' }}>
                        Hourly
                    </option>
                </select>
            </div>

        </div>

        <hr>

        <h6>Attendance</h6>

        <div class="row">

            <div class="col-md-3 mb-3">
                <label>Working Days *</label>
                <input type="number" name="working_days"
       class="form-control @error('working_days') is-invalid @enderror"{{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('working_days', $record->working_days ?? '') }}">
                @error('working_days')
    <small class="text-danger">{{ $message }}</small>
@enderror
            </div>

            <div class="col-md-3 mb-3">
                <label>Days Paid *</label>
                <input type="number" name="days_paid"
       class="form-control @error('days_paid') is-invalid @enderror"{{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('days_paid', $record->days_paid ?? '') }}">
                @error('days_paid')
    <small class="text-danger">{{ $message }}</small>
@enderror
            </div>

            <div class="col-md-3 mb-3">
                <label>LOP Days</label>
                <input type="number" step="0.01" name="lop_days" class="form-control" {{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('lop_days', $record->lop_days ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>OT Hours</label>
                <input type="number" step="0.01" name="ot_hours" class="form-control" {{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('ot_hours', $record->ot_hours ?? '') }}">
            </div>

        </div>

        <hr>

        <h6>Fixed</h6>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Fixed Earnings Total</label>
              <input type="number" name="fixed_earnings_total" id="fixed_earnings_total" class="form-control" {{ $isReadonly ? 'disabled' : '' }}
       value="{{ old('fixed_earnings_total', $record->fixed_earnings_total ?? 0) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Fixed Deductions Total</label>
            <input type="number" name="fixed_deductions_total" id="fixed_deductions_total" class="form-control" {{ $isReadonly ? 'disabled' : '' }}
       value="{{ old('fixed_deductions_total', $record->fixed_deductions_total ?? 0) }}">
            </div>

        </div>

        <hr>

        <h6>Statutory</h6>

        <div class="row">

            <div class="col-md-3 mb-3">
                <label>PF Employee</label>
                <input type="number" name="pf_employee" class="form-control" {{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('pf_employee', $record->pf_employee ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>ESI Employee</label>
                <input type="number" name="esi_employee" class="form-control" {{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('esi_employee', $record->esi_employee ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>Professional Tax</label>
                <input type="number" name="professional_tax" class="form-control" {{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('professional_tax', $record->professional_tax ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>TDS Amount</label>
                <input type="number" name="tds_amount" class="form-control" {{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('tds_amount', $record->tds_amount ?? '') }}">
            </div>

        </div>

        <hr>

        <h6>Variable</h6>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Adhoc Earnings</label>
                <input type="number" name="adhoc_earnings" class="form-control" id="adhoc_earnings" {{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('adhoc_earnings', $record->adhoc_earnings ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Earnings Remarks</label>
                <textarea name="earnings_remarks" class="form-control" {{ $isReadonly ? 'disabled' : '' }}>{{ old('earnings_remarks', $record->earnings_remarks ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Adhoc Deductions</label>
                <input type="number" name="adhoc_deductions" class="form-control" id="adhoc_deductions" {{ $isReadonly ? 'disabled' : '' }}
                    value="{{ old('adhoc_deductions', $record->adhoc_deductions ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Deduction Remarks</label>
                <textarea name="deduction_remarks" class="form-control" {{ $isReadonly ? 'disabled' : '' }}>{{ old('deduction_remarks', $record->deduction_remarks ?? '') }}</textarea>
            </div>

        </div>

        <hr>
<hr>

<h6>Preview Calculation</h6>

<div class="row">

    <div class="col-md-4 mb-3">
        <label>Gross Earnings</label>
        <input type="text" id="gross_earnings" class="form-control" readonly>
    </div>

    <div class="col-md-4 mb-3">
        <label>Total Deductions</label>
        <input type="text" id="total_deductions" class="form-control" readonly>
    </div>

    <div class="col-md-4 mb-3">
        <label>Net Payable</label>
        <input type="text" id="net_payable" class="form-control" readonly>
    </div>

</div>

        

    
</div> {{-- CLOSE card-body --}}
</div> {{-- CLOSE card --}}

{{-- ACTION BUTTONS --}}
<div class="mt-3 d-flex justify-content-end gap-2">

@if(!$isReadonly)
    <button type="submit" name="action" value="draft" class="btn btn-secondary btn-sm px-4">
        Save Draft
    </button>

    <button type="submit" name="action" value="submit" class="btn btn-primary btn-sm px-4">
        Submit
    </button>
@endif

<a href="{{ route('hr.payroll.pre-payroll.index') }}"
   class="btn btn-light btn-sm px-4">
    Cancel
</a>

</div>

{{-- SCRIPT SHOULD BE OUTSIDE BUTTON DIV --}}
<script>
function calculatePayroll() {

    let fixedEarnings = parseFloat(document.getElementById('fixed_earnings_total').value) || 0;
    let adhocEarnings = parseFloat(document.getElementById('adhoc_earnings').value) || 0;

    let fixedDeductions = parseFloat(document.getElementById('fixed_deductions_total').value) || 0;
    let adhocDeductions = parseFloat(document.getElementById('adhoc_deductions').value) || 0;

    let gross = fixedEarnings + adhocEarnings;
    let deductions = fixedDeductions + adhocDeductions;
    let net = gross - deductions;

    document.getElementById('gross_earnings').value = gross.toFixed(2);
    document.getElementById('total_deductions').value = deductions.toFixed(2);
    document.getElementById('net_payable').value = net.toFixed(2);
}

document.querySelectorAll('#fixed_earnings_total, #adhoc_earnings, #fixed_deductions_total, #adhoc_deductions')
    .forEach(input => {
        input.addEventListener('input', calculatePayroll);
    });

// RUN ON PAGE LOAD
window.onload = calculatePayroll;
</script>
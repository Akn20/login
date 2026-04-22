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

            {{--  Salary Assignment --}}
            <div class="col-md-6 mb-3">
                <label>Salary Assignment *</label>
                <select name="salary_assignment_id" class="form-control">
                    <option value="">Select</option>
                @foreach($assignments as $item)
    <option value="{{ $item->id }}"
        {{ old('salary_assignment_id', $record->salary_assignment_id ?? '') == $item->id ? 'selected' : '' }}>
        
  {{ $item->salaryStructure->salary_structure_name ?? 'No Name' }}
        
    </option>
@endforeach
                </select>
            </div>

            {{--  Payroll Month --}}
            <div class="col-md-6 mb-3">
                <label>Payroll Month *</label>
                <input type="month" name="payroll_month" class="form-control"
                    value="{{ old('payroll_month', $record->payroll_month ?? '') }}">
            </div>

            {{--  Pay Type --}}
            <div class="col-md-6 mb-3">
                <label>Pay Type *</label>
                <select name="pay_type" class="form-control">
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
                <input type="number" name="working_days" class="form-control"
                    value="{{ old('working_days', $record->working_days ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>Days Paid *</label>
                <input type="number" name="days_paid" class="form-control"
                    value="{{ old('days_paid', $record->days_paid ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>LOP Days</label>
                <input type="number" step="0.01" name="lop_days" class="form-control"
                    value="{{ old('lop_days', $record->lop_days ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>OT Hours</label>
                <input type="number" step="0.01" name="ot_hours" class="form-control"
                    value="{{ old('ot_hours', $record->ot_hours ?? '') }}">
            </div>

        </div>

        <hr>

        <h6>Fixed</h6>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Fixed Earnings Total</label>
              <input type="number" name="fixed_earnings_total" class="form-control"
       value="{{ old('fixed_earnings_total', $record->fixed_earnings_total ?? 0) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Fixed Deductions Total</label>
            <input type="number" name="fixed_deductions_total" class="form-control"
       value="{{ old('fixed_deductions_total', $record->fixed_deductions_total ?? 0) }}">
            </div>

        </div>

        <hr>

        <h6>Statutory</h6>

        <div class="row">

            <div class="col-md-3 mb-3">
                <label>PF Employee</label>
                <input type="number" name="pf_employee" class="form-control"
                    value="{{ old('pf_employee', $record->pf_employee ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>ESI Employee</label>
                <input type="number" name="esi_employee" class="form-control"
                    value="{{ old('esi_employee', $record->esi_employee ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>Professional Tax</label>
                <input type="number" name="professional_tax" class="form-control"
                    value="{{ old('professional_tax', $record->professional_tax ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label>TDS Amount</label>
                <input type="number" name="tds_amount" class="form-control"
                    value="{{ old('tds_amount', $record->tds_amount ?? '') }}">
            </div>

        </div>

        <hr>

        <h6>Variable</h6>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Adhoc Earnings</label>
                <input type="number" name="adhoc_earnings" class="form-control"
                    value="{{ old('adhoc_earnings', $record->adhoc_earnings ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Earnings Remarks</label>
                <textarea name="earnings_remarks" class="form-control">{{ old('earnings_remarks', $record->earnings_remarks ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Adhoc Deductions</label>
                <input type="number" name="adhoc_deductions" class="form-control"
                    value="{{ old('adhoc_deductions', $record->adhoc_deductions ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Deduction Remarks</label>
                <textarea name="deduction_remarks" class="form-control">{{ old('deduction_remarks', $record->deduction_remarks ?? '') }}</textarea>
            </div>

        </div>

        <hr>

        <h6>Status</h6>

        <div class="row">

            <div class="col-md-4 mb-3">
                <label>Status *</label>
                <select name="status" class="form-control">
                    <option value="Draft"
                        {{ old('status', $record->status ?? '') == 'Draft' ? 'selected' : '' }}>
                        Draft
                    </option>
                    <option value="Submitted"
                        {{ old('status', $record->status ?? '') == 'Submitted' ? 'selected' : '' }}>
                        Submitted
                    </option>
                    <option value="Approved"
                        {{ old('status', $record->status ?? '') == 'Approved' ? 'selected' : '' }}>
                        Approved
                    </option>
                </select>
            </div>

        </div>

    </div>
</div>

{{-- 🔘 ACTION BUTTONS --}}
<div class="mt-3 d-flex justify-content-end gap-2">

<button type="submit" name="action" value="draft" class="btn btn-secondary btn-sm px-4">
    Save Draft
</button>

<button type="submit" name="action" value="submit" class="btn btn-primary btn-sm px-4">
    Submit
</button>

    <a href="{{ route('hr.pre-payroll.index') }}"
       class="btn btn-light btn-sm px-4">
        Cancel
    </a>

</div>
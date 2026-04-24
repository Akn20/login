@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST"
      action="{{ isset($deduction) 
                ? route('hr.payroll.statutory-deduction.update', $deduction->id) 
                : route('hr.payroll.statutory-deduction.store') }}">

    @csrf
    @if(isset($deduction))
        @method('PUT')
    @endif

    <div class="card">

        <div class="card-body">

            <!-- ================= IDENTIFICATION ================= -->
            <h6 class="mb-3">Identification</h6>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Statutory Code</label>
                    <input type="text" name="statutory_code"
                        class="form-control @error('statutory_code') is-invalid @enderror"
                        value="{{ old('statutory_code', $deduction->statutory_code ?? '') }}" >
                    @error('statutory_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Statutory Name</label>
                    <input type="text" name="statutory_name"
                        class="form-control @error('statutory_name') is-invalid @enderror"
                        value="{{ old('statutory_name', $deduction->statutory_name ?? '') }}" >
                    @error('statutory_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Category</label>
                    <select name="statutory_category"
                        class="form-control @error('statutory_category') is-invalid @enderror">
                        <option value="">Select</option>
                        <option value="PF"  {{ old('statutory_category', $deduction->statutory_category ?? '') == 'PF'  ? 'selected' : '' }}>PF</option>
                        <option value="ESI" {{ old('statutory_category', $deduction->statutory_category ?? '') == 'ESI' ? 'selected' : '' }}>ESI</option>
                        <option value="PT"  {{ old('statutory_category', $deduction->statutory_category ?? '') == 'PT'  ? 'selected' : '' }}>PT</option>
                        <option value="TDS" {{ old('statutory_category', $deduction->statutory_category ?? '') == 'TDS' ? 'selected' : '' }}>TDS</option>
                        <option value="LWF" {{ old('statutory_category', $deduction->statutory_category ?? '') == 'LWF' ? 'selected' : '' }}>LWF</option>
                    </select>
                    @error('statutory_category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status"
                        class="form-control @error('status') is-invalid @enderror" >
                        <option value="active"   {{ old('status', $deduction->status ?? '') == 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $deduction->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- ================= RULE MAPPING ================= -->
            <h6 class="mb-3 mt-4">Rule Mapping</h6>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Rule Set Code</label>
                    <select name="rule_set_id"
                        class="form-control @error('rule_set_id') is-invalid @enderror" >
                        <option value="">Select</option>
                        @foreach($ruleSets as $rule)
                            <option value="{{ $rule->id }}" {{ old('rule_set_id', $deduction->rule_set_id ?? '') == $rule->id ? 'selected' : '' }}>
                                {{ $rule->rule_set_code }}
                            </option>
                        @endforeach
                    </select>
                    @error('rule_set_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Eligibility</label>
                    <select name="eligibility_flag"
                        class="form-control @error('eligibility_flag') is-invalid @enderror">
                        <option value="1" {{ old('eligibility_flag', $deduction->eligibility_flag ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('eligibility_flag', $deduction->eligibility_flag ?? '') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('eligibility_flag')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Salary Ceiling Applicable</label>
                    <select name="salary_ceiling_applicable"
                        class="form-control @error('salary_ceiling_applicable') is-invalid @enderror">
                        <option value="1" {{ old('salary_ceiling_applicable', $deduction->salary_ceiling_applicable ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('salary_ceiling_applicable', $deduction->salary_ceiling_applicable ?? '') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('salary_ceiling_applicable')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ceiling Amount</label>
                    <input type="number" name="salary_ceiling_amount"
                        class="form-control @error('salary_ceiling_amount') is-invalid @enderror"
                        value="{{ old('salary_ceiling_amount', $deduction->salary_ceiling_amount ?? '') }}">
                    @error('salary_ceiling_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">State Applicable</label>
                    <select name="state_applicable"
                        class="form-control @error('state_applicable') is-invalid @enderror">
                        <option value="1" {{ old('state_applicable', $deduction->state_applicable ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('state_applicable', $deduction->state_applicable ?? '') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('state_applicable')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label>Applicable States</label>
                    @php $selectedStates = old('states', json_decode($deduction->applicable_states ?? '[]', true)); @endphp
                    <select name="states[]"
                        class="form-control @error('states') is-invalid @enderror" multiple>
                        <option value="Karnataka" {{ in_array('Karnataka', $selectedStates) ? 'selected' : '' }}>Karnataka</option>
                        <option value="Telangana" {{ in_array('Telangana', $selectedStates) ? 'selected' : '' }}>Telangana</option>
                        <option value="Tamil Nadu" {{ in_array('Tamil Nadu', $selectedStates) ? 'selected' : '' }}>Tamil Nadu</option>
                    </select>
                    @error('states')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- ================= PAYROLL ================= -->
            <h6 class="mb-3 mt-4">Payroll Behaviour</h6>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Prorata Applicable</label>
                    <select name="prorata_applicable"
                        class="form-control @error('prorata_applicable') is-invalid @enderror">
                        <option value="1" {{ old('prorata_applicable', $deduction->prorata_applicable ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('prorata_applicable', $deduction->prorata_applicable ?? '') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('prorata_applicable')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">LOP Impact</label>
                    <select name="lop_impact"
                        class="form-control @error('lop_impact') is-invalid @enderror">
                        <option value="1" {{ old('lop_impact', $deduction->lop_impact ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('lop_impact', $deduction->lop_impact ?? '') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('lop_impact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Rounding Rule</label>
                    <select name="rounding_rule"
                        class="form-control @error('rounding_rule') is-invalid @enderror">
                        <option value="nearest" {{ old('rounding_rule', $deduction->rounding_rule ?? '') == 'nearest' ? 'selected' : '' }}>Nearest</option>
                        <option value="up"      {{ old('rounding_rule', $deduction->rounding_rule ?? '') == 'up'      ? 'selected' : '' }}>Up</option>
                        <option value="down"    {{ old('rounding_rule', $deduction->rounding_rule ?? '') == 'down'    ? 'selected' : '' }}>Down</option>
                    </select>
                    @error('rounding_rule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- ================= PAYSLIP ================= -->
            <h6 class="mb-3 mt-4">Payslip</h6>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Show in Payslip</label>
                    <select name="show_in_payslip"
                        class="form-control @error('show_in_payslip') is-invalid @enderror">
                        <option value="1" {{ old('show_in_payslip', $deduction->show_in_payslip ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('show_in_payslip', $deduction->show_in_payslip ?? '') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('show_in_payslip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Payslip Order</label>
                    <input type="number" name="payslip_order"
                        class="form-control @error('payslip_order') is-invalid @enderror"
                        value="{{ old('payslip_order', $deduction->payslip_order ?? '') }}">
                    @error('payslip_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- ================= COMPLIANCE ================= -->
            <h6 class="mb-3 mt-4">Compliance</h6>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Compliance Head</label>
                    <select name="compliance_head"
                        class="form-control @error('compliance_head') is-invalid @enderror">
                        <option value="PF"  {{ old('compliance_head', $deduction->compliance_head ?? '') == 'PF'  ? 'selected' : '' }}>PF</option>
                        <option value="ESI" {{ old('compliance_head', $deduction->compliance_head ?? '') == 'ESI' ? 'selected' : '' }}>ESI</option>
                        <option value="IT"  {{ old('compliance_head', $deduction->compliance_head ?? '') == 'IT'  ? 'selected' : '' }}>IT</option>
                    </select>
                    @error('compliance_head')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Authority Code</label>
                    <input type="text" name="authority_code"
                        class="form-control @error('authority_code') is-invalid @enderror"
                        value="{{ old('authority_code', $deduction->authority_code ?? '') }}">
                    @error('authority_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('hr.payroll.statutory-deduction.index') }}" class="btn btn-light">
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="feather-save me-1"></i> Save
            </button>
        </div>

    </div>

</form>
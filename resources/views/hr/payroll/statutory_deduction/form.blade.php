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
                    <input type="text" name="statutory_code" class="form-control"
                        value="{{ old('statutory_code', $deduction->statutory_code ?? '') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Statutory Name</label>
                    <input type="text" name="statutory_name" class="form-control"
                        value="{{ old('statutory_name', $deduction->statutory_name ?? '') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Category</label>
                    <select name="statutory_category" class="form-control" required>
                        <option value="">Select</option>
                        <option value="PF">PF</option>
                        <option value="ESI">ESI</option>
                        <option value="PT">PT</option>
                        <option value="TDS">TDS</option>
                        <option value="LWF">LWF</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

            </div>

            <!-- ================= RULE MAPPING ================= -->
            <h6 class="mb-3 mt-4">Rule Mapping</h6>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Rule Set Code</label>
                    <select name="rule_set_id" class="form-control" required>
                        <option value="">Select</option>
                        @foreach($ruleSets as $rule)
                            <option value="{{ $rule->id }}">
                                {{ $rule->rule_set_code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Eligibility</label>
                    <select name="eligibility_flag" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Salary Ceiling Applicable</label>
                    <select name="salary_ceiling_applicable" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ceiling Amount</label>
                    <input type="number" name="salary_ceiling_amount" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">State Applicable</label>
                    <select name="state_applicable" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Applicable States</label>
                    <select name="states[]" class="form-control" multiple>
                        <option>Karnataka</option>
                        <option>Telangana</option>
                        <option>Tamil Nadu</option>
                    </select>
                </div>

            </div>

            <!-- ================= PAYROLL ================= -->
            <h6 class="mb-3 mt-4">Payroll Behaviour</h6>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Prorata Applicable</label>
                    <select name="prorata_applicable" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">LOP Impact</label>
                    <select name="lop_impact" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Rounding Rule</label>
                    <select name="rounding_rule" class="form-control">
                        <option value="nearest">Nearest</option>
                        <option value="up">Up</option>
                        <option value="down">Down</option>
                    </select>
                </div>

            </div>

            <!-- ================= PAYSLIP ================= -->
            <h6 class="mb-3 mt-4">Payslip</h6>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Show in Payslip</label>
                    <select name="show_in_payslip" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Payslip Order</label>
                    <input type="number" name="payslip_order" class="form-control">
                </div>

            </div>

            <!-- ================= COMPLIANCE ================= -->
            <h6 class="mb-3 mt-4">Compliance</h6>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Compliance Head</label>
                    <select name="compliance_head" class="form-control">
                        <option value="PF">PF</option>
                        <option value="ESI">ESI</option>
                        <option value="IT">IT</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Authority Code</label>
                    <input type="text" name="authority_code" class="form-control">
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
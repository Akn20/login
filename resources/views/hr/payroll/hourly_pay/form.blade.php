<div class="card mb-3">
    <div class="card-header">Basic Details</div>
    <div class="card-body">

        <div class="row">
            {{-- Work Type Code --}}
<div class="mb-3">
    <label class="form-label">Work Type Code *</label>
    <input type="text" name="code" class="form-control"
        value="{{ old('code', $hourlyPay->code ?? '') }}" required>

    <small class="text-muted">Example: OT001, HRLY01</small>
</div>
         {{-- Work Type Name --}}
<div class="mb-3">
    <label class="form-label">Work Type Name *</label>
    <input type="text" name="name" class="form-control"
        value="{{ old('name', $hourlyPay->name ?? '') }}" required>
</div>

<div class="row">

    {{-- Work Category --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Work Category *</label>
        <select name="category" class="form-select" required>
            <option value="">Select Category</option>
            <option value="Overtime" {{ old('category', $hourlyPay->category ?? '') == 'Overtime' ? 'selected' : '' }}>Overtime</option>
            <option value="Hourly" {{ old('category', $hourlyPay->category ?? '') == 'Hourly' ? 'selected' : '' }}>Hourly</option>
            <option value="Shift" {{ old('category', $hourlyPay->category ?? '') == 'Shift' ? 'selected' : '' }}>Shift</option>
        </select>
    </div>

    {{-- Earnings Type --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Earnings Type *</label>
        <select name="earning_type" class="form-select" required>
            <option value="">Select Type</option>
            <option value="fixed" {{ old('earning_type', $hourlyPay->earning_type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
            <option value="variable" {{ old('earning_type', $hourlyPay->earning_type ?? '') == 'variable' ? 'selected' : '' }}>Variable</option>
        </select>
    </div>

</div>

<hr>

<h6 class="mb-3">Payroll Configuration</h6>

<div class="row">

    <div class="col-md-2 form-check mb-3">
        <input type="checkbox" name="is_taxable" value="1"
            class="form-check-input"
            {{ old('is_taxable', $hourlyPay->is_taxable ?? 0) ? 'checked' : '' }}>
        <label class="form-check-label">Taxable</label>
    </div>

    <div class="col-md-2 form-check mb-3">
        <input type="checkbox" name="pf_applicable" value="1"
            class="form-check-input"
            {{ old('pf_applicable', $hourlyPay->pf_applicable ?? 0) ? 'checked' : '' }}>
        <label class="form-check-label">PF</label>
    </div>

    <div class="col-md-2 form-check mb-3">
        <input type="checkbox" name="esi_applicable" value="1"
            class="form-check-input"
            {{ old('esi_applicable', $hourlyPay->esi_applicable ?? 0) ? 'checked' : '' }}>
        <label class="form-check-label">ESI</label>
    </div>

    <div class="col-md-2 form-check mb-3">
        <input type="checkbox" name="pt_applicable" value="1"
            class="form-check-input"
            {{ old('pt_applicable', $hourlyPay->pt_applicable ?? 0) ? 'checked' : '' }}>
        <label class="form-check-label">PT</label>
    </div>

</div>

<div class="row">

    <div class="col-md-3 form-check mb-3">
        <input type="checkbox" name="is_prorata" value="1"
            class="form-check-input"
            {{ old('is_prorata', $hourlyPay->is_prorata ?? 0) ? 'checked' : '' }}>
        <label class="form-check-label">Prorata</label>
    </div>

    <div class="col-md-3 form-check mb-3">
        <input type="checkbox" name="lop_impact" value="1"
            class="form-check-input"
            {{ old('lop_impact', $hourlyPay->lop_impact ?? 0) ? 'checked' : '' }}>
        <label class="form-check-label">LOP Impact</label>
    </div>

</div>

</div>

<hr>

<h6 class="mb-3">Payslip Configuration</h6>

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Show in Payslip</label>
        <select name="show_in_payslip" class="form-select">
            <option value="1" {{ old('show_in_payslip', $hourlyPay->show_in_payslip ?? 1) == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('show_in_payslip', $hourlyPay->show_in_payslip ?? 1) == 0 ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Payslip Label</label>
        <input type="text" name="payslip_label" class="form-control"
            value="{{ old('payslip_label', $hourlyPay->payslip_label ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Display Order</label>
        <input type="number" name="display_order" class="form-control"
            value="{{ old('display_order', $hourlyPay->display_order ?? 0) }}">
    </div>

</div>

{{-- Status --}}
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="active" {{ old('status', $hourlyPay->status ?? 'active') == 'active' ? 'selected' : '' }}>
            Active
        </option>
        <option value="inactive" {{ old('status', $hourlyPay->status ?? '') == 'inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>

{{-- Buttons --}}
<div class="mt-3 d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary btn-sm px-4">
        <i class="feather-save me-1"></i>
        {{ isset($hourlyPay) ? 'Update' : 'Save' }}
    </button>

    <a href="{{ route('hr.payroll.hourly-pay.index') }}" class="btn btn-light btn-sm px-4">
        Cancel
    </a>
</div>
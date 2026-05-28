<div class="row">

    {{-- ================= Employee Information ================= --}}
    <div class="col-12">

        <h5 class="mb-3 text-primary">
            Employee Information
        </h5>

        <hr>

    </div>

    {{-- Employee ID --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            Employee ID
            <span class="text-danger">*</span>
        </label>

        <select
            name="employee_id"
            id="employee_id"
            class="form-select"
        >

            <option value="">
                Select Employee
            </option>

            @foreach($employees as $employee)

                <option
                    value="{{ $employee->employee_id }}"
                    data-name="{{ $employee->name }}"
                    data-department="{{ optional($employee->department)->department_name }}"
                    {{ old('employee_id', $record->employee_id ?? '') == $employee->employee_id ? 'selected' : '' }}
                >

                    {{ $employee->employee_id }}

                </option>

            @endforeach

        </select>

        @error('employee_id')

            <small class="text-danger">
                {{ $message }}
            </small>

        @enderror

    </div>

    {{-- Employee Name --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            Employee Name
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="employee_name"
            id="employee_name"
            class="form-control"
            readonly
            value="{{ old('employee_name', $record->employee_name ?? '') }}"
        >

        @error('employee_name')

            <small class="text-danger">
                {{ $message }}
            </small>

        @enderror

    </div>

    {{-- Department --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            Department
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="department"
            id="department"
            class="form-control"
            readonly
            value="{{ old('department', $record->department ?? '') }}"
        >

        @error('department')

            <small class="text-danger">
                {{ $message }}
            </small>

        @enderror

    </div>

    {{-- ================= PF Details ================= --}}
    <div class="col-12 mt-4">

        <h5 class="mb-3 text-primary">
            PF Details
        </h5>

        <hr>

    </div>

    {{-- PF Applicable --}}
    <div class="col-md-3 mb-4">

     <label class="form-label">
    PF Applicable
    <span class="text-danger">*</span>
</label>

        <select
            name="pf_applicable"
            class="form-select"
        >

            <option value="">
                Select
            </option>

            <option
                value="Yes"
                {{ old('pf_applicable', $record->pf_applicable ?? '') == 'Yes' ? 'selected' : '' }}
            >
                Yes
            </option>

            <option
                value="No"
                {{ old('pf_applicable', $record->pf_applicable ?? '') == 'No' ? 'selected' : '' }}
            >
                No
            </option>

        </select>
@error('pf_applicable')

    <small class="text-danger">
        {{ $message }}
    </small>

@enderror
    </div>

    {{-- PF Number --}}
    <div class="col-md-3 mb-4">

        <label class="form-label">
            PF Number
        </label>

        <input
            type="text"
            name="pf_number"
            class="form-control"
            value="{{ old('pf_number', $record->pf_number ?? '') }}"
            placeholder="e.g. PF8926"
        >

    </div>

    {{-- PF Amount --}}
    <div class="col-md-3 mb-4">

        <label class="form-label">
            PF Amount
        </label>

        <input
            type="number"
            step="0.01"
            name="pf_amount"
            class="form-control"
            value="{{ old('pf_amount', $record->pf_amount ?? '') }}"
        >

    </div>

    {{-- PF Start Date --}}
    <div class="col-md-3 mb-4">

        <label class="form-label">
            PF Start Date
        </label>

        <input
            type="date"
            name="pf_start_date"
            class="form-control"
            value="{{ old('pf_start_date', $record->pf_start_date ?? '') }}"
        >

    </div>

    {{-- ================= ESI Details ================= --}}
    <div class="col-12 mt-4">

        <h5 class="mb-3 text-primary">
            ESI Details
        </h5>

        <hr>

    </div>

    {{-- ESI Applicable --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            ESI Applicable
            <span class="text-danger">*</span>
        </label>

        <select
            name="esi_applicable"
            class="form-select"
        >

            <option value="">
                Select
            </option>

            <option
                value="Yes"
                {{ old('esi_applicable', $record->esi_applicable ?? '') == 'Yes' ? 'selected' : '' }}
            >
                Yes
            </option>

            <option
                value="No"
                {{ old('esi_applicable', $record->esi_applicable ?? '') == 'No' ? 'selected' : '' }}
            >
                No
            </option>

        </select>
@error('esi_applicable')

    <small class="text-danger">
        {{ $message }}
    </small>

@enderror
    </div>

    {{-- ESI Number --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            ESI Number
        </label>

        <input
            type="text"
            name="esi_number"
            class="form-control"
            value="{{ old('esi_number', $record->esi_number ?? '') }}"
            placeholder="e.g. ESI923456"
        >

    </div>

    {{-- ESI Amount --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            ESI Amount
        </label>

        <input
            type="number"
            step="0.01"
            name="esi_amount"
            class="form-control"
            value="{{ old('esi_amount', $record->esi_amount ?? '') }}"
        >

    </div>

    {{-- ================= Professional Tax ================= --}}
    <div class="col-12 mt-4">

        <h5 class="mb-3 text-primary">
            Professional Tax
        </h5>

        <hr>

    </div>

    {{-- PT Applicable --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            PT Applicable
            <span class="text-danger">*</span>
        </label>

        <select
            name="pt_applicable"
            class="form-select"
        >

            <option value="">
                Select
            </option>

            <option
                value="Yes"
                {{ old('pt_applicable', $record->pt_applicable ?? '') == 'Yes' ? 'selected' : '' }}
            >
                Yes
            </option>

            <option
                value="No"
                {{ old('pt_applicable', $record->pt_applicable ?? '') == 'No' ? 'selected' : '' }}
            >
                No
            </option>

        </select>
@error('pt_applicable')

    <small class="text-danger">
        {{ $message }}
    </small>

@enderror
    </div>

    {{-- PT Amount --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            PT Amount
        </label>

        <input
            type="number"
            step="0.01"
            name="pt_amount"
            class="form-control"
            value="{{ old('pt_amount', $record->pt_amount ?? '') }}"
        >

    </div>

    {{-- State Applicable --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            State Applicable
        </label>

        <input
            type="text"
            name="state_applicable"
            class="form-control"
            value="{{ old('state_applicable', $record->state_applicable ?? '') }}"
        >

    </div>

    {{-- ================= TDS Details ================= --}}
    <div class="col-12 mt-4">

        <h5 class="mb-3 text-primary">
            TDS Details
        </h5>

        <hr>

    </div>

    {{-- TDS Applicable --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            TDS Applicable
            <span class="text-danger">*</span>
        </label>

        <select
            name="tds_applicable"
            class="form-select"
        >

            <option value="">
                Select
            </option>

            <option
                value="Yes"
                {{ old('tds_applicable', $record->tds_applicable ?? '') == 'Yes' ? 'selected' : '' }}
            >
                Yes
            </option>

            <option
                value="No"
                {{ old('tds_applicable', $record->tds_applicable ?? '') == 'No' ? 'selected' : '' }}
            >
                No
            </option>

        </select>
    @error('tds_applicable')

    <small class="text-danger">
        {{ $message }}
    </small>

@enderror
    </div>

    {{-- PAN Number --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            PAN Number
        </label>

        <input
            type="text"
            name="pan_number"
            class="form-control"
            placeholder="e.g. ABCDE1234F"
            value="{{ old('pan_number', $record->pan_number ?? '') }}"
        >

    </div>

    {{-- TDS Percentage --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            TDS Percentage
        </label>

        <input
            type="number"
            step="0.01"
            name="tds_percentage"
            class="form-control"
            placeholder="e.g. 10.00"
            value="{{ old('tds_percentage', $record->tds_percentage ?? '') }}"
        >

    </div>
    {{-- ================= Contract Details ================= --}}
<div class="col-12 mt-4">

    <h5 class="mb-3 text-primary">
        Contract Details
    </h5>

    <hr>

</div>

{{-- Contract Start Date --}}
<div class="col-md-4 mb-4">

    <label class="form-label">
        Contract Start Date
    </label>

    <input
        type="date"
        name="contract_start_date"
        class="form-control"
        value="{{ old('contract_start_date', $record->contract_start_date ?? '') }}"
    >

</div>

{{-- Contract End Date --}}
<div class="col-md-4 mb-4">

    <label class="form-label">
        Contract End Date
    </label>

    <input
        type="date"
        name="contract_end_date"
        class="form-control"
        value="{{ old('contract_end_date', $record->contract_end_date ?? '') }}"
    >
@error('contract_end_date')

    <small class="text-danger">
        {{ $message }}
    </small>

@enderror
</div>

{{-- Contract Status --}}
<div class="col-md-4 mb-4">

    <label class="form-label">
        Contract Status
    </label>

    <select
        name="contract_status"
        class="form-select"
    >

        <option value="">
            Select
        </option>

        <option
            value="Valid"
            {{ old('contract_status', $record->contract_status ?? '') == 'Valid' ? 'selected' : '' }}
        >
            Valid
        </option>

        <option
            value="Expired"
            {{ old('contract_status', $record->contract_status ?? '') == 'Expired' ? 'selected' : '' }}
        >
            Expired
        </option>

    </select>

</div>
{{-- ================= Medical License ================= --}}
<div class="col-12 mt-4">

    <h5 class="mb-3 text-primary">
        Medical License Details
    </h5>

    <hr>

</div>

{{-- License Number --}}
<div class="col-md-3 mb-4">

    <label class="form-label">
        License Number
    </label>

    <input
        type="text"
        name="license_number"
        class="form-control"
        placeholder="MED56767"
        value="{{ old('license_number', $record->license_number ?? '') }}"
    >

</div>

{{-- License Issue Date --}}
<div class="col-md-3 mb-4">

    <label class="form-label">
        License Issue Date
    </label>

    <input
        type="date"
        name="license_issue_date"
        class="form-control"
        value="{{ old('license_issue_date', $record->license_issue_date ?? '') }}"
    >

</div>

{{-- License Expiry Date --}}
<div class="col-md-3 mb-4">

    <label class="form-label">
        License Expiry Date
    </label>

    <input
        type="date"
        name="license_expiry_date"
        class="form-control"
        value="{{ old('license_expiry_date', $record->license_expiry_date ?? '') }}"
    >

</div>

{{-- License Status --}}
<div class="col-md-3 mb-4">

    <label class="form-label">
        License Status
    </label>

    <select
        name="license_status"
        class="form-select"
    >

        <option value="">
            Select
        </option>

        <option
            value="Valid"
            {{ old('license_status', $record->license_status ?? '') == 'Valid' ? 'selected' : '' }}
        >
            Valid
        </option>

        <option
            value="Expired"
            {{ old('license_status', $record->license_status ?? '') == 'Expired' ? 'selected' : '' }}
        >
            Expired
        </option>

    </select>

</div>
{{-- License Upload --}}
<div class="col-md-3 mb-4">

    <label class="form-label">
        License Upload
    </label>

    <input
        type="file"
        name="license_upload"
        class="form-control"
    >

    @error('license_upload')

        <small class="text-danger">
            {{ $message }}
        </small>

    @enderror

</div>
{{-- ================= Additional Information ================= --}}
<div class="col-12 mt-4">

    <h5 class="mb-3 text-primary">
        Additional Information
    </h5>

    <hr>

</div>

{{-- Remarks --}}
<div class="col-md-6 mb-4">

    <label class="form-label">
        Remarks
    </label>

    <textarea
        name="remarks"
        class="form-control"
        rows="3"
    >{{ old('remarks', $record->remarks ?? '') }}</textarea>

</div>

{{-- Status --}}
<div class="col-md-6 mb-4">

 <label class="form-label">
    Status
    <span class="text-danger">*</span>
</label>
    <select
        name="status"
        class="form-select"
    >

        <option
            value="Active"
            {{ old('status', $record->status ?? '') == 'Active' ? 'selected' : '' }}
        >
            Active
        </option>

        <option
            value="Inactive"
            {{ old('status', $record->status ?? '') == 'Inactive' ? 'selected' : '' }}
        >
            Inactive
        </option>

    </select>
@error('status')

    <small class="text-danger">
        {{ $message }}
    </small>

@enderror
</div>
</div>

<script>

document
    .getElementById('employee_id')
    .addEventListener('change', function () {

        let selected =
            this.options[this.selectedIndex];

        document.getElementById('employee_name').value =
            selected.dataset.name || '';

        document.getElementById('department').value =
            selected.dataset.department || '';

    });

</script>
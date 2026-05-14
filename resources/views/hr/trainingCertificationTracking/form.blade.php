<div class="row">

    {{-- Employee ID --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Employee ID <span class="text-danger">*</span>
        </label>

        <select
            name="employee_id"
            id="employee_id"
            class="form-select @error('employee_id') is-invalid @enderror"
        >
            <option value="">Select Employee</option>

            @foreach($employees as $employee)
                <option
                    value="{{ $employee->employee_id }}"
                    data-name="{{ $employee->name }}"
                    data-department="{{ optional($employee->department)->department_name }}"
                    data-designation="{{ optional($employee->designation)->designation_name }}"
                    {{ old('employee_id', $record->employee_id ?? '') == $employee->employee_id ? 'selected' : '' }}
                >
                    {{ $employee->employee_id }}
                </option>
            @endforeach

        </select>

        @error('employee_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Employee Name --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Employee Name
        </label>

        <input
            type="text"
            name="employee_name"
            id="employee_name"
            class="form-control"
            readonly
            value="{{ old('employee_name', $record->employee_name ?? '') }}"
        >
    </div>

    {{-- Department --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Department
        </label>

        <input
            type="text"
            name="department"
            id="department"
            class="form-control"
            readonly
            value="{{ old('department', $record->department ?? '') }}"
        >
    </div>

    {{-- Designation --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Designation
        </label>

        <input
            type="text"
            name="designation"
            id="designation"
            class="form-control"
            readonly
            value="{{ old('designation', $record->designation ?? '') }}"
        >
    </div>

    {{-- Training Code --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Training Code <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="training_code"
            class="form-control @error('training_code') is-invalid @enderror"
            value="{{ old('training_code', $record->training_code ?? '') }}"
        >

        @error('training_code')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Training Name --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Training Name <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="training_name"
            class="form-control @error('training_name') is-invalid @enderror"
            value="{{ old('training_name', $record->training_name ?? '') }}"
        >

        @error('training_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Training Type --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Training Type
        </label>

        <input
            type="text"
            name="training_type"
            class="form-control"
            value="{{ old('training_type', $record->training_type ?? '') }}"
        >
    </div>

    {{-- Training Provider --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Training Provider
        </label>

        <input
            type="text"
            name="training_provider"
            class="form-control"
            value="{{ old('training_provider', $record->training_provider ?? '') }}"
        >
    </div>

    {{-- Training Location --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Training Location
        </label>

        <input
            type="text"
            name="training_location"
            class="form-control"
            value="{{ old('training_location', $record->training_location ?? '') }}"
        >
    </div>

    {{-- Start Date --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Training Start Date
        </label>

        <input
            type="date"
            name="training_start_date"
            class="form-control"
            value="{{ old('training_start_date', $record->training_start_date ?? '') }}"
        >
    </div>

    {{-- End Date --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Training End Date
        </label>

        <input
            type="date"
            name="training_end_date"
            class="form-control"
            value="{{ old('training_end_date', $record->training_end_date ?? '') }}"
        >
    </div>

{{-- Certification Name --}}
<div class="col-md-6 mb-4">
    <label class="form-label">
        Certification Name <span class="text-danger">*</span>
    </label>

    <input
        type="text"
        name="certification_name"
        class="form-control @error('certification_name') is-invalid @enderror"
        value="{{ old('certification_name', $record->certification_name ?? '') }}"
    >

    @error('certification_name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

    {{-- Certification Number --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Certification Number
        </label>

        <input
            type="text"
            name="certification_number"
            class="form-control"
            value="{{ old('certification_number', $record->certification_number ?? '') }}"
        >
    </div>

{{-- Issue Date --}}
<div class="col-md-6 mb-4">
    <label class="form-label">
        Issue Date <span class="text-danger">*</span>
    </label>

    <input
        type="date"
        name="issue_date"
        class="form-control @error('issue_date') is-invalid @enderror"
        value="{{ old('issue_date', $record->issue_date ?? '') }}"
    >

    @error('issue_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

 {{-- Expiry Date --}}
<div class="col-md-6 mb-4">
    <label class="form-label">
        Expiry Date <span class="text-danger">*</span>
    </label>

    <input
        type="date"
        name="expiry_date"
        class="form-control @error('expiry_date') is-invalid @enderror"
        value="{{ old('expiry_date', $record->expiry_date ?? '') }}"
    >

    @error('expiry_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

    {{-- Certification Authority --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Certification Authority
        </label>

        <input
            type="text"
            name="certification_authority"
            class="form-control"
            value="{{ old('certification_authority', $record->certification_authority ?? '') }}"
        >
    </div>

    {{-- Reminder Days --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Reminder Days
        </label>

        <input
            type="number"
            name="reminder_days"
            class="form-control"
            value="{{ old('reminder_days', $record->reminder_days ?? '') }}"
        >
    </div>

    {{-- Renewal Required --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Renewal Required
        </label>

        <select
            name="renewal_required"
            class="form-select"
        >
            <option value="0">No</option>

            <option
                value="1"
                {{ old('renewal_required', $record->renewal_required ?? '') == 1 ? 'selected' : '' }}
            >
                Yes
            </option>
        </select>
    </div>

    {{-- Reminder Enabled --}}
    <div class="col-md-6 mb-4">
        <label class="form-label">
            Reminder Enabled
        </label>

        <select
            name="reminder_enabled"
            class="form-select"
        >
            <option value="0">No</option>

            <option
                value="1"
                {{ old('reminder_enabled', $record->reminder_enabled ?? '') == 1 ? 'selected' : '' }}
            >
                Yes
            </option>
        </select>
    </div>

    {{-- Remarks --}}
    <div class="col-md-12 mb-4">
        <label class="form-label">
            Remarks
        </label>

        <textarea
            name="remarks"
            class="form-control"
            rows="3"
        >{{ old('remarks', $record->remarks ?? '') }}</textarea>
    </div>
{{-- Attachment --}}
<div class="col-md-12 mb-4">
    <label class="form-label">
        Attachment
    </label>

    <input
        type="file"
        name="attachment"
        class="form-control @error('attachment') is-invalid @enderror"
        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
    >

    @error('attachment')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

    <small class="text-muted">
        Allowed:
        JPG, PNG, PDF, DOC, DOCX
    </small>
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

        document.getElementById('designation').value =
            selected.dataset.designation || '';

    });

</script>
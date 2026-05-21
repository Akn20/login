<div class="row">

    {{-- ================= Employee Information ================= --}}
    <div class="col-12">

        <h5 class="mb-3 text-primary">
            Employee Information
        </h5>

        <hr>

    </div>

    {{-- Employee ID --}}
    <div class="col-md-6 mb-4">

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
                >

                    {{ $employee->employee_id }}

                </option>

            @endforeach

        </select>

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
        >

    </div>

    {{-- ================= Performance Review ================= --}}
    <div class="col-12 mt-4">

        <h5 class="mb-3 text-primary">
            Performance Review
        </h5>

        <hr>

    </div>

    {{-- Reviewer Name --}}
    <div class="col-md-6 mb-4">

        <label class="form-label">
            Reviewer Name
        </label>

        <input
            type="text"
            name="reviewer_name"
            class="form-control"
            value="{{ old('reviewer_name', $record->reviewer_name ?? '') }}"
        >

    </div>

    {{-- Review Date --}}
    <div class="col-md-6 mb-4">

        <label class="form-label">
            Review Date
        </label>

        <input
            type="date"
            name="review_date"
            class="form-control"
            value="{{ old('review_date', $record->review_date ?? '') }}"
        >

    </div>

    {{-- Rating --}}
    <div class="col-md-6 mb-4">

        <label class="form-label">
            Rating
        </label>

        <select
            name="rating"
            class="form-select"
        >

            <option value="">
                Select Rating
            </option>

            @for($i = 1; $i <= 5; $i++)

                <option
                    value="{{ $i }}"
                    {{ old('rating', $record->rating ?? '') == $i ? 'selected' : '' }}
                >
                    {{ $i }}
                </option>

            @endfor

        </select>

    </div>

    {{-- Review Status --}}
    <div class="col-md-6 mb-4">

        <label class="form-label">
            Review Status
        </label>

        <select
            name="review_status"
            class="form-select"
        >

            <option value="Pending">
                Pending
            </option>

            <option value="Reviewed">
                Reviewed
            </option>

            <option value="Approved">
                Approved
            </option>

        </select>

    </div>

    {{-- Review Comments --}}
    <div class="col-md-12 mb-4">

        <label class="form-label">
            Review Comments
        </label>

        <textarea
            name="review_comments"
            class="form-control"
            rows="3"
        >{{ old('review_comments', $record->review_comments ?? '') }}</textarea>

    </div>

    {{-- ================= KPI Tracking ================= --}}
    <div class="col-12 mt-4">

        <h5 class="mb-3 text-primary">
            KPI Tracking
        </h5>

        <hr>

    </div>

    {{-- KPI Name --}}
    <div class="col-md-6 mb-4">

        <label class="form-label">
            KPI Name
        </label>

        <input
            type="text"
            name="kpi_name"
            class="form-control"
            value="{{ old('kpi_name', $record->kpi_name ?? '') }}"
        >

    </div>

    {{-- KPI Score --}}
    <div class="col-md-6 mb-4">

        <label class="form-label">
            KPI Score
        </label>

        <input
            type="number"
            name="kpi_score"
            class="form-control"
            value="{{ old('kpi_score', $record->kpi_score ?? '') }}"
        >

    </div>

    {{-- Target Value --}}
    <div class="col-md-6 mb-4">

        <label class="form-label">
            Target Value
        </label>

        <input
            type="number"
            name="target_value"
            class="form-control"
            value="{{ old('target_value', $record->target_value ?? '') }}"
        >

    </div>

    {{-- Achieved Value --}}
    <div class="col-md-6 mb-4">

        <label class="form-label">
            Achieved Value
        </label>

        <input
            type="number"
            name="achieved_value"
            class="form-control"
            value="{{ old('achieved_value', $record->achieved_value ?? '') }}"
        >

    </div>

    {{-- KPI Remarks --}}
    <div class="col-md-12 mb-4">

        <label class="form-label">
            KPI Remarks
        </label>

        <textarea
            name="kpi_remarks"
            class="form-control"
            rows="3"
        >{{ old('kpi_remarks', $record->kpi_remarks ?? '') }}</textarea>

    </div>

    {{-- ================= Appraisal Cycle ================= --}}
    <div class="col-12 mt-4">

        <h5 class="mb-3 text-primary">
            Appraisal Cycle
        </h5>

        <hr>

    </div>

    {{-- Cycle Name --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            Cycle Name
        </label>

        <input
            type="text"
            name="cycle_name"
            class="form-control"
            placeholder="Example: Jan-Jun 2026"
            value="{{ old('cycle_name', $record->cycle_name ?? '') }}"
        >

    </div>

    {{-- Cycle Start Date --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            Start Date
        </label>

        <input
            type="date"
            name="cycle_start_date"
            class="form-control"
            value="{{ old('cycle_start_date', $record->cycle_start_date ?? '') }}"
        >

    </div>

    {{-- Cycle End Date --}}
    <div class="col-md-4 mb-4">

        <label class="form-label">
            End Date
        </label>

        <input
            type="date"
            name="cycle_end_date"
            class="form-control"
            value="{{ old('cycle_end_date', $record->cycle_end_date ?? '') }}"
        >

    </div>
    {{-- ================= Promotion Details ================= --}}
<div class="col-12 mt-4">

    <h5 class="mb-3 text-primary">
        Promotion Details
    </h5>

    <hr>

</div>

{{-- Old Designation --}}
<div class="col-md-6 mb-4">

    <label class="form-label">
        Old Designation
    </label>

    <input
        type="text"
        name="old_designation"
        class="form-control"
        value="{{ old('old_designation', $record->old_designation ?? '') }}"
    >

</div>

{{-- New Designation --}}
<div class="col-md-6 mb-4">

    <label class="form-label">
        New Designation
    </label>

    <input
        type="text"
        name="new_designation"
        class="form-control"
        value="{{ old('new_designation', $record->new_designation ?? '') }}"
    >

</div>

{{-- Promotion Date --}}
<div class="col-md-6 mb-4">

    <label class="form-label">
        Promotion Date
    </label>

    <input
        type="date"
        name="promotion_date"
        class="form-control"
        value="{{ old('promotion_date', $record->promotion_date ?? '') }}"
    >

</div>

{{-- Promotion Reason --}}
<div class="col-md-6 mb-4">

    <label class="form-label">
        Promotion Reason
    </label>

    <textarea
        name="promotion_reason"
        class="form-control"
        rows="2"
    >{{ old('promotion_reason', $record->promotion_reason ?? '') }}</textarea>

</div>

{{-- ================= Warning Details ================= --}}
<div class="col-12 mt-4">

    <h5 class="mb-3 text-primary">
        Warning Details
    </h5>

    <hr>

</div>

{{-- Warning Type --}}
<div class="col-md-6 mb-4">

    <label class="form-label">
        Warning Type
    </label>

    <input
        type="text"
        name="warning_type"
        class="form-control"
        placeholder="Example: Late Attendance"
        value="{{ old('warning_type', $record->warning_type ?? '') }}"
    >

</div>

{{-- Warning Date --}}
<div class="col-md-6 mb-4">

    <label class="form-label">
        Warning Date
    </label>

    <input
        type="date"
        name="warning_date"
        class="form-control"
        value="{{ old('warning_date', $record->warning_date ?? '') }}"
    >

</div>

{{-- Warning Remarks --}}
<div class="col-md-6 mb-4">

    <label class="form-label">
        Warning Remarks
    </label>

    <textarea
        name="warning_remarks"
        class="form-control"
        rows="2"
    >{{ old('warning_remarks', $record->warning_remarks ?? '') }}</textarea>

</div>

{{-- Issued By --}}
<div class="col-md-6 mb-4">

    <label class="form-label">
        Issued By
    </label>

    <input
        type="text"
        name="issued_by"
        class="form-control"
        value="{{ old('issued_by', $record->issued_by ?? '') }}"
    >

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
@if ($errors->any())

<div class="alert alert-danger">
    <ul class="mb-0">

        @foreach ($errors->all() as $error)

        <li>{{ $error }}</li>

        @endforeach

    </ul>
</div>

@endif
{{-- PAGE HEADER --}}
<div class="page-header mb-4 d-flex justify-content-between align-items-center">

    <h5>

        {{ isset($record)
            ? 'Edit Medical Certificate'
            : 'Create Medical Certificate'
        }}

    </h5>

    <a href="{{ route('doctor.medical-certification.index') }}"
       class="btn btn-secondary btn-sm">

        <i class="feather-arrow-left me-1"></i>

        Back

    </a>

</div>
    
<div class="card">
<div class="card-body">


<div class="row">
    

   {{-- STAFF --}}
<div class="col-md-6 mb-3">

    <label>Staff *</label>

    <select name="employee_id"
            id="employee_id"
            class="form-control">

        <option value="">Select Staff</option>

        @foreach($employees as $employee)

            <option
                value="{{ $employee->employee_id }}"

                data-name="{{ $employee->name }}"

                data-department="{{ optional($employee->department)->department_name }}"

                data-designation="{{ optional($employee->designation)->designation_name }}"

                {{ old('employee_id', $record->employee_id ?? '') == $employee->employee_id ? 'selected' : '' }}
            >

                {{ $employee->name }}

            </option>

        @endforeach

    </select>

</div>
{{-- DEPARTMENT --}}
<div class="col-md-6 mb-3">

    <label>Department</label>

    <input type="text"
           id="department"
           name="department"
           class="form-control"
           readonly>

</div>


{{-- DESIGNATION --}}
<div class="col-md-6 mb-3">

    <label>Designation</label>

    <input type="text"
           id="designation"
           name="designation"
           class="form-control"
           readonly>

</div>


    {{-- CERTIFICATE TYPE --}}
    <div class="col-md-6 mb-3">

        <label>Certificate Type *</label>

        <select name="certificate_type"
                class="form-control">

            <option value="Sick Leave"
                {{ old('certificate_type', $record->certificate_type ?? '') == 'Sick Leave' ? 'selected' : '' }}>

                Sick Leave

            </option>

            <option value="Fitness"
                {{ old('certificate_type', $record->certificate_type ?? '') == 'Fitness' ? 'selected' : '' }}>

                Fitness

            </option>

            <option value="Insurance"
                {{ old('certificate_type', $record->certificate_type ?? '') == 'Insurance' ? 'selected' : '' }}>

                Insurance

            </option>

        </select>

    </div>


    {{-- ISSUE DATE --}}
    <div class="col-md-6 mb-3">

        <label>Issue Date *</label>

        <input type="date"
               name="issue_date"
               class="form-control"
               value="{{ old('issue_date', $record->issue_date ?? '') }}">

    </div>


    {{-- VALID FROM --}}
    <div class="col-md-6 mb-3">

        <label>Valid From *</label>

        <input type="date"
               name="valid_from"
               class="form-control"
               value="{{ old('valid_from', $record->valid_from ?? '') }}">

    </div>


    {{-- VALID UNTIL --}}
    <div class="col-md-6 mb-3">

        <label>Valid Until *</label>

        <input type="date"
               name="valid_until"
               class="form-control"
               value="{{ old('valid_until', $record->valid_until ?? '') }}">

    </div>


    {{-- DIAGNOSIS --}}
    <div class="col-md-12 mb-3">

        <label>Diagnosis / Reason</label>

        <textarea name="diagnosis_reason"
                  class="form-control"
                  rows="3">{{ old('diagnosis_reason', $record->diagnosis_reason ?? '') }}</textarea>

    </div>


    {{-- MEDICAL REMARKS --}}
    <div class="col-md-12 mb-3">

        <label>Medical Remarks</label>

        <textarea name="medical_remarks"
                  class="form-control"
                  rows="3">{{ old('medical_remarks', $record->medical_remarks ?? '') }}</textarea>

    </div>


    {{-- DOCTOR NAME --}}
    <div class="col-md-4 mb-3">

        <label>Doctor Name *</label>

        <input type="text"
               name="doctor_name"
               class="form-control"
               value="{{ old('doctor_name', $record->doctor_name ?? '') }}">

    </div>


    {{-- REGISTRATION NUMBER --}}
    <div class="col-md-4 mb-3">

        <label>Registration Number*</label>

        <input type="text"
               name="registration_number"
               class="form-control"
               value="{{ old('registration_number', $record->registration_number ?? '') }}">

    </div>


    {{-- HOSPITAL NAME --}}
    <div class="col-md-4 mb-3">

        <label>Hospital / Clinic Name*</label>

        <input type="text"
               name="hospital_name"
               class="form-control"
               value="{{ old('hospital_name', $record->hospital_name ?? '') }}">

    </div>

</div>

<hr>

<div class="d-flex justify-content-end">

    <button class="btn btn-primary">
        Save
    </button>

</div>


</div>
</div>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const employeeSelect =
        document.getElementById('employee_id');

    const department =
        document.getElementById('department');

    const designation =
        document.getElementById('designation');

    function fillEmployeeDetails() {

        let selected =
            employeeSelect.options[
                employeeSelect.selectedIndex
            ];

        department.value =
            selected.dataset.department || '';

        designation.value =
            selected.dataset.designation || '';
    }

    employeeSelect.addEventListener(
        'change',
        fillEmployeeDetails
    );

    fillEmployeeDetails();

});

</script>
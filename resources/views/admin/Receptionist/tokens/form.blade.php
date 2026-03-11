<div class="row">

    {{-- ===============================
        APPOINTMENT SELECTION
       =============================== --}}

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Appointment <span class="text-danger">*</span>
        </label>

        <select name="appointment_id"
                class="form-control"
                onchange="this.form.submit()">

            <option value="">Select Appointment</option>

            @foreach($appointments as $appointment)

                <option value="{{ $appointment->id }}"
                    {{ old('appointment_id', $selectedAppointment->id ?? '') == $appointment->id ? 'selected' : '' }}>

                    {{ $appointment->patient->patient_code }} -
                    {{ $appointment->patient->first_name }}
                    {{ $appointment->patient->last_name }}
                    |
                    {{ $appointment->appointment_date }}
                    {{ $appointment->appointment_time }}

                </option>

            @endforeach

        </select>
    </div>



    {{-- ===============================
        PATIENT
       =============================== --}}

    <div class="col-md-6 mb-3">
        <label class="form-label">Patient</label>

        <input type="text"
               class="form-control"
               value="{{ $selectedAppointment->patient->first_name ?? '' }} {{ $selectedAppointment->patient->last_name ?? '' }}"
               readonly>
    </div>



    {{-- ===============================
        DOCTOR
       =============================== --}}

    <div class="col-md-6 mb-3">
        <label class="form-label">Doctor</label>

        <input type="text"
               class="form-control"
               value="{{ $selectedAppointment->doctor->name??'' }} "
               readonly>
    </div>



    {{-- ===============================
        DEPARTMENT
       =============================== --}}

    <div class="col-md-6 mb-3">
        <label class="form-label">Department</label>

        <input type="text"
               class="form-control"
               value="{{ $selectedAppointment->department->department_name ?? '' }}"
               readonly>
    </div>



    {{-- ===============================
        STATUS
       =============================== --}}

    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>

        <input type="text"
               class="form-control"
               value="WAITING"
               readonly>
    </div>

</div>
<div class="mb-3">
    <label class="form-label">Patient</label>
    <select name="patient_id" class="form-control" required>
        <option value="">Select Patient</option>

        @foreach($patients as $patient)
            <option value="{{ $patient->id }}" {{ isset($appointment) && $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                {{ $patient->first_name }} {{ $patient->last_name }}
            </option>
        @endforeach

    </select>
</div>


<div class="mb-3">
    <label class="form-label">Department</label>
    <select name="department_id" id="department_id" class="form-control" required>
        <option value="">Select Department</option>

        @foreach($departments as $department)

            <option value="{{ $department->id }}" {{ isset($appointment) && $appointment->department_id == $department->id ? 'selected' : '' }}>
                {{ $department->department_name }}
            </option>

        @endforeach

    </select>
</div>


<div class="mb-3">
    <label class="form-label">Doctor</label>
    <select name="doctor_id" id="doctor_id" class="form-control" required>

        <option value="">Select Doctor</option>

        @foreach($doctors as $doctor)

            <option value="{{ $doctor->id }}" {{ isset($appointment) && $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                {{ $doctor->name }}
            </option>

        @endforeach

    </select>
</div>


<div class="mb-3">
    <label class="form-label">Consultation Fee</label>
    <input type="number" name="consultation_fee" id="consultation_fee" class="form-control">
</div>


<div class="mb-3">
    <label class="form-label">Appointment Date</label>
    <input type="date" name="appointment_date" class="form-control" value="{{ $appointment->appointment_date ?? '' }}"
        required>
</div>


<div class="mb-3">
    <label class="form-label">Appointment Time</label>
    <input type="time" name="appointment_time" class="form-control" value="{{ $appointment->appointment_time ?? '' }}"
        required>
</div>


<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="appointment_status" class="form-control">

        <option value="Scheduled">Scheduled</option>
        <option value="Cancelled">Cancelled</option>
        <option value="Completed">Completed</option>

    </select>
</div>

<script>
    document.getElementById('department_id').addEventListener('change', function () {

        let departmentId = this.value;
        let doctorDropdown = document.getElementById('doctor_id');

        doctorDropdown.innerHTML = '<option>Loading...</option>';

        fetch('/admin/appointments/get-doctors/' + departmentId)
            .then(response => response.json())
            .then(data => {

                doctorDropdown.innerHTML = '<option value="">Select Doctor</option>';

                data.forEach(function (doctor) {
                    doctorDropdown.innerHTML +=
                        `<option value="${doctor.id}">${doctor.name}</option>`;
                });

            });

    });
</script>
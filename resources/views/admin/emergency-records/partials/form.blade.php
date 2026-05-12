<form method="POST" action="{{ route('admin.emergency.store') }}">
    @csrf

    <div class="row">

        {{-- Patient Selection --}}
        <div class="col-md-6 mb-3">
            <label>Select Patient</label>
            <select id="patient_id" name="patient_id" class="form-control">
                <option value="">-- Select Patient --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">
                        {{ $patient->patient_code }} - {{ $patient->first_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Emergency Type --}}
        <div class="col-md-6 mb-3">
            <label>Emergency Type</label>
            <input type="text" name="emergency_type" class="form-control" required>
        </div>

        {{-- Auto-filled Fields --}}
        <div class="col-md-4 mb-3">
            <label>Patient Name</label>
            <input type="text" id="patient_name" name="patient_name" class="form-control" readonly>
        </div>

        <div class="col-md-2 mb-3">
            <label>Gender</label>
            <input type="text" id="gender" name="gender" class="form-control" readonly>
        </div>

        <div class="col-md-2 mb-3">
            <label>Age</label>
            <input type="text" id="age" name="age" class="form-control" readonly>
        </div>

        <div class="col-md-4 mb-3">
            <label>Mobile</label>
            <input type="text" id="mobile" name="mobile" class="form-control" readonly>
        </div>

        {{-- Blood Group --}}
        <div class="col-md-4 mb-3">
            <label>Blood Group</label>
            <input type="text" id="blood_group" class="form-control text-danger fw-bold" readonly>
        </div>

    </div>

    <button type="submit" class="btn btn-danger">
        🚑 Create Emergency Case
    </button>

</form>

{{-- JS --}}
<script>
document.getElementById('patient_id').addEventListener('change', function () {

    let patientId = this.value;
    if (!patientId) return;

    fetch(`/admin/patients/${patientId}/basic-info`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('patient_name').value = data.name;
            document.getElementById('gender').value = data.gender;
            document.getElementById('age').value = data.age;
            document.getElementById('mobile').value = data.mobile;
            document.getElementById('blood_group').value = data.blood_group ?? 'N/A';
        });
});
</script>
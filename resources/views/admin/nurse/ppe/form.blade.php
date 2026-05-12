<div class="mb-4">
    <label>Patient</label>
    <select name="patient_id" class="form-control">
        @foreach($patients as $patient)
            <option value="{{ $patient->id }}" {{ old('patient_id', $log->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                {{ $patient->first_name }} {{ $patient->last_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label>PPE Used</label>
    <select name="ppe_used" id="ppe_used" class="form-control">
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>
</div>

<div class="mb-4">
    <label>PPE Type</label>
    <select name="ppe_type" id="ppe_type" class="form-control">
        <option value="">Select</option>
        <option value="Mask">Mask</option>
        <option value="Gloves">Gloves</option>
        <option value="Face Shield">Face Shield</option>
        <option value="Full Kit">Full Kit</option>
    </select>
</div>

<div class="mb-4">
    <label>Compliance Status</label>
    <select name="compliance_status" id="compliance_status" class="form-control">
        <option value="Compliant">Compliant</option>
        <option value="Non-compliant">Non-compliant</option>
    </select>
</div>

<div class="mb-4">
    <label>Notes</label>
    <textarea name="notes" class="form-control">{{ old('notes', $log->notes ?? '') }}</textarea>
</div>

<script>
    document.getElementById('ppe_used').addEventListener('change', function () {

        let ppeType = document.getElementById('ppe_type');
        let status = document.getElementById('compliance_status');

        if (this.value == "0") {
            ppeType.value = "";
            ppeType.disabled = true;

            status.value = "Non-compliant";
            status.disabled = true;
        } else {
            ppeType.disabled = false;
            status.disabled = false;
        }

    });
</script>
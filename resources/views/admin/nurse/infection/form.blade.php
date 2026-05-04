<div class="mb-3">
    <label>Patient</label>
    <select name="patient_id" class="form-control">

        @foreach($patients as $patient)
            <option value="{{ $patient->id }}" {{ old('patient_id', $log->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                {{ $patient->first_name }} {{ $patient->last_name }}
            </option>
        @endforeach

    </select>
</div>

<div class="mb-3">
    <label>Infection Type</label>
    <input type="text" name="infection_type" class="form-control"
        value="{{ old('infection_type', $log->infection_type ?? '') }}">
</div>

<div class="mb-3">
    <label>Severity</label>
    <select name="severity" class="form-control">
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
    </select>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="Active">Active</option>
        <option value="Recovered">Recovered</option>
    </select>
</div>

<div class="mb-3">
    <label>Notes</label>
    <textarea name="notes" class="form-control">{{ old('notes', $log->notes ?? '') }}</textarea>
</div>
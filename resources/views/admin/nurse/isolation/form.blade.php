<div class="mb-4">
    <label>Patient</label>
    <select name="patient_id" class="form-control">

        @foreach($patients as $patient)
            <option value="{{ $patient->id }}" {{ old('patient_id', $record->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                {{ $patient->first_name }} {{ $patient->last_name }}
            </option>
        @endforeach

    </select>
</div>

<div class="mb-4">
    <label>Isolation Type</label>
    <select name="isolation_type" class="form-control">
        <option value="Airborne">Airborne</option>
        <option value="Contact">Contact</option>
        <option value="Droplet">Droplet</option>
        <option value="Bloodborne">Bloodborne</option>
        <option value="Protective">Protective</option>
    </select>
</div>

<div class="mb-4">
    <label>Start Date</label>
    <input type="date" name="start_date" class="form-control"
        value="{{ old('start_date', $record->start_date ?? '') }}">
</div>

<div class="mb-4">
    <label>End Date</label>
    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $record->end_date ?? '') }}">
</div>

<div class="mb-4">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="Active">Active</option>
        <option value="Completed">Completed</option>
    </select>
</div>

<div class="mb-4">
    <label>Notes</label>
    <textarea name="notes" class="form-control">{{ old('notes', $record->notes ?? '') }}</textarea>
</div>
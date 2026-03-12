<div class="mb-4">
    <label class="form-label">Patient <span class="text-danger">*</span></label>

    <select name="patient_id" class="form-select">

        <option value="">Select Patient</option>

        @foreach($patients as $patient)
            <option value="{{ $patient->id }}">
                {{ $patient->first_name }} {{ $patient->last_name }}
            </option>
        @endforeach

    </select>

</div>

@error('patient_id')
    <small class="text-danger">{{ $message }}</small>
@enderror

<div class="mb-4">
    <label class="form-label">Temperature</label>
    <input type="text" name="temperature" class="form-control"
        value="{{ old('temperature', $vital->temperature ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Systolic BP</label>
    <input type="number" name="blood_pressure_systolic" class="form-control"
        value="{{ old('blood_pressure_systolic', $vital->blood_pressure_systolic ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Diastolic BP</label>
    <input type="number" name="blood_pressure_diastolic" class="form-control"
        value="{{ old('blood_pressure_diastolic', $vital->blood_pressure_diastolic ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Pulse Rate</label>
    <input type="number" name="pulse_rate" class="form-control"
        value="{{ old('pulse_rate', $vital->pulse_rate ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Respiratory Rate</label>
    <input type="number" name="respiratory_rate" class="form-control"
        value="{{ old('respiratory_rate', $vital->respiratory_rate ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">SpO2</label>
    <input type="number" name="spo2" class="form-control" value="{{ old('spo2', $vital->spo2 ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Blood Sugar</label>
    <input type="number" name="blood_sugar" class="form-control"
        value="{{ old('blood_sugar', $vital->blood_sugar ?? '') }}">
</div>

<div class="mb-4">
    <label class="form-label">Weight</label>
    <input type="number" name="weight" class="form-control" value="{{ old('weight', $vital->weight ?? '') }}">
</div>
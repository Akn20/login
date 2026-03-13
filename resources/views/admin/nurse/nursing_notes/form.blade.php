@php
    $note = $note ?? null;
@endphp

<div class="row">

    <!-- Patient -->
    <div class="col-md-6 mb-3">
        <label for="patient_id" class="form-label">Patient <span class="text-danger">*</span></label>
        <select name="patient_id" id="patient_id" class="form-select">
            <option value="">Select Patient</option>
            @foreach($patients ?? [] as $patient)
                <option value="{{ $patient->id }}"
                    {{ old('patient_id', $note->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                    {{ $patient->first_name ?? '' }} {{ $patient->last_name ?? '' }}
                    ({{ $patient->patient_code ?? '' }})               
                </option>
            @endforeach
        </select>
        @error('patient_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


 <!-- Nurse -->
    <div class="col-md-6 mb-3">
        <label for="nurse_id" class="form-label">Nurse <span class="text-danger">*</span></label>
        <select name="nurse_id" id="nurse_id" class="form-select">
            <option value="">Select Nurse</option>
            @foreach($nurses ?? [] as $nurse)
                <option value="{{ $nurse->id }}"
                    {{ old('nurse_id', $note->nurse_id ?? '') == $nurse->id ? 'selected' : '' }}>
                    {{ $nurse->name ?? '-' }}
                </option>
            @endforeach
        </select>
        @error('nurse_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Shift -->
    <div class="col-md-6 mb-3">
        <label for="shift" class="form-label">Shift <span class="text-danger">*</span></label>
        <select name="shift" id="shift" class="form-select">
            <option value="">Select Shift</option>
            <option value="Morning" {{ old('shift', $note->shift ?? '') == 'Morning' ? 'selected' : '' }}>Morning</option>
            <option value="Evening" {{ old('shift', $note->shift ?? '') == 'Evening' ? 'selected' : '' }}>Evening</option>
            <option value="Night" {{ old('shift', $note->shift ?? '') == 'Night' ? 'selected' : '' }}>Night</option>
        </select>
        @error('shift')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Patient Condition -->
    <div class="col-md-6 mb-3">
        <label for="patient_condition" class="form-label">Patient Condition</label>
        <textarea name="patient_condition"
                  id="patient_condition"
                  rows="3"
                  class="form-control"
                  placeholder="Enter patient condition">{{ old('patient_condition', $note->patient_condition ?? '') }}</textarea>
        @error('patient_condition')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    <!-- Intake Details -->
    <div class="col-md-6 mb-3">
        <label for="intake_details" class="form-label">Intake Details</label>
        <textarea name="intake_details"
                  id="intake_details"
                  rows="3"
                  class="form-control"
                  placeholder="Enter intake details">{{ old('intake_details', $note->intake_details ?? '') }}</textarea>
        @error('intake_details')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Output Details -->
    <div class="col-md-6 mb-3">
        <label for="output_details" class="form-label">Output Details</label>
        <textarea name="output_details"
                  id="output_details"
                  rows="3"
                  class="form-control"
                  placeholder="Enter output details">{{ old('output_details', $note->output_details ?? '') }}</textarea>
        @error('output_details')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Wound Care Notes -->
    <div class="col-md-6 mb-3">
        <label for="wound_care_notes" class="form-label">Wound Care Notes</label>
        <textarea name="wound_care_notes"
                  id="wound_care_notes"
                  rows="3"
                  class="form-control"
                  placeholder="Enter wound care notes">{{ old('wound_care_notes', $note->wound_care_notes ?? '') }}</textarea>
        @error('wound_care_notes')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

</div>
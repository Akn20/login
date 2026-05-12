    @csrf

<div class="row">

    <!-- LEFT -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Calibration Details</h5>

                <!-- Equipment -->
                <div class="mb-3">
                    <label>Equipment *</label>
                    <select name="equipment_id" class="form-control" required>
                        <option value="">Select Equipment</option>
                        @foreach($equipment as $eq)
                            <option value="{{ $eq->id }}"
                                {{ old('equipment_id', $calibration->equipment_id ?? '') == $eq->id ? 'selected' : '' }}>
                                {{ $eq->name }} ({{ $eq->equipment_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Type -->
                <div class="mb-3">
                    <label>Calibration Type *</label>
                    <input type="text" name="calibration_type" class="form-control"
                        value="{{ old('calibration_type', $calibration->calibration_type ?? '') }}" required>
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label>Calibration Date *</label>
                    <input type="date" name="calibration_date" class="form-control"
                        value="{{ old('calibration_date', $calibration->calibration_date ?? '') }}" required>
                </div>

            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Result & Info</h5>

                <!-- Technician -->
                <div class="mb-3">
                    <label>Technician</label>
                    <input type="text" name="technician" class="form-control"
                        value="{{ old('technician', $calibration->technician ?? '') }}">
                </div>

                <!-- Result -->
                <div class="mb-3">
                    <label>Result *</label>
                    <select name="result" class="form-control">
                        <option value="Pass">Pass</option>
                        <option value="Fail">Fail</option>
                    </select>
                </div>

                <!-- Next Due -->
                <div class="mb-3">
                    <label>Next Due Date</label>
                    <input type="date" name="next_due_date" class="form-control"
                        value="{{ old('next_due_date', $calibration->next_due_date ?? '') }}">
                </div>

                <!-- Notes -->
                <div class="mb-3">
                    <label>Notes</label>
                    <textarea name="notes" class="form-control">{{ old('notes', $calibration->notes ?? '') }}</textarea>
                </div>

            </div>
        </div>
    </div>

</div>
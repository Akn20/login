@csrf

<div class="row">

    <!-- LEFT -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Breakdown Details</h5>

                <!-- Equipment -->
                <div class="mb-3">
                    <label class="form-label">Equipment *</label>
                    <select name="equipment_id" class="form-control" required>
                        <option value="">Select Equipment</option>
                        @foreach($equipment as $eq)
                            <option value="{{ $eq->id }}"
                                {{ old('equipment_id', $breakdown->equipment_id ?? '') == $eq->id ? 'selected' : '' }}>
                                {{ $eq->name }} ({{ $eq->equipment_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control" required>{{ old('description', $breakdown->description ?? '') }}</textarea>
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label class="form-label">Breakdown Date *</label>
                    <input type="date" name="breakdown_date" class="form-control"
                        value="{{ old('breakdown_date', $breakdown->breakdown_date ?? '') }}" required>
                </div>

            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <!-- Reported By -->
                <div class="mb-3">
                    <label class="form-label">Reported By *</label>
                    <input type="text" name="reported_by" class="form-control"
                        value="{{ old('reported_by', $breakdown->reported_by ?? '') }}" required>
                </div>

                <!-- Severity -->
                <div class="mb-3">
                    <label class="form-label">Severity *</label>
                    <select name="severity" class="form-control" required>
                        @foreach(['Low','Medium','High','Critical'] as $level)
                            <option value="{{ $level }}"
                                {{ old('severity', $breakdown->severity ?? '') == $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        @foreach(['Reported','Under Repair','Resolved'] as $st)
                            <option value="{{ $st }}"
                                {{ old('status', $breakdown->status ?? '') == $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>

</div>
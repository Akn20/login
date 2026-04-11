@csrf

<div class="row">

    <!-- LEFT -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Maintenance Details</h5>

                <!-- Equipment -->
                <div class="mb-3">
                    <label>Equipment *</label>
                    <select name="equipment_id" class="form-control" required>
                        <option value="">Select Equipment</option>
                        @foreach($equipment as $eq)
                            <option value="{{ $eq->id }}"
                                {{ old('equipment_id', $maintenance->equipment_id ?? '') == $eq->id ? 'selected' : '' }}>
                                {{ $eq->name }} ({{ $eq->equipment_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Type -->
                <div class="mb-3">
                    <label>Maintenance Type *</label>
                    <select name="maintenance_type" class="form-control" required>
                        <option value="Preventive">Preventive</option>
                        <option value="Corrective">Corrective</option>
                    </select>
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label>Date *</label>
                    <input type="date" name="maintenance_date" class="form-control"
                        value="{{ old('maintenance_date', $maintenance->maintenance_date ?? '') }}" required>
                </div>

            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <!-- Technician -->
                <div class="mb-3">
                    <label>Technician</label>
                    <input type="text" name="technician" class="form-control"
                        value="{{ old('technician', $maintenance->technician ?? '') }}">
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label>Status *</label>
                    <select name="status" class="form-control">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ old('description', $maintenance->description ?? '') }}</textarea>
                </div>

            </div>
        </div>
    </div>

</div>
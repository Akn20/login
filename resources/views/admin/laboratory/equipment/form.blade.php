@csrf

<div class="row">

    <!-- LEFT -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Equipment Details</h5>

                <div class="mb-3">
                    <label class="form-label">Equipment Name *</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $equipment->name ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Equipment Type *</label>
                    <select name="type" class="form-control" required>
                        <option value="">Select Type</option>
                        @foreach(['Analyzer','Microscope','X-Ray Machine','ECG Machine','Ultrasound','Centrifuge','Other'] as $type)
                            <option value="{{ $type }}"
                                {{ old('type', $equipment->type ?? '') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Manufacturer</label>
                    <input type="text" name="manufacturer" class="form-control"
                        value="{{ old('manufacturer', $equipment->manufacturer ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Model Number</label>
                    <input type="text" name="model_number" class="form-control"
                        value="{{ old('model_number', $equipment->model_number ?? '') }}">
                </div>

            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Additional Info</h5>

                <div class="mb-3">
                    <label class="form-label">Serial Number</label>
                    <input type="text" name="serial_number" class="form-control"
                        value="{{ old('serial_number', $equipment->serial_number ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Installation Date</label>
                    <input type="date" name="installation_date" class="form-control"
                        value="{{ old('installation_date', $equipment->installation_date ?? '') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control"
                        value="{{ old('location', $equipment->location ?? '') }}">
                </div>

            </div>
        </div>
    </div>

    <!-- STATUS -->
    <div class="col-12">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Status Settings</h5>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Condition Status *</label>
                        <select name="condition_status" class="form-control" required>
                            <option value="Active">Active</option>
                            <option value="Under Maintenance">Under Maintenance</option>
                            <option value="Out of Service">Out of Service</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">System Status *</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $equipment->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $equipment->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
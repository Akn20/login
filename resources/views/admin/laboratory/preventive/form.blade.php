@csrf

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

<div class="col-xl-6">
    <div class="card">
        <div class="card-body">

            <h5 class="mb-4">Schedule Details</h5>

            <div class="mb-3">
                <label>Equipment *</label>
                <select name="equipment_id" class="form-control" required>
                    <option value="">Select Equipment</option>
                    @foreach($equipment as $eq)
                        <option value="{{ $eq->id }}"
                        {{ old('equipment_id', $record->equipment_id ?? '') == $eq->id ? 'selected' : '' }}>
                        {{ $eq->name }} ({{ $eq->equipment_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Frequency *</label>
                <select name="frequency" class="form-control">
                    <option>Monthly</option>
                    <option>Quarterly</option>
                    <option>Yearly</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Next Date *</label>
                <input type="date" name="next_maintenance_date" class="form-control"
                    value="{{ old('next_maintenance_date', $record->next_maintenance_date ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Technician</label>
                <input type="text" name="technician" class="form-control"
                    value="{{ old('technician', $record->technician ?? '') }}">
            </div>

        </div>
    </div>
</div>

</div>
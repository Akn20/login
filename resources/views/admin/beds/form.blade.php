@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<div class="row">

    <div class="col-md-6 mb-3">
        <label>Bed Code</label>
        <input type="text"
               name="bed_code"
               id="bed_code"
               class="form-control"
               value="{{ old('bed_code', $bed->bed_code ?? '') }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Ward</label>
        <select name="ward_id" class="form-control" required>
            <option value="">Select Ward</option>
            @foreach($wards as $ward)
                <option value="{{ $ward->id }}"
                    {{ old('ward_id', $bed->ward_id ?? '') == $ward->id ? 'selected' : '' }}>
                    {{ $ward->ward_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Room Number</label>
        <input type="text"
               name="room_number"
               class="form-control"
               value="{{ old('room_number', $bed->room_number ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Bed Type</label>
        <select name="bed_type" class="form-control" required>
            @foreach(['General','ICU','Private','Semi-Private'] as $type)
                <option value="{{ $type }}"
                    {{ old('bed_type', $bed->bed_type ?? '') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            @foreach(['Available','Occupied','Maintenance','Cleaning'] as $status)
                <option value="{{ $status }}"
                    {{ old('status', $bed->status ?? 'Available') == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-primary">
            {{ isset($bed) ? 'Update' : 'Submit' }}
        </button>
                <a href="{{ route('admin.beds.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
    </div>

</div>

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<div class="row">

    {{-- Ward --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Ward</label>
        <select name="ward_id" class="form-control" required>
            <option value="">Select Ward</option>
            @foreach($wards as $ward)
                <option value="{{ $ward->id }}"
                    {{ old('ward_id', $room->ward_id ?? '') == $ward->id ? 'selected' : '' }}>
                    {{ $ward->ward_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Room Number --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Room Number</label>
        <input type="text"
               name="room_number"
               class="form-control"
               value="{{ old('room_number', $room->room_number ?? '') }}" required>
    </div>

    {{-- Room Type --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Room Type</label>
        <select name="room_type" class="form-control" required>
            <option value="">Select Type</option>

            <option value="General"
                {{ old('room_type', $room->room_type ?? '') == 'General' ? 'selected' : '' }}>
                General
            </option>

            <option value="ICU"
                {{ old('room_type', $room->room_type ?? '') == 'ICU' ? 'selected' : '' }}>
                ICU
            </option>

            <option value="Private"
                {{ old('room_type', $room->room_type ?? '') == 'Private' ? 'selected' : '' }}>
                Private
            </option>
        </select>
    </div>

    {{-- Total Beds --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Total Beds</label>
        <input type="number"
               name="total_beds"
               class="form-control"
               value="{{ old('total_beds', $room->total_beds ?? '') }}" required>
    </div>

    {{-- Status --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control" required>
            <option value="available"
                {{ old('status', $room->status ?? '') == 'available' ? 'selected' : '' }}>
                Available
            </option>

            <option value="occupied"
                {{ old('status', $room->status ?? '') == 'occupied' ? 'selected' : '' }}>
                Occupied
            </option>

            <option value="maintenance"
                {{ old('status', $room->status ?? '') == 'maintenance' ? 'selected' : '' }}>
                Maintenance
            </option>

            <option value="cleaning"
                {{ old('status', $room->status ?? '') == 'cleaning' ? 'selected' : '' }}>
                Cleaning
            </option>
        </select>
    </div>

</div>

<div class="text-end">
    <button type="submit" class="btn btn-primary">
        {{ isset($room) ? 'Update Room' : 'Save Room' }}
    </button>
</div>
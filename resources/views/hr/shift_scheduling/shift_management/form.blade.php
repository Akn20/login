@csrf

<div class="row">

    {{-- LEFT CARD --}}
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Shift Basic Details</h5>

                <div class="mb-3">
                    <label class="form-label">Shift Name *</label>
                    <input type="text"
                        name="shift_name"
                        class="form-control"
                        value="{{ old('shift_name', $shift->shift_name ?? '') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Start Time *</label>
                    <input type="time"
                        name="start_time"
                        class="form-control"
                        value="{{ old('start_time', $shift->start_time ?? '') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">End Time *</label>
                    <input type="time"
                        name="end_time"
                        class="form-control"
                        value="{{ old('end_time', $shift->end_time ?? '') }}"
                        required>
                </div>

            </div>
        </div>
    </div>


    {{-- RIGHT CARD --}}
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Shift Settings</h5>

                <div class="mb-3">
                    <label class="form-label">Grace Time (Minutes)</label>
                    <input type="number"
                        name="grace_minutes"
                        class="form-control"
                        value="{{ old('grace_minutes', $shift->grace_minutes ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Break Duration (Minutes)</label>
                    <input type="number"
                        name="break_minutes"
                        class="form-control"
                        value="{{ old('break_minutes', $shift->break_minutes ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status *</label>

                    <select name="status" class="form-control" required>
                        <option value="1"
                            {{ old('status', $shift->status ?? 1) == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                            {{ old('status', $shift->status ?? 1) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>

                </div>

            </div>
        </div>
    </div>

</div>
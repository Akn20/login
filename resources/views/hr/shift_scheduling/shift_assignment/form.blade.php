@csrf

<div class="row">

    {{-- LEFT CARD --}}
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Shift Assignment</h5>

                <div class="mb-3">
                    <label class="form-label">Employee *</label>
                    <select name="staff_id" class="form-control" required>
                        <option value="">Select Employee</option>

                        @foreach($staff as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('staff_id', $assignment->staff_id ?? '') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Shift *</label>
                    <select name="shift_id" class="form-control" required>

                        <option value="">Select Shift</option>

                        @foreach($shifts as $id => $shift)
                            <option value="{{ $id }}"
                                {{ old('shift_id', $assignment->shift_id ?? '') == $id ? 'selected' : '' }}>
                                {{ $shift }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>
        </div>
    </div>


    {{-- RIGHT CARD --}}
    <div class="col-xl-6">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <h5 class="mb-4">Assignment Details</h5>

                <div class="mb-3">
                    <label class="form-label">Start Date *</label>
                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="{{ old('start_date', $assignment->start_date ?? '') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date"
                           name="end_date"
                           class="form-control"
                           value="{{ old('end_date', $assignment->end_date ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status *</label>

                    <select name="status" class="form-control">

                        <option value="1"
                        {{ old('status', $assignment->status ?? 1) == 1 ? 'selected' : '' }}>
                        Active
                        </option>

                        <option value="0"
                        {{ old('status', $assignment->status ?? 1) == 0 ? 'selected' : '' }}>
                        Inactive
                        </option>

                    </select>
                </div>

            </div>
        </div>
    </div>

</div>
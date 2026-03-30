{{-- Holiday Name --}}
<div class="mb-3">
    <label class="form-label">Holiday Name *</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $holiday->name ?? '') }}" required>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Start Date *</label>
        <input type="date" name="start_date" class="form-control"
            value="{{ old('start_date', isset($holiday) ? $holiday->start_date->format('Y-m-d') : '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">End Date *</label>
        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
            value="{{ old('end_date', isset($holiday) ? $holiday->end_date->format('Y-m-d') : '') }}" required>
        @error('end_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class=" col-md-6 mb-3">
        <label class="form-label">Select Roles</label>

        @php
            $selectedRoles = old(
                'roles',
                isset($weekend) && $weekend->roles
                ? (is_array($weekend->roles) ? $weekend->roles : json_decode($weekend->roles, true))
                : []
            );
        @endphp

        <select id="roles-select" name="roles[]" class="form-select @error('roles') is-invalid @enderror" multiple>

            @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ collect($selectedRoles)->contains($role->id) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach

        </select>

        @error('roles')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Select Staff</label>

        @php
            $selectedStaff = old(
                'staff',
                isset($weekend) && $weekend->staff
                ? (is_array($weekend->staff) ? $weekend->staff : json_decode($weekend->staff, true))
                : []
            );
        @endphp

        <select id="staff-select" name="staff[]" class="form-select @error('staff') is-invalid @enderror" multiple>
        </select>

        @error('staff')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

</div>

{{-- Holiday Details --}}
<div class="mb-3">
    <label class="form-label">Holiday Details</label>
    <textarea name="details" class="form-control" rows="4">
        {{ old('details', $holiday->details ?? '') }}
    </textarea>
</div>

{{-- Upload Document --}}
<div class="mb-3">
    <label class="form-label">Upload Document</label>
    <input type="file" name="document" class="form-control">

    @if(isset($holiday) && $holiday->document)
        <small class="text-success">Current: {{ $holiday->document }}</small>
    @endif
</div>

{{-- Status --}}
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control">
        <option value="active" {{ old('status', $holiday->status ?? 'active') == 'active' ? 'selected' : '' }}>
            Active
        </option>
        <option value="inactive" {{ old('status', $holiday->status ?? 'active') == 'inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>
{{-- Replace the bottom section of your holiday form.blade.php --}}
<div class="mt-3 d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary btn-sm px-4">
        <i class="feather-save me-1"></i> {{ isset($holiday) ? 'Update' : 'Save' }}
    </button>

    <a href="{{ route('hr.holidays.index') }}" class="btn btn-light btn-sm px-4">
        Cancel
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const roleSelect = new TomSelect('#roles-select', {
            plugins: ['remove_button'],
            closeAfterSelect: false,
            placeholder: 'Select roles'
        });

        const staffSelect = new TomSelect('#staff-select', {
            plugins: ['remove_button'],
            closeAfterSelect: false,
            placeholder: 'Select staff'
        });
        roleSelect.on('change', function (values) {

            staffSelect.clear();        // remove selected
            staffSelect.clearOptions(); // remove options

            if (values.length === 0) {
                return;
            }

            fetch("{{ route('hr.weekends.staff-by-roles') }}?roles[]=" + values.join('&roles[]='))

                .then(res => res.json())

                .then(data => {

                    data.forEach(staff => {

                        staffSelect.addOption({
                            value: staff.id,
                            text: staff.name
                        });

                    });

                    staffSelect.refreshOptions(false);

                });

        });


    });
</script>
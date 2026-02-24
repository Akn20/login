<div class="row">
    {{-- Configuration Name --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Configuration Name<span class="text-danger">*</span></label>
        <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $weekend->name ?? '') }}"
            placeholder="e.g., Standard Nursing Shift Offs"
        >
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Status --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Status<span class="text-danger">*</span></label>
        <select
            name="status"
            class="form-select @error('status') is-invalid @enderror"
        >
            @php
                $statusValue = old('status', $weekend->status ?? 'inactive');
            @endphp
            <option value="active"   {{ $statusValue === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $statusValue === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">
            If set to Active, other active configurations will be auto‑deactivated.
        </small>
    </div>
</div>

<div class="row">
    {{-- Weekend Days --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Weekend Days<span class="text-danger">*</span></label>
        @php
            $selectedDays = old(
                'days',
                isset($weekend) && $weekend->days
                    ? (is_array($weekend->days) ? $weekend->days : (json_decode($weekend->days, true) ?? []))
                    : []
            );
        @endphp
        <select
            name="days[]"
            class="form-select @error('days') is-invalid @enderror"
            multiple
            size="7"
        >
            @foreach ($days as $day)
                <option
                    value="{{ $day }}"
                    {{ collect($selectedDays)->contains($day) ? 'selected' : '' }}
                >
                    {{ $day }}
                </option>
            @endforeach
        </select>
        @error('days')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        @error('days.*')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">
            Select one or more days (e.g., Friday and Saturday).
        </small>
    </div>

    {{-- Weekend Details --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Weekend Details</label>
        <textarea
            name="details"
            class="form-control weekend-details-editor @error('details') is-invalid @enderror"
            rows="8"
            placeholder="Enter any specific instructions regarding weekend shifts..."
        >{{ old('details', $weekend->details ?? '') }}</textarea>
        @error('details')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mt-3 d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="feather-save me-1"></i> {{ isset($weekend) ? 'Update' : 'Save' }}
    </button>
    <a href="{{ route('admin.weekends.index') }}" class="btn btn-light">
        Cancel
    </a>
</div>

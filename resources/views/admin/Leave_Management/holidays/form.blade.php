{{-- Holiday Name --}}
<div class="mb-3">
    <label class="form-label">Holiday Name *</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $holiday->name ?? '') }}" required>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Start Date *</label>
        <input type="date" name="start_date" class="form-control"
               value="{{ old('start_date', isset($holiday) ? $holiday->start_date->format('Y-m-d') : '') }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">End Date *</label>
        <input type="date" name="end_date" class="form-control"
               value="{{ old('end_date', isset($holiday) ? $holiday->end_date->format('Y-m-d') : '') }}"
               required>
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
        <option value="1"
            {{ old('status', $holiday->status ?? 1) == 1 ? 'selected' : '' }}>
            Active
        </option>
        <option value="0"
            {{ old('status', $holiday->status ?? 1) == 0 ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>
{{-- Replace the bottom section of your holiday form.blade.php --}}
<div class="mt-3 d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary btn-sm px-4">
        <i class="feather-save me-1"></i> {{ isset($holiday) ? 'Update' : 'Save' }}
    </button>
    
    <a href="{{ route('admin.holidays.index') }}" class="btn btn-light btn-sm px-4">
        Cancel
    </a>
</div>
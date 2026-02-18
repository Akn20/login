<div class="row">

    <!-- Module Label -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Module Label</label>
        <input type="text"
       class="form-control"
       name="module_label"
       value="{{ old('module_label', isset($module) ? $module->module_label : '') }}"
       placeholder="patient_registration"
       required>

    </div>

    <!-- Module Display Name -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Module Display Name</label>
        <input type="text"
               class="form-control"
               name="module_display_name"
               value="{{ old('module_display_name', $module->module_display_name ?? '') }}"
               placeholder="Patient Registration"
               required>
    </div>

    <!-- Parent Module -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Parent Module</label>

        <select name="parent_module" class="form-control">
            <option value="">Select Parent Module</option>

            @foreach($modules as $parent)
                <option value="{{ $parent->module_label }}"
                    {{ old('parent_module', $module->parent_module ?? '') == $parent->module_label ? 'selected' : '' }}>
                    {{ $parent->module_display_name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Priority -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Priority</label>
        <input type="number"
               name="priority"
               class="form-control"
               value="{{ old('priority', $module->priority ?? 1) }}"
               required>
    </div>

    <!-- Icon -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Icon</label>
        <input type="text"
               class="form-control"
               name="icon"
               value="{{ old('icon', $module->icon ?? '') }}"
               placeholder="feather-user"
               required>
    </div>

    <!-- File URL -->
    <div class="col-md-6 mb-3">
        <label class="form-label">File URL</label>
        <input type="text"
               class="form-control"
               name="file_url"
               value="{{ old('file_url', $module->file_url ?? '') }}"
               placeholder="/patient-registration"
               required>
    </div>

    <!-- Page Name -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Page Name</label>
        <input type="text"
               class="form-control"
               name="page_name"
               value="{{ old('page_name', $module->page_name ?? '') }}"
               placeholder="modules.patient-registration"
               required>
    </div>

    <!-- Type -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Type</label>
        <select class="form-control" name="type" required>
            <option value="">Select</option>
            @foreach(['Web','App','Both'] as $type)
                <option value="{{ $type }}"
                    {{ old('type', $module->type ?? '') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Access For -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Access For</label>
        <select class="form-control" name="access_for" required>
            <option value="" >Select</option>
            <option value="institution"
                {{ old('access_for', $module->access_for ?? '') == 'institution' ? 'selected' : '' }}>
                Institution
            </option>
            <option value="service"
                {{ old('access_for', $module->access_for ?? '') == 'service' ? 'selected' : '' }}>
                Service
            </option>
        </select>
    </div>

    <div class="mt-3">
    <button type="submit" class="btn btn-primary">
        {{ isset($module) ? 'Update' : 'Submit' }}
    </button>
</div>


</div>
@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Module Details</h4>

    <a href="{{ route('modules.index') }}" 
       class="btn btn-sm btn-outline-primary">
        <i class="feather feather-arrow-left"></i> Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-6">
                <label class="text-muted small">Module Label</label>
                <div class="fw-semibold fs-6">
                    {{ $module->module_label }}
                </div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Display Name</label>
                <div class="fw-semibold fs-6">
                    {{ $module->module_display_name }}
                </div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Parent Module</label>
                <div class="fw-semibold">
                    {{ $module->parent_module ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Priority</label>
                <div class="fw-semibold">
                    {{ $module->priority }}
                </div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Icon</label>
                <div class="fw-semibold">
                    <i class="feather {{ $module->icon }}"></i>
                    {{ $module->icon }}
                </div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">File URL</label>
                <div class="fw-semibold text-primary">
                    {{ $module->file_url }}
                </div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Page Name</label>
                <div class="fw-semibold">
                    {{ $module->page_name }}
                </div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Type</label>
                <div class="fw-semibold">
                    {{ ucfirst($module->type) }}
                </div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Access For</label>
                <div class="fw-semibold">
                    {{ ucfirst($module->access_for) }}
                </div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Status</label>
                <div>
                    @if($module->status)
                        <span class="text-success fw-semibold">Active</span>
                    @else
                        <span class="text-danger fw-semibold">Inactive</span>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
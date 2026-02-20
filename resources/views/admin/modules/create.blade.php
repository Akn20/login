@extends('layouts.admin')

@section('page-title', 'Create Module | ' . config('app.name'))

@section('content')

    <div class="main-content">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header mb-4">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Create Module</h5>
                </div>
            </div>
        </div>

        {{-- ================= CARD ================= --}}
        <div class="card stretch stretch-full">
            <div class="card-body">

                <form action="{{ route('admin.modules.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">

                        <!-- Module Label -->
                        <div class="col-md-6">
                            <label class="form-label">Module Label</label>
                            <input type="text" class="form-control" name="module_label" placeholder="patient_registration"
                                required>
                        </div>

                        <!-- Module Display Name -->
                        <div class="col-md-6">
                            <label class="form-label">Module Display Name</label>
                            <input type="text" class="form-control" name="module_display_name"
                                placeholder="Patient Registration" required>
                        </div>

                        <!-- Parent Module -->
                        <div class="col-md-6">
                            <label class="form-label">Parent Module</label>
                            <select name="parent_module" class="form-control">
                                <option value="">Select Parent Module</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->module_label }}">
                                        {{ $module->module_display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Priority -->
                        <div class="col-md-6">
                            <label class="form-label">Priority</label>
                            <input type="number" name="priority" class="form-control" required>
                        </div>

                        <!-- Icon -->
                        <div class="col-md-6">
                            <label class="form-label">Icon</label>
                            <input type="text" class="form-control" name="icon" placeholder="feather-user" required>
                        </div>

                        <!-- File URL -->
                        <div class="col-md-6">
                            <label class="form-label">File URL</label>
                            <input type="text" class="form-control" name="file_url" placeholder="/patient-registration"
                                required>
                        </div>

                        <!-- Page Name -->
                        <div class="col-md-6">
                            <label class="form-label">Page Name</label>
                            <input type="text" class="form-control" name="page_name"
                                placeholder="modules.patient-registration" required>
                        </div>

                        <!-- Type -->
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-control" name="type" required>
                                <option>Web</option>
                                <option>App</option>
                                <option>Both</option>
                            </select>
                        </div>

                        <!-- Access For -->
                        <div class="col-md-6">
                            <label class="form-label">Access For</label>
                            <select class="form-control" name="access_for" required>
                                <option value="" selected disabled>Select</option>
                                <option value="institution">Institution</option>
                                <option value="service">Service</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
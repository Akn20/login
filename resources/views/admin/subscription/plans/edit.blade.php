@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">

                Edit Subscription Plan

            </h4>

            <p class="text-muted mb-0">

                Update pricing, modules and limits

            </p>

        </div>

        <a href="{{ route('admin.plans.index') }}"
           class="btn btn-light">

            <i class="feather-arrow-left"></i>

            Back

        </a>

    </div>

    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('admin.plans.update', $plan->id) }}"
          method="POST">

        @csrf

        @method('PUT')

        <div class="row">

            {{-- LEFT SIDE --}}
            <div class="col-lg-8">

                {{-- BASIC DETAILS --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Basic Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- PLAN NAME --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Plan Name

                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name', $plan->name) }}"
                                       required>

                            </div>

                            {{-- SLUG --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Slug

                                </label>

                                <input type="text"
                                       name="slug"
                                       class="form-control"
                                       value="{{ old('slug', $plan->slug) }}"
                                       required>

                            </div>

                            {{-- DESCRIPTION --}}
                            <div class="col-12 mb-3">

                                <label class="form-label">

                                    Description

                                </label>

                                <textarea name="description"
                                          rows="4"
                                          class="form-control">{{ old('description', $plan->description) }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- PRICING --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Pricing Configuration

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- MONTHLY --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Monthly Price

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="monthly_price"
                                       class="form-control"
                                       value="{{ old('monthly_price', $plan->monthly_price) }}"
                                       required>

                            </div>

                            {{-- YEARLY --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Yearly Price

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="yearly_price"
                                       class="form-control"
                                       value="{{ old('yearly_price', $plan->yearly_price) }}"
                                       required>

                            </div>

                            {{-- TRIAL --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Trial Days

                                </label>

                                <input type="number"
                                       name="trial_days"
                                       class="form-control"
                                       value="{{ old('trial_days', $plan->trial_days) }}">

                            </div>

                            {{-- GRACE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Grace Days

                                </label>

                                <input type="number"
                                       name="grace_days"
                                       class="form-control"
                                       value="{{ old('grace_days', $plan->grace_days) }}">

                            </div>

                        </div>

                    </div>

                </div>

                {{-- LIMITS --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Usage Limits

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- USERS --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Max Users

                                </label>

                                <input type="number"
                                       name="max_users"
                                       class="form-control"
                                       value="{{ old('max_users', $plan->limits->max_users ?? '') }}">

                            </div>

                            {{-- PATIENTS --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Max Patients

                                </label>

                                <input type="number"
                                       name="max_patients"
                                       class="form-control"
                                       value="{{ old('max_patients', $plan->limits->max_patients ?? '') }}">

                            </div>

                            {{-- HOSPITALS --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Max Hospitals

                                </label>

                                <input type="number"
                                       name="max_hospitals"
                                       class="form-control"
                                       value="{{ old('max_hospitals', $plan->limits->max_hospitals ?? '') }}">

                            </div>

                            {{-- STORAGE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Storage Limit (MB)

                                </label>

                                <input type="number"
                                       name="max_storage_mb"
                                       class="form-control"
                                       value="{{ old('max_storage_mb', $plan->limits->max_storage_mb ?? '') }}">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-4">

                {{-- MODULES --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Plan Modules

                        </h5>

                    </div>

                    <div class="card-body">

                        @php
                            $selectedModules = $plan->modules->pluck('id')->toArray();
                        @endphp

                        @forelse($modules as $module)

                            <div class="form-check mb-2">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="modules[]"
                                       value="{{ $module->id }}"
                                       id="module_{{ $module->id }}"

                                       {{ in_array($module->id, $selectedModules) ? 'checked' : '' }}>

                                <label class="form-check-label"
                                       for="module_{{ $module->id }}">

                                    {{ $module->module_display_name }}

                                </label>

                            </div>

                        @empty

                            <div class="text-muted">

                                No modules available

                            </div>

                        @endforelse

                    </div>

                </div>

                {{-- STATUS --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Status

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="form-check form-switch">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="status"
                                   value="1"

                                   {{ $plan->status ? 'checked' : '' }}>

                            <label class="form-check-label">

                                Active Plan

                            </label>

                        </div>

                    </div>

                </div>

                {{-- SUBMIT --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            <i class="feather-save"></i>

                            Update Plan

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
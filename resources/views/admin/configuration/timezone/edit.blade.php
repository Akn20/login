
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Edit Timezone
            </h4>

            <p class="text-muted mb-0">
                Update timezone configuration
            </p>

        </div>

        <a href="{{ route('admin.configuration.timezones.index') }}"
           class="btn btn-secondary">

            <i class="feather-arrow-left"></i>

            Back

        </a>

    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form action="{{ route('admin.configuration.timezones.update', $timezone->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- TIMEZONE NAME --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Timezone Name
                        </label>

                        <input type="text"
                               name="timezone_name"
                               class="form-control @error('timezone_name') is-invalid @enderror"
                               value="{{ old('timezone_name', $timezone->timezone_name) }}">

                        @error('timezone_name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- TIMEZONE CODE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Timezone Code
                        </label>

                        <input type="text"
                               name="timezone_code"
                               class="form-control @error('timezone_code') is-invalid @enderror"
                               value="{{ old('timezone_code', $timezone->timezone_code) }}">

                        @error('timezone_code')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- DATE FORMAT --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date Format
                        </label>

                        <select name="date_format"
                                class="form-select @error('date_format') is-invalid @enderror">

                            <option value="d-m-Y"
                                {{ $timezone->date_format == 'd-m-Y' ? 'selected' : '' }}>
                                d-m-Y (28-05-2026)
                            </option>

                            <option value="Y-m-d"
                                {{ $timezone->date_format == 'Y-m-d' ? 'selected' : '' }}>
                                Y-m-d (2026-05-28)
                            </option>

                            <option value="m/d/Y"
                                {{ $timezone->date_format == 'm/d/Y' ? 'selected' : '' }}>
                                m/d/Y (05/28/2026)
                            </option>

                        </select>

                        @error('date_format')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- TIME FORMAT --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Time Format
                        </label>

                        <select name="time_format"
                                class="form-select @error('time_format') is-invalid @enderror">

                            <option value="12 Hour"
                                {{ $timezone->time_format == '12 Hour' ? 'selected' : '' }}>
                                12 Hour
                            </option>

                            <option value="24 Hour"
                                {{ $timezone->time_format == '24 Hour' ? 'selected' : '' }}>
                                24 Hour
                            </option>

                        </select>

                        @error('time_format')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- DEFAULT --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label d-block">

                            Default Timezone

                        </label>

                        <div class="form-check form-switch">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_default"
                                   value="1"
                                   {{ $timezone->is_default ? 'checked' : '' }}>

                            <label class="form-check-label">

                                Set as default timezone

                            </label>

                        </div>

                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="text-end">

                    <a href="{{ route('admin.configuration.timezones.index') }}"
                       class="btn btn-light">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="feather-save"></i>

                        Update Timezone

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

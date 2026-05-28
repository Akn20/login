
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Create Timezone
            </h4>

            <p class="text-muted mb-0">
                Add new timezone configuration
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

            <form action="{{ route('admin.configuration.timezones.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    {{-- TIMEZONE NAME --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Timezone Name
                        </label>

                        <input type="text"
                               name="timezone_name"
                               class="form-control @error('timezone_name') is-invalid @enderror"
                               placeholder="Example: Asia/Kolkata"
                               value="{{ old('timezone_name') }}">

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
                               placeholder="Example: IST"
                               value="{{ old('timezone_code') }}">

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

                            <option value="d-m-Y">
                                d-m-Y (28-05-2026)
                            </option>

                            <option value="Y-m-d">
                                Y-m-d (2026-05-28)
                            </option>

                            <option value="m/d/Y">
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

                            <option value="12 Hour">
                                12 Hour
                            </option>

                            <option value="24 Hour">
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
                                   value="1">

                            <label class="form-check-label">

                                Set as default timezone

                            </label>

                        </div>

                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="text-end">

                    <button type="reset"
                            class="btn btn-light">

                        Reset

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="feather-save"></i>

                        Save Timezone

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

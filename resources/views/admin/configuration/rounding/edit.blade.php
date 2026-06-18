
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Edit Rounding Rule
            </h4>

            <p class="text-muted mb-0">
                Update financial rounding configuration
            </p>

        </div>

        <a href="{{ route('admin.configuration.rounding-rules.index') }}"
           class="btn btn-secondary">

            <i class="feather-arrow-left"></i>

            Back

        </a>

    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form action="{{ route('admin.configuration.rounding-rules.update', $rule->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- MODULE NAME --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Module Name
                        </label>

                        <input type="text"
                               name="module_name"
                               class="form-control @error('module_name') is-invalid @enderror"
                               value="{{ old('module_name', $rule->module_name) }}">

                        @error('module_name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- ROUNDING TYPE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Rounding Type
                        </label>

                        <select name="rounding_type"
                                class="form-select @error('rounding_type') is-invalid @enderror">

                            <option value="Round Up"
                                {{ $rule->rounding_type == 'Round Up' ? 'selected' : '' }}>
                                Round Up
                            </option>

                            <option value="Round Down"
                                {{ $rule->rounding_type == 'Round Down' ? 'selected' : '' }}>
                                Round Down
                            </option>

                            <option value="Round Half Up"
                                {{ $rule->rounding_type == 'Round Half Up' ? 'selected' : '' }}>
                                Round Half Up
                            </option>

                            <option value="Nearest Decimal"
                                {{ $rule->rounding_type == 'Nearest Decimal' ? 'selected' : '' }}>
                                Nearest Decimal
                            </option>

                        </select>

                        @error('rounding_type')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- DECIMAL PLACES --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Decimal Places
                        </label>

                        <input type="number"
                               name="decimal_places"
                               class="form-control @error('decimal_places') is-invalid @enderror"
                               value="{{ old('decimal_places', $rule->decimal_places) }}">

                        @error('decimal_places')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label d-block">

                            Status

                        </label>

                        <div class="form-check form-switch">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ $rule->is_active ? 'checked' : '' }}>

                            <label class="form-check-label">

                                Active

                            </label>

                        </div>

                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="text-end">

                    <a href="{{ route('admin.configuration.rounding-rules.index') }}"
                       class="btn btn-light">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="feather-save"></i>

                        Update Rule

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


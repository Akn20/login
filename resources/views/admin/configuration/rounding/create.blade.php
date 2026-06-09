
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Create Rounding Rule
            </h4>

            <p class="text-muted mb-0">
                Add new financial rounding configuration
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

            <form action="{{ route('admin.configuration.rounding-rules.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    {{-- MODULE NAME --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Module Name
                        </label>

                        <input type="text"
                               name="module_name"
                               class="form-control @error('module_name') is-invalid @enderror"
                               placeholder="Example: Billing"
                               value="{{ old('module_name') }}">

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

                            <option value="">
                                Select Rounding Type
                            </option>

                            <option value="Round Up">
                                Round Up
                            </option>

                            <option value="Round Down">
                                Round Down
                            </option>

                            <option value="Round Half Up">
                                Round Half Up
                            </option>

                            <option value="Nearest Decimal">
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
                               value="{{ old('decimal_places', 2) }}">

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
                                   checked>

                            <label class="form-check-label">

                                Active

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

                        Save Rule

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


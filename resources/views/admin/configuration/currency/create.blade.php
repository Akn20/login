
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Create Currency
            </h4>

            <p class="text-muted mb-0">
                Add new system currency
            </p>

        </div>

        <a href="{{ route('admin.configuration.currencies.index') }}"
           class="btn btn-secondary">

            <i class="feather-arrow-left"></i>

            Back

        </a>

    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form action="{{ route('admin.configuration.currencies.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    {{-- CURRENCY NAME --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Currency Name
                        </label>

                        <input type="text"
                               name="currency_name"
                               class="form-control @error('currency_name') is-invalid @enderror"
                               placeholder="Example: Indian Rupee"
                               value="{{ old('currency_name') }}">

                        @error('currency_name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- CURRENCY CODE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Currency Code
                        </label>

                        <input type="text"
                               name="currency_code"
                               class="form-control @error('currency_code') is-invalid @enderror"
                               placeholder="Example: INR"
                               value="{{ old('currency_code') }}">

                        @error('currency_code')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- SYMBOL --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Currency Symbol
                        </label>

                        <input type="text"
                               name="currency_symbol"
                               class="form-control @error('currency_symbol') is-invalid @enderror"
                               placeholder="Example: ₹"
                               value="{{ old('currency_symbol') }}">

                        @error('currency_symbol')

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

                    {{-- DEFAULT CURRENCY --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label d-block">

                            Default Currency

                        </label>

                        <div class="form-check form-switch">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_default"
                                   value="1">

                            <label class="form-check-label">

                                Set as default currency

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

                        Save Currency

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


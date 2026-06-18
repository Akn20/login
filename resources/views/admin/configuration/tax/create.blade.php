
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">Create Tax Structure</h4>
            <p class="text-muted mb-0">
                Add new tax configuration for billing and invoices
            </p>
        </div>

        <a href="{{ route('admin.configuration.taxes.index') }}"
           class="btn btn-secondary">

            <i class="feather-arrow-left"></i> Back

        </a>

    </div>

    {{-- CARD --}}
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form action="{{ route('admin.configuration.taxes.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    {{-- TAX NAME --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Tax Name
                        </label>

                        <input type="text"
                               name="tax_name"
                               class="form-control @error('tax_name') is-invalid @enderror"
                               placeholder="Enter Tax Name"
                               value="{{ old('tax_name') }}">

                        @error('tax_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- TAX PERCENTAGE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Tax Percentage (%)
                        </label>

                        <input type="number"
                               step="0.01"
                               name="tax_percentage"
                               class="form-control @error('tax_percentage') is-invalid @enderror"
                               placeholder="Enter Tax Percentage"
                               value="{{ old('tax_percentage') }}">

                        @error('tax_percentage')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- TAX TYPE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Tax Type
                        </label>

                        <select name="tax_type"
                                class="form-select @error('tax_type') is-invalid @enderror">

                            <option value="">
                                Select Tax Type
                            </option>

                            <option value="GST">GST</option>
                            <option value="CGST">CGST</option>
                            <option value="SGST">SGST</option>
                            <option value="IGST">IGST</option>
                            <option value="VAT">VAT</option>

                        </select>

                        @error('tax_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- CALCULATION TYPE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Calculation Type
                        </label>

                        <select name="calculation_type"
                                class="form-select @error('calculation_type') is-invalid @enderror">

                            <option value="">
                                Select Calculation Type
                            </option>

                            <option value="Inclusive">
                                Inclusive
                            </option>

                            <option value="Exclusive">
                                Exclusive
                            </option>

                        </select>

                        @error('calculation_type')
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
                        Save Tax

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


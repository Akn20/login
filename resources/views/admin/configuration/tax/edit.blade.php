
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">Edit Tax Structure</h4>
            <p class="text-muted mb-0">
                Update tax configuration
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

            <form action="{{ route('admin.configuration.taxes.update', $tax->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- TAX NAME --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Tax Name
                        </label>

                        <input type="text"
                               name="tax_name"
                               class="form-control @error('tax_name') is-invalid @enderror"
                               value="{{ old('tax_name', $tax->tax_name) }}">

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
                               value="{{ old('tax_percentage', $tax->tax_percentage) }}">

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

                            <option value="GST"
                                {{ $tax->tax_type == 'GST' ? 'selected' : '' }}>
                                GST
                            </option>

                            <option value="CGST"
                                {{ $tax->tax_type == 'CGST' ? 'selected' : '' }}>
                                CGST
                            </option>

                            <option value="SGST"
                                {{ $tax->tax_type == 'SGST' ? 'selected' : '' }}>
                                SGST
                            </option>

                            <option value="IGST"
                                {{ $tax->tax_type == 'IGST' ? 'selected' : '' }}>
                                IGST
                            </option>

                            <option value="VAT"
                                {{ $tax->tax_type == 'VAT' ? 'selected' : '' }}>
                                VAT
                            </option>

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

                            <option value="Inclusive"
                                {{ $tax->calculation_type == 'Inclusive' ? 'selected' : '' }}>
                                Inclusive
                            </option>

                            <option value="Exclusive"
                                {{ $tax->calculation_type == 'Exclusive' ? 'selected' : '' }}>
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
                                   {{ $tax->is_active ? 'checked' : '' }}>

                            <label class="form-check-label">
                                Active
                            </label>

                        </div>

                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="text-end">

                    <a href="{{ route('admin.configuration.taxes.index') }}"
                       class="btn btn-light">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="feather-save"></i>
                        Update Tax

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


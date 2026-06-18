@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="card">

        <div class="card-header">
            <h4>Edit Local Tax Setting</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('local-tax-settings.update',$tax->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Tax Name</label>
                    <input type="text"
                           name="tax_name"
                           class="form-control"
                           value="{{ $tax->tax_name }}">
                </div>

                <div class="mb-3">
                    <label>Tax Percentage (%)</label>
                    <input type="number"
                           step="0.01"
                           name="tax_percentage"
                           class="form-control"
                           value="{{ $tax->tax_percentage }}">
                </div>

                <div class="mb-3">

                    <label>Tax Type</label>

                    <select name="tax_type"
                            class="form-control">

                        <option value="Inclusive"
                        {{ $tax->tax_type == 'Inclusive' ? 'selected' : '' }}>
                            Inclusive
                        </option>

                        <option value="Exclusive"
                        {{ $tax->tax_type == 'Exclusive' ? 'selected' : '' }}>
                            Exclusive
                        </option>

                    </select>

                </div>

                <div class="mb-3">
                    <label>Applicable On</label>

                    <input type="text"
                           name="applicable_on"
                           class="form-control"
                           value="{{ $tax->applicable_on }}">
                </div>

                <div class="mb-3">

                    <label>Status</label>

                    <select name="status"
                            class="form-control">

                        <option value="Active"
                        {{ $tax->status == 'Active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="Inactive"
                        {{ $tax->status == 'Inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                <div class="mt-3 d-flex gap-2">

    <button type="submit"
            class="btn btn-primary"
            style="width:auto !important;">
        Update
    </button>

    <a href="{{ route('local-tax-settings.index') }}"
       class="btn btn-danger"
       style="width:auto !important;">
        Cancel
    </a>

</div>

            </form>

        </div>

    </div>

</div>

@endsection
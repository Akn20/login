@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="card">

        <div class="card-header">
            <h4>Add Local Tax Setting</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('local-tax-settings.store') }}"
                  method="POST">

                @csrf

                <div class="mb-3">
                    <label>Tax Name</label>
                    <input type="text"
                           name="tax_name"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Tax Percentage (%)</label>
                    <input type="number"
                           step="0.01"
                           name="tax_percentage"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Tax Type</label>

                    <select name="tax_type"
                            class="form-control"
                            required>

                        <option value="">Select</option>
                        <option value="Inclusive">Inclusive</option>
                        <option value="Exclusive">Exclusive</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label>Applicable On</label>

                    <select name="applicable_on"
                            class="form-control"
                            required>

                        <option value="">Select</option>
                        <option value="Consultation">Consultation</option>
                        <option value="Laboratory">Laboratory</option>
                        <option value="Pharmacy">Pharmacy</option>
                        <option value="Radiology">Radiology</option>
                        <option value="Room Charges">Room Charges</option>
                        <option value="Surgery">Surgery</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label>Status</label>

                    <select name="status"
                            class="form-control">

                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>

                    </select>
                </div>

                <button type="submit"
                        class="btn btn-primary">
                    Save
                </button>

            </form>

        </div>

    </div>

</div>

@endsection
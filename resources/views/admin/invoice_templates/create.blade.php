@extends('layouts.admin')

@section('content')

<div class="main-content">

<div class="card">

<div class="card-header">
    <h4>Add Invoice Template</h4>
</div>

<div class="card-body">

<form action="{{ route('invoice-templates.store') }}"
      method="POST">

    @csrf

    <div class="mb-3">
        <label>Template Name</label>
        <input type="text"
               name="template_name"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Invoice Prefix</label>
        <input type="text"
               name="invoice_prefix"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Starting Number</label>
        <input type="number"
               name="starting_number"
               value="1"
               class="form-control">
    </div>

    <div class="form-check mb-2">
        <input type="checkbox"
               class="form-check-input"
               name="show_logo"
               checked>
        <label class="form-check-label">Show Logo</label>
    </div>

    <div class="form-check mb-2">
        <input type="checkbox"
               class="form-check-input"
               name="show_address"
               checked>
        <label class="form-check-label">Show Address</label>
    </div>

    <div class="form-check mb-2">
        <input type="checkbox"
               class="form-check-input"
               name="show_phone"
               checked>
        <label class="form-check-label">Show Phone</label>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox"
               class="form-check-input"
               name="show_gst">

        <label class="form-check-label">
            Show GST
        </label>
    </div>

    <div class="mb-3">
        <label>Terms & Conditions</label>

        <textarea name="terms_conditions"
                  class="form-control"></textarea>
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
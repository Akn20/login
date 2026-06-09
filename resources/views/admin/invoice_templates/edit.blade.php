@extends('layouts.admin')

@section('content')

<div class="main-content">

<div class="card">

<div class="card-header">
    <h4>Edit Invoice Template</h4>
</div>

<div class="card-body">

<form action="{{ route('invoice-templates.update',$template->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Template Name</label>

        <input type="text"
               name="template_name"
               class="form-control"
               value="{{ $template->template_name }}">
    </div>

    <div class="mb-3">
        <label>Invoice Prefix</label>

        <input type="text"
               name="invoice_prefix"
               class="form-control"
               value="{{ $template->invoice_prefix }}">
    </div>

    <div class="mb-3">
        <label>Starting Number</label>

        <input type="number"
               name="starting_number"
               class="form-control"
               value="{{ $template->starting_number }}">
    </div>

    <div class="form-check mb-2">
        <input type="checkbox"
               class="form-check-input"
               name="show_logo"
               {{ $template->show_logo ? 'checked' : '' }}>
        <label class="form-check-label">Show Logo</label>
    </div>

    <div class="form-check mb-2">
        <input type="checkbox"
               class="form-check-input"
               name="show_address"
               {{ $template->show_address ? 'checked' : '' }}>
        <label class="form-check-label">Show Address</label>
    </div>

    <div class="form-check mb-2">
        <input type="checkbox"
               class="form-check-input"
               name="show_phone"
               {{ $template->show_phone ? 'checked' : '' }}>
        <label class="form-check-label">Show Phone</label>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox"
               class="form-check-input"
               name="show_gst"
               {{ $template->show_gst ? 'checked' : '' }}>
        <label class="form-check-label">Show GST</label>
    </div>

    <div class="mb-3">

        <label>Terms & Conditions</label>

        <textarea name="terms_conditions"
                  class="form-control">{{ $template->terms_conditions }}</textarea>

    </div>

    <div class="mb-3">

        <label>Status</label>

        <select name="status"
                class="form-control">

            <option value="Active" {{ $template->status=='Active' ? 'selected' : '' }}>
                Active
            </option>

            <option value="Inactive" {{ $template->status=='Inactive' ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

    </div>

  <div class="mt-3 d-flex gap-2">

    <button type="submit"
            class="btn btn-primary btn-sm">
        Update
    </button>

    <a href="{{ route('invoice-templates.index') }}"
       class="btn btn-danger btn-sm">
        Cancel
    </a>

</div>

</form>

</div>

</div>

</div>

@endsection
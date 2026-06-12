@extends('layouts.admin')

@section('content')

<div class="main-content">

<div class="card">

<div class="card-header">
    <h4>Edit Print Format Setting</h4>
</div>

<div class="card-body">

<form action="{{ route('print-format-settings.update',$format->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Hospital Name</label>
        <input type="text"
               name="hospital_name"
               class="form-control"
               value="{{ $format->hospital_name }}">
    </div>

    <div class="mb-3">
        <label>Hospital Logo</label>
        <input type="file"
       name="hospital_logo"
       class="form-control">

@if($format->hospital_logo)

    <div class="mt-2">

        <a href="{{ asset('storage/'.$format->hospital_logo) }}"
           target="_blank"
           class="btn btn-sm btn-info">

            View Current File

        </a>

    </div>

@endif
    </div>

    <div class="mb-3">
        <label>Address</label>
        <textarea name="address"
                  class="form-control">{{ $format->address }}</textarea>
    </div>

    <div class="mb-3">
        <label>Phone Number</label>
        <input type="text"
               name="phone_number"
               class="form-control"
               value="{{ $format->phone_number }}">
    </div>

    <div class="mb-3">
        <label>Footer Text</label>
        <textarea name="footer_text"
                  class="form-control">{{ $format->footer_text }}</textarea>
    </div>

    <div class="mb-3">
        <label>Disclaimer</label>
        <textarea name="disclaimer"
                  class="form-control">{{ $format->disclaimer }}</textarea>
    </div>

    <div class="mb-3">
        <label>Signature Area</label>
        <input type="text"
               name="signature_area"
               class="form-control"
               value="{{ $format->signature_area }}">
    </div>

    <div class="mb-3">

        <label>Paper Size</label>

        <select name="paper_size"
                class="form-control">

            <option value="A4" {{ $format->paper_size=='A4' ? 'selected' : '' }}>A4</option>
            <option value="A5" {{ $format->paper_size=='A5' ? 'selected' : '' }}>A5</option>
            <option value="Letter" {{ $format->paper_size=='Letter' ? 'selected' : '' }}>Letter</option>

        </select>

    </div>

    <div class="mb-3">

        <label>Orientation</label>

        <select name="orientation"
                class="form-control">

            <option value="Portrait" {{ $format->orientation=='Portrait' ? 'selected' : '' }}>Portrait</option>
            <option value="Landscape" {{ $format->orientation=='Landscape' ? 'selected' : '' }}>Landscape</option>

        </select>

    </div>

   <div class="mb-3">
    <label>Margins (mm)</label>
    <input type="number"
           name="margins"
           class="form-control"
           min="0"
           value="{{ $format->margins }}">
</div>

    <div class="mb-3">

        <label>Status</label>

        <select name="status"
                class="form-control">

            <option value="Active" {{ $format->status=='Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ $format->status=='Inactive' ? 'selected' : '' }}>Inactive</option>

        </select>

    </div>

    <div class="mt-3 d-flex gap-2">

        <button type="submit"
                class="btn btn-primary"
                style="width:auto !important;">
            Update
        </button>

        <a href="{{ route('print-format-settings.index') }}"
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
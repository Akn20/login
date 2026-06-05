@extends('layouts.admin')

@section('content')

<div class="main-content">

<div class="card">

<div class="card-header">
    <h4>Add Prescription Format</h4>
</div>

<div class="card-body">

<form action="{{ route('prescription-format-settings.store') }}"
      method="POST">

    @csrf

    <div class="mb-3">
        <label>Header Text</label>
        <textarea name="header_text"
                  class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Footer Text</label>
        <textarea name="footer_text"
                  class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Paper Size</label>

        <select name="paper_size"
                class="form-control">

            <option value="A4">A4</option>
            <option value="A5">A5</option>
            <option value="Letter">Letter</option>

        </select>
    </div>

    <div class="mb-3">
        <label>Orientation</label>

        <select name="orientation"
                class="form-control">

            <option value="Portrait">Portrait</option>
            <option value="Landscape">Landscape</option>

        </select>
    </div>

    <div class="mb-3">
        <label>Margins</label>

        <input type="number"
               name="margins"
               class="form-control"
               value="10">
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
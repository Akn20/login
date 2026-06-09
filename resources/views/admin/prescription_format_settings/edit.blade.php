@extends('layouts.admin')

@section('content')

<div class="main-content">

<div class="card">

<div class="card-header">
    <h4>Edit Prescription Format Setting</h4>
</div>

<div class="card-body">

<form action="{{ route('prescription-format-settings.update',$format->id) }}"
      method="POST">

```
@csrf
@method('PUT')

<div class="mb-3">
    <label>Header Text</label>

    <textarea name="header_text"
              class="form-control">{{ $format->header_text }}</textarea>
</div>

<div class="mb-3">
    <label>Footer Text</label>

    <textarea name="footer_text"
              class="form-control">{{ $format->footer_text }}</textarea>
</div>

<div class="form-check mb-2">

    <input type="checkbox"
           class="form-check-input"
           name="show_doctor_name"
           {{ $format->show_doctor_name ? 'checked' : '' }}>

    <label class="form-check-label">
        Show Doctor Name
    </label>

</div>

<div class="form-check mb-2">

    <input type="checkbox"
           class="form-check-input"
           name="show_doctor_qualification"
           {{ $format->show_doctor_qualification ? 'checked' : '' }}>

    <label class="form-check-label">
        Show Doctor Qualification
    </label>

</div>

<div class="form-check mb-2">

    <input type="checkbox"
           class="form-check-input"
           name="show_registration_number"
           {{ $format->show_registration_number ? 'checked' : '' }}>

    <label class="form-check-label">
        Show Registration Number
    </label>

</div>

<div class="form-check mb-2">

    <input type="checkbox"
           class="form-check-input"
           name="show_patient_age"
           {{ $format->show_patient_age ? 'checked' : '' }}>

    <label class="form-check-label">
        Show Patient Age
    </label>

</div>

<div class="form-check mb-2">

    <input type="checkbox"
           class="form-check-input"
           name="show_patient_gender"
           {{ $format->show_patient_gender ? 'checked' : '' }}>

    <label class="form-check-label">
        Show Patient Gender
    </label>

</div>

<div class="form-check mb-3">

    <input type="checkbox"
           class="form-check-input"
           name="show_date"
           {{ $format->show_date ? 'checked' : '' }}>

    <label class="form-check-label">
        Show Prescription Date
    </label>

</div>

<div class="mb-3">

    <label>Paper Size</label>

    <select name="paper_size"
            class="form-control">

        <option value="A4"
        {{ $format->paper_size == 'A4' ? 'selected' : '' }}>
            A4
        </option>

        <option value="A5"
        {{ $format->paper_size == 'A5' ? 'selected' : '' }}>
            A5
        </option>

        <option value="Letter"
        {{ $format->paper_size == 'Letter' ? 'selected' : '' }}>
            Letter
        </option>

    </select>

</div>

<div class="mb-3">

    <label>Orientation</label>

    <select name="orientation"
            class="form-control">

        <option value="Portrait"
        {{ $format->orientation == 'Portrait' ? 'selected' : '' }}>
            Portrait
        </option>

        <option value="Landscape"
        {{ $format->orientation == 'Landscape' ? 'selected' : '' }}>
            Landscape
        </option>

    </select>

</div>

<div class="mb-3">

    <label>Margins</label>

    <input type="number"
           name="margins"
           class="form-control"
           value="{{ $format->margins }}">

</div>

<div class="mb-3">

    <label>Status</label>

    <select name="status"
            class="form-control">

        <option value="Active"
        {{ $format->status == 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive"
        {{ $format->status == 'Inactive' ? 'selected' : '' }}>
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

    <a href="{{ route('prescription-format-settings.index') }}"
       class="btn btn-danger"
       style="width:auto !important;">
        Cancel
    </a>

</div>
```

</form>

</div>

</div>

</div>

@endsection

@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="card">

        <div class="card-header">
            <h4>Add Print Format Setting</h4>
        </div>

        <div class="card-body">

           <form action="{{ route('print-format-settings.store') }}"
      method="POST"
      enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label>Hospital Name</label>
                    <input type="text"
                           name="hospital_name"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Hospital Logo</label>
                    <input type="file"
       name="hospital_logo"
       class="form-control"
       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address"
                              class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="text"
                           name="phone_number"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Footer Text</label>
                    <textarea name="footer_text"
                              class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Disclaimer</label>
                    <textarea name="disclaimer"
                              class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Signature Area</label>
                    <input type="text"
                           name="signature_area"
                           class="form-control">
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
    <label>Margins (mm)</label>
    <input type="number"
           name="margins"
           class="form-control"
           min="0"
           placeholder="10">
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
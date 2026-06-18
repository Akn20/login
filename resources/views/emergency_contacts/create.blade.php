@extends('layouts.admin')

@section('content')

<div class="card">

<div class="card-header">
    <h4>Add Emergency Contact</h4>
</div>

<div class="card-body">

    <form action="{{ route('emergency-contacts.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Contact Type</label>
            <input type="text"
                   name="contact_type"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Contact Name</label>
            <input type="text"
                   name="contact_name"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Mobile Number</label>
            <input type="text"
                   name="mobile_no"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Alternate Number</label>
            <input type="text"
                   name="alternate_no"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address"
                      class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>

            <select name="status"
                    class="form-control">

                <option value="Active">
                    Active
                </option>

                <option value="Inactive">
                    Inactive
                </option>

            </select>
        </div>

        <button type="submit"
                class="btn btn-primary">

            Save

        </button>

    </form>

</div>
```

</div>

@endsection

@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="card">

        <div class="card-header">
            <h4>Edit Emergency Contact</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('emergency-contacts.update', $contact->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Contact Type</label>
                    <input type="text"
                           name="contact_type"
                           class="form-control"
                           value="{{ $contact->contact_type }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Name</label>
                    <input type="text"
                           name="contact_name"
                           class="form-control"
                           value="{{ $contact->contact_name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mobile Number</label>
                    <input type="text"
                           name="mobile_no"
                           class="form-control"
                           value="{{ $contact->mobile_no }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alternate Number</label>
                    <input type="text"
                           name="alternate_no"
                           class="form-control"
                           value="{{ $contact->alternate_no }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ $contact->email }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address"
                              class="form-control"
                              rows="3">{{ $contact->address }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-control">

                        <option value="Active"
                            {{ $contact->status == 'Active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="Inactive"
                            {{ $contact->status == 'Inactive' ? 'selected' : '' }}>
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

    <a href="{{ route('emergency-contacts.index') }}"
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
@extends('layouts.admin')

@section('content')
    <div class="container">

        <h3 class="mb-3">Edit Religion</h3>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.religion.update', $religion->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Religion Name</label>
                        <input type="text" name="religion_name" class="form-control" value="{{ $religion->religion_name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="Active" {{ $religion->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $religion->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                        <a href="{{ route('admin.religion.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>


                </form>

            </div>
        </div>

    </div>
@endsection
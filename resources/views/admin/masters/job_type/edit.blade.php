@extends('layouts.admin')

@section('content')
 <div class="container">

    <h3 class="mb-3">Edit Job Type</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.job-type.update', $jobType->id) }}" method="POST">
                @csrf

                <div class="mb-3">
    <label class="form-label">Job Type Code</label>
    <input type="text" name="job_type_code" class="form-control"
        value="{{ $jobType->job_type_code }}">
</div>

<div class="mb-3">
    <label class="form-label">Job Type Name</label>
    <input type="text" name="job_type_name" class="form-control"
        value="{{ $jobType->job_type_name }}">
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ $jobType->description }}</textarea>
</div>


                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="Active"
                            {{ $jobType->status == 'Active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="Inactive"
                            {{ $jobType->status == 'Inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('admin.job-type.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
 @endsection

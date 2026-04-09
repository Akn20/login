@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <h5>Edit Scan Type</h5>

    <form action="{{ route('admin.radiology.scan-types.update', $scanType->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $scanType->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $scanType->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Active" {{ $scanType->status=='Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ $scanType->status=='Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>

</div>

@endsection
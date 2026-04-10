@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <h5>Add Scan Type</h5>

    <form action="{{ route('admin.radiology.scan-types.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>

        <button class="btn btn-success">Save</button>
    </form>

</div>

@endsection
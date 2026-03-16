@extends('layouts.admin')

@section('content')

<div class="container">
    <h3>Add Lab Test</h3>

   {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <form action="{{ route('admin.laboratory.tests.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Test Name</label>
            <input type="text" name="test_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Test Code</label>
            <input type="text" name="test_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Test Category</label>
            <input type="text" name="test_category" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Sample Type</label>
            <select name="sample_type" class="form-control">
                <option value="">Select Sample</option>
                <option value="Blood">Blood</option>
                <option value="Urine">Urine</option>
                <option value="Saliva">Saliva</option>
                <option value="Stool">Stool</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Turnaround Time</label>
            <input type="text" name="turnaround_time" class="form-control" placeholder="e.g. 2 hours">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Save Lab Test
        </button>

    </form>
</div>

@endsection
@extends('layouts.admin')

@section('content')

    <div class="container">

        <h4>Add Parameter</h4>

        <form method="POST" action="{{ route('admin.laboratory.parameters.store') }}">
            @csrf

            <div class="mb-2">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-2">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control">
            </div>

            <div class="mb-2">
                <label>Min Value</label>
                <input type="number" step="0.01" name="min_value" class="form-control">
            </div>

            <div class="mb-2">
                <label>Max Value</label>
                <input type="number" step="0.01" name="max_value" class="form-control">
            </div>

            <button class="btn btn-success">Save</button>

        </form>

    </div>

@endsection
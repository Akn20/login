@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Add Lab Test</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Laboratory</li>
                <li class="breadcrumb-item">Lab Tests</li>
                <li class="breadcrumb-item">Add</li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">

                <div class="card stretch stretch-full">
                    <div class="card-body">
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

                                    <input type="text"
                                        name="test_name"
                                        class="form-control @error('test_name') is-invalid @enderror"
                                        value="{{ old('test_name') }}"
                                        required>

                                    @error('test_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Test Code</label>

                                    <input type="text"
                                        name="test_code"
                                        class="form-control @error('test_code') is-invalid @enderror"
                                        value="{{ old('test_code') }}"
                                        required>

                                    @error('test_code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Add New Medicine</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Stock</li>
                <li class="breadcrumb-item">Create</li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card stretch stretch-full">
                    <div class="card-body">

                        <!-- Success / Error -->
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.stock.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <!-- Medicine Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Medicine Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           name="medicine_name"
                                           value="{{ old('medicine_name') }}"
                                           class="form-control"
                                           required>
                                    @error('medicine_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Generic Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Generic Name</label>
                                    <input type="text"
                                           name="generic_name"
                                           value="{{ old('generic_name') }}"
                                           class="form-control">
                                </div>

                                <!-- Category -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <input type="text"
                                           name="category"
                                           value="{{ old('category') }}"
                                           class="form-control">
                                </div>

                                <!-- Manufacturer -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Manufacturer</label>
                                    <input type="text"
                                           name="manufacturer"
                                           value="{{ old('manufacturer') }}"
                                           class="form-control">
                                </div>

                                <hr class="my-4">

                                <!-- Batch Number -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Batch Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           name="batch_number"
                                           value="{{ old('batch_number') }}"
                                           class="form-control"
                                           required>
                                    @error('batch_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Expiry Date -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Expiry Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                           name="expiry_date"
                                           value="{{ old('expiry_date') }}"
                                           class="form-control"
                                           required>
                                    @error('expiry_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Purchase Price -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Purchase Price</label>
                                    <input type="number"
                                           step="0.01"
                                           name="purchase_price"
                                           value="{{ old('purchase_price') }}"
                                           class="form-control">
                                </div>

                                <!-- MRP -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">MRP</label>
                                    <input type="number"
                                           step="0.01"
                                           name="mrp"
                                           value="{{ old('mrp') }}"
                                           class="form-control">
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Opening Quantity <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           name="quantity"
                                           value="{{ old('quantity') }}"
                                           class="form-control"
                                           required>
                                    @error('quantity')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Reorder Level -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Reorder Level</label>
                                    <input type="number"
                                           name="reorder_level"
                                           value="{{ old('reorder_level') }}"
                                           class="form-control">
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Save Medicine
                                </button>

                                <a href="{{ route('admin.stock.index') }}" class="btn btn-light">
                                    Cancel
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
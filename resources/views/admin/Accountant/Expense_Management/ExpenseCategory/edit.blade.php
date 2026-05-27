@extends('layouts.admin')

@section('page-title', 'Edit Expense Category | ' . config('app.name'))
@section('title', 'Edit Expense Category')

@section('content')

<div class="container-fluid">

    {{-- ================= HEADER ================= --}}
    <div class="page-header mb-4">
        <div>
            <h5 class="mb-1">
                <i class="feather-edit me-2"></i>Edit Expense Category
            </h5>

            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">Expense Management</li>
                <li class="breadcrumb-item">Expense Category</li>
                <li class="breadcrumb-item active">Edit</li>
            </ul>
        </div>
    </div>

    {{-- ================= FORM CARD ================= --}}
    <div class="card">
        <div class="card-body py-4" style="min-height: 180px;">

            <form method="POST" action="{{ route('admin.accountant.expense.category.update', $category->id) }}">
                @csrf
                @method('PUT')

                <div class="row mb-4">

                    <div class="col-md-6">
                        <label class="form-label">
                            Category Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="category_name"
                               class="form-control @error('category_name') is-invalid @enderror"
                               value="{{ old('category_name', $category->category_name) }}"
                               placeholder="Enter category name">

                        @error('category_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                {{-- ================= BUTTONS ================= --}}
                <div class="d-flex justify-content-end mt-4">

                    <a href="{{ route('admin.accountant.expense.category.index') }}"
                       class="btn btn-light me-2 px-4 py-2">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary px-4 py-2">
                        Update Category
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Add Expense Category')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5 class="mb-1">Add Expense Category</h5>

    <a href="{{ route('admin.accountant.expense.category.index') }}" class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORM START --}}
        <form action="{{ route('admin.accountant.expense.category.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Category Name <span class="text-danger">*</span></label>

                <input type="text"
                       name="category_name"
                       class="form-control @error('category_name') is-invalid @enderror"
                       placeholder="Enter category name"
                       value="{{ old('category_name') }}">

                {{-- ERROR --}}
                @error('category_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    Save Category
                </button>
            </div>

        </form>
        {{-- FORM END --}}

    </div>
</div>

@endsection
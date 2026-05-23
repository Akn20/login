@extends('layouts.admin')

@section('page-title', 'Expense Category Management')

@section('content')

{{-- SUCCESS --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ================= HEADER ================= --}}
<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>
        <h5 class="m-0 mb-1">
            <i class="feather-folder me-2"></i>Expense Category Management
        </h5>

        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">Accounts</li>
            <li class="breadcrumb-item active">Expense Category</li>
        </ul>
    </div>

    <div class="d-flex gap-2 align-items-center">

        {{-- Deleted Button --}}
        <a href="{{ route('admin.accountant.expense.category.deleted') }}"
           class="btn btn-danger">
            Deleted Categories
        </a>

        {{-- Add --}}
        <a href="{{ route('admin.accountant.expense.category.create') }}"
           class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Category
        </a>

    </div>
</div>

{{-- ================= CARD ================= --}}
<div class="card stretch stretch-full">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($categories as $index => $category)

                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>{{ $category->category_name }}</td>

                        <td class="text-end">

                            <div class="d-flex justify-content-end gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('admin.accountant.expense.category.edit', $category->id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle">
                                    <i class="feather-edit"></i>
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('admin.accountant.expense.category.delete', $category->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this category?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-danger btn-icon rounded-circle">
                                        <i class="feather-trash"></i>
                                    </button>
                                </form>

                            </div>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            No Categories Found
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
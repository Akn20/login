@extends('layouts.admin')

@section('page-title', 'Deleted Expense Categories')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5 class="mb-1">Deleted Expense Categories</h5>

    <a href="{{ route('admin.accountant.expense.category.index') }}" class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($deleted as $category)
                    <tr>
                        <td>{{ $category->category_name }}</td>

                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">

                                {{-- RESTORE --}}
                                <form action="{{ route('admin.accountant.expense.category.restore', $category->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-success btn-sm"
                                            title="Restore">
                                        <i class="feather-rotate-ccw"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-muted">
                            No deleted records
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
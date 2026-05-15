@extends('layouts.admin')

@section('page-title', 'Deleted Expenses | ' . config('app.name'))

@section('content')

{{-- SUCCESS MESSAGE --}}
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>
    </div>

@endif

{{-- VALIDATION ERRORS --}}
@if ($errors->any())

    <div class="alert alert-danger alert-dismissible fade show">

        <ul class="mb-0">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif

<div class="nxl-content">

    {{-- Page Header --}}
    <div class="page-header">

        <div class="page-header-left d-flex align-items-center">

            <div class="page-header-title">
                <h5>Deleted Expenses</h5>
            </div>

        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.accountant.expense.add.index') }}"
                class="btn btn-light">

                <i class="feather-arrow-left me-1"></i> Back

            </a>

        </div>

    </div>

    {{-- Main Content --}}
    <div class="main-content">

        <div class="card">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Entry Date</th>
                                <th>Category</th>
                                <th>Vendor</th>
                                <th>Grand Total</th>
                                <th>Payment Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($deletedExpenses as $key => $expense)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($expense->entry_date)->format('d-m-Y') }}
                                    </td>

                                    <td>
                                        {{ $expense->category->category_name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $expense->vendor->vendor_name ?? '-' }}
                                    </td>

                                    <td>
                                        ₹{{ number_format($expense->grand_total, 2) }}
                                    </td>

                                    <td>

                                        <span class="badge bg-soft-danger text-danger">
                                            Deleted
                                        </span>

                                    </td>

                                    <td class="text-end">

                                        <div class="hstack gap-2 justify-content-end">

                                            {{-- Restore --}}
                                            <form action="{{ route('admin.accountant.expense.add.restore', $expense->id) }}"
                                                method="POST">

                                                @csrf

                                                <button type="submit"
                                                    class="avatar-text avatar-md border-0 bg-transparent">

                                                    <i class="feather-refresh-ccw"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-4">
                                        No Deleted Expenses Found
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
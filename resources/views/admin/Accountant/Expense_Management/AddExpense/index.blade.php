@extends('layouts.admin')

@section('page-title', 'Expense Management | ' . config('app.name'))

@section('content')

{{-- SUCCESS --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}

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
                <h5 class="m-b-10">Expense Management</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Accounts</li>
                <li class="breadcrumb-item">Expense Management</li>
                <li class="breadcrumb-item">Expenses</li>
            </ul>

        </div>

        <div class="page-header-right ms-auto">

            <div class="d-flex gap-2">

                <a href="{{ route('admin.accountant.expense.add.deleted') }}"
                    class="btn btn-danger">

                    Deleted Records

                </a>

                <a href="{{ route('admin.accountant.expense.add.create') }}"
                    class="btn btn-primary">

                    Add Expense

                </a>

            </div>

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
                                <th>Expense Type</th>
                                <th>Invoice Number</th>
                                <th>Grand Total</th>
                                <th>Payment Status</th>
                                <th class="text-end">Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($expenses as $key => $expense)

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
                                        {{ $expense->expense_type }}
                                    </td>

                                    <td>
                                        {{ $expense->invoice_number ?? '-' }}
                                    </td>

                                    <td>
                                        ₹{{ number_format($expense->grand_total, 2) }}
                                    </td>

                                    <td>

                                        @if($expense->payment_status == 'Fully Paid')

                                            <span class="badge bg-soft-success text-success">
                                                Fully Paid
                                            </span>

                                        @elseif($expense->payment_status == 'Partial')

                                            <span class="badge bg-soft-warning text-warning">
                                                Partial
                                            </span>

                                        @else

                                            <span class="badge bg-soft-danger text-danger">
                                                Unpaid
                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-end">

                                        <div class="hstack gap-2 justify-content-end">

                                            {{-- View --}}
                                            <a href="{{ route('admin.accountant.expense.add.show', $expense->id) }}"
                                                class="avatar-text avatar-md">

                                                <i class="feather-eye"></i>

                                            </a>

                                  {{-- Voucher --}}
@if($expense->payment_status == 'Fully Paid')

<a href="{{ route('admin.accountant.expense.add.voucher', $expense->id) }}"
    class="avatar-text avatar-md">

    <i class="feather-file-text"></i>

</a>

@endif

{{-- Edit --}}
<a href="{{ route('admin.accountant.expense.add.edit', $expense->id) }}"
    class="avatar-text avatar-md">

    <i class="feather-edit"></i>

</a>

                                            {{-- Delete --}}
                                            <form action="{{ route('admin.accountant.expense.add.delete', $expense->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this expense?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md border-0 bg-transparent">

                                                    <i class="feather-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9" class="text-center py-4">
                                        No Expenses Found
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
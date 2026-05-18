@extends('layouts.admin')

@section('page-title', 'Income & Expense Report')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">

    <div>

        <h5 class="m-0 mb-1">

            <i class="feather-pie-chart me-2"></i>

            Income & Expense Report

        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                Accounts
            </li>

            <li class="breadcrumb-item">
                Expense Management
            </li>

            <li class="breadcrumb-item active">
                Income & Expense Report
            </li>

        </ul>

    </div>

    <a href="{{ route('admin.accountant.expense.report.index') }}"
       class="btn btn-light">

        <i class="feather-arrow-left me-1"></i>

        Back

    </a>

</div>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted mb-2">
                    IPD Income
                </h6>

                <h4 class="text-success mb-0">

                    ₹{{ number_format($ipdIncome, 2) }}

                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted mb-2">
                    Sales Income
                </h6>

                <h4 class="text-primary mb-0">

                    ₹{{ number_format($salesIncome, 2) }}

                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted mb-2">
                    Total Income
                </h6>

                <h4 class="text-success mb-0">

                    ₹{{ number_format($totalIncome, 2) }}

                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted mb-2">
                    Total Expense
                </h6>

                <h4 class="text-danger mb-0">

                    ₹{{ number_format($totalExpense, 2) }}

                </h4>

            </div>

        </div>

    </div>

</div>

{{-- ================= BALANCE ================= --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body text-center">

        <h5 class="mb-2">
            Balance Amount
        </h5>

        <h2 class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">

            ₹{{ number_format($balance, 2) }}

        </h2>

    </div>

</div>

{{-- ================= INCOME TABLE ================= --}}
<div class="card stretch stretch-full mb-4">

    <div class="card-header">

        <h6 class="mb-0">
            Income Details
        </h6>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Income Type</th>
                        <th>Payment Mode</th>
                        <th>Transaction Type</th>
                        <th class="text-end">Amount</th>

                    </tr>

                </thead>

                <tbody>

                    {{-- IPD PAYMENTS --}}
                    @foreach($ipdPayments as $index => $payment)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>
                            IPD Payment
                        </td>

                        <td>
                            {{ $payment->payment_mode }}
                        </td>

                        <td>
                            {{ $payment->transaction_type }}
                        </td>

                        <td class="text-end text-success fw-bold">

                            ₹{{ number_format($payment->amount, 2) }}

                        </td>

                    </tr>

                    @endforeach

                    {{-- SALES BILL --}}
                    @foreach($salesBills as $index => $sale)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>
                            Pharmacy Sales
                        </td>

                        <td>
                            {{ $sale->payment_mode }}
                        </td>

                        <td>
                            {{ $sale->payment_status }}
                        </td>

                        <td class="text-end text-primary fw-bold">

                            ₹{{ number_format($sale->paid_amount, 2) }}

                        </td>

                    </tr>

                    @endforeach

                    @if($ipdPayments->count() == 0 && $salesBills->count() == 0)

                    <tr>

                        <td colspan="5"
                            class="text-center">

                            No Income Records Found

                        </td>

                    </tr>

                    @endif

                </tbody>

                <tfoot>

                    <tr>

                        <th colspan="4"
                            class="text-end">

                            Total Income

                        </th>

                        <th class="text-end text-success">

                            ₹{{ number_format($totalIncome, 2) }}

                        </th>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

{{-- ================= EXPENSE TABLE ================= --}}
<div class="card stretch stretch-full">

    <div class="card-header">

        <h6 class="mb-0">
            Expense Details
        </h6>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Expense Category</th>
                        <th>Expense Heading</th>
                        <th>Vendor</th>
                        <th class="text-end">Amount</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($expenses as $index => $expense)

                        @foreach($expense->items as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                {{ $expense->category->category_name ?? '-' }}

                            </td>

                            <td>

                                {{ $item->expense_heading }}

                            </td>

                            <td>

                                {{ $expense->vendor->vendor_name ?? '-' }}

                            </td>

                            <td class="text-end text-danger fw-bold">

                                ₹{{ number_format($item->total, 2) }}

                            </td>

                        </tr>

                        @endforeach

                    @empty

                    <tr>

                        <td colspan="5"
                            class="text-center">

                            No Expense Records Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

                <tfoot>

                    <tr>

                        <th colspan="4"
                            class="text-end">

                            Total Expense

                        </th>

                        <th class="text-end text-danger">

                            ₹{{ number_format($totalExpense, 2) }}

                        </th>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

@endsection
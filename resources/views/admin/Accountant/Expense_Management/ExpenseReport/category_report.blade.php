@extends('layouts.admin')

@section('page-title', 'Category Wise Expense Report')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>

        <h5 class="m-0 mb-1">
            <i class="feather-bar-chart-2 me-2"></i>
            Category Wise Expense Report
        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                Accounts
            </li>

            <li class="breadcrumb-item">
                Expense Management
            </li>

            <li class="breadcrumb-item active">
                Category Wise Report
            </li>

        </ul>

    </div>

    {{-- BACK BUTTON --}}
    <div>

        <a href="{{ route('admin.accountant.expense.report.index') }}"
           class="btn btn-light">

            <i class="feather-arrow-left me-1"></i>
            Back

        </a>

    </div>

</div>

{{-- ================= STYLE ================= --}}
<style>

    .report-table th,
    .report-table td {

        font-size: 12px;
        vertical-align: middle;
        white-space: nowrap;

    }

</style>

{{-- ================= CARD ================= --}}
<div class="card stretch stretch-full">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-sm align-middle mb-0 report-table">

                <thead class="table-light">

                    <tr>

                        <th>Expense Date</th>

                        <th>Expense Category</th>

                        <th>Expense Type</th>

                        <th>Vendor Name</th>

                        <th>Invoice No</th>

                        <th>Invoice Date</th>

                        <th>Payment Status</th>

                        <th>Payment Date</th>

                        <th>Payment Mode</th>

                        <th>Transaction ID</th>

                        <th>Expense Heading</th>

                        <th>Unit</th>

                        <th>Unit Price</th>

                        <th>Sub Total</th>

                        <th>CGST</th>

                        <th>SGST</th>

                        <th>IGST</th>

                        <th>Total Amount</th>

                        <th>Paid Amount</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($expenses as $expense)

                    @foreach($expense->items as $item)

                        <tr>

                            {{-- Expense Details --}}
                            <td>
                                {{ \Carbon\Carbon::parse($expense->entry_date)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $expense->category->category_name ?? '-' }}
                            </td>

                            <td>
                                {{ $expense->expense_type ?? '-' }}
                            </td>

                            <td>
                                {{ $expense->vendor->vendor_name ?? '-' }}
                            </td>

                            <td>
                                {{ $expense->invoice_number ?? '-' }}
                            </td>

                            <td>

                                {{ $expense->invoice_date
                                    ? \Carbon\Carbon::parse($expense->invoice_date)->format('d-m-Y')
                                    : '-'
                                }}

                            </td>

                            {{-- Payment Status --}}
                            <td>

                                @if($expense->payment_status == 'Fully Paid')

                                    <span class="badge bg-success">
                                        Fully Paid
                                    </span>

                                @elseif($expense->payment_status == 'Partial')

                                    <span class="badge bg-warning text-dark">
                                        Partial
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Unpaid
                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $expense->payment_date
                                    ? \Carbon\Carbon::parse($expense->payment_date)->format('d-m-Y')
                                    : '-'
                                }}

                            </td>

                            <td>
                                {{ $expense->payment_mode ?? '-' }}
                            </td>

                            <td>
                                {{ $expense->transaction_id ?? '-' }}
                            </td>

                            {{-- Item Details --}}
                            <td>
                                {{ $item->expense_heading ?? '-' }}
                            </td>

                            <td>
                                {{ $item->unit ?? 0 }}
                            </td>

                            <td>
                                ₹{{ number_format($item->unit_price, 2) }}
                            </td>

                            <td>
                                ₹{{ number_format($item->sub_total, 2) }}
                            </td>

                            <td>
                                ₹{{ number_format($item->cgst, 2) }}
                            </td>

                            <td>
                                ₹{{ number_format($item->sgst, 2) }}
                            </td>

                            <td>
                                ₹{{ number_format($item->igst, 2) }}
                            </td>

                            <td class="fw-semibold">
                                ₹{{ number_format($item->total, 2) }}
                            </td>

                            <td class="fw-semibold text-success">
                                ₹{{ number_format($expense->paid_amount, 2) }}
                            </td>

                        </tr>

                    @endforeach

                @empty

                    <tr>

                        <td colspan="19"
                            class="text-center py-4 text-muted">

                            No Expense Records Found

                        </td>

                    </tr>

                @endforelse

                {{-- FINAL TOTAL --}}
                <tr class="table-light">

                    <td colspan="17"
                        class="text-end fw-bold">

                        Final Total

                    </td>

                    <td colspan="2"
                        class="fw-bold text-success">

                        ₹{{ number_format($finalTotal, 2) }}

                    </td>

                </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
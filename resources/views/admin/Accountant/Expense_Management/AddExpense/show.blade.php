@extends('layouts.admin')

@section('page-title', 'View Expense | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    {{-- Page Header --}}
    <div class="page-header mb-4 d-flex justify-content-between align-items-center">

        <h5 class="mb-1">View Expense</h5>

        <a href="{{ route('admin.accountant.expense.add.index') }}"
            class="btn btn-light">

            <i class="feather-arrow-left me-1"></i> Back
        </a>

    </div>

    <div class="main-content">

        <div class="card">
            <div class="card-body">

                <div class="row mb-4">

                    <div class="col-md-4">
                        <label><strong>Entry Date</strong></label>
                        <p>{{ \Carbon\Carbon::parse($expense->entry_date)->format('d-m-Y') }}</p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Category</strong></label>
                        <p>{{ $expense->category->category_name ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Vendor</strong></label>
                        <p>{{ $expense->vendor->vendor_name ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Expense Type</strong></label>
                        <p>{{ $expense->expense_type }}</p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Invoice Number</strong></label>
                        <p>{{ $expense->invoice_number ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Invoice Date</strong></label>
                        <p>
                            {{ $expense->invoice_date
                                ? \Carbon\Carbon::parse($expense->invoice_date)->format('d-m-Y')
                                : '-' }}
                        </p>
                    </div>

                </div>

                <hr>

                <h5 class="mb-3">Expense Items</h5>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>Expense Heading</th>
                                <th>Unit</th>
                                <th>Unit Price</th>
                                <th>Sub Total</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>IGST</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($expense->items as $item)

                                <tr>

                                    <td>{{ $item->expense_heading }}</td>

                                    <td>{{ $item->unit }}</td>

                                    <td>₹{{ number_format($item->unit_price, 2) }}</td>

                                    <td>₹{{ number_format($item->sub_total, 2) }}</td>

                                    <td>{{ $item->cgst }}</td>

                                    <td>{{ $item->sgst }}</td>

                                    <td>{{ $item->igst }}</td>

                                    <td>₹{{ number_format($item->total, 2) }}</td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="row mt-4">

                    <div class="col-md-4">
                        <label><strong>Grand Total</strong></label>
                        <p>₹{{ number_format($expense->grand_total, 2) }}</p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Payment Status</strong></label>
                        <p>{{ $expense->payment_status }}</p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Payment Mode</strong></label>
                        <p>{{ $expense->payment_mode ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Paid Amount</strong></label>
                        <p>
                            {{ $expense->paid_amount
                                ? '₹' . number_format($expense->paid_amount, 2)
                                : '-' }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Transaction ID</strong></label>
                        <p>{{ $expense->transaction_id ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <label><strong>Payment Date</strong></label>
                        <p>
                            {{ $expense->payment_date
                                ? \Carbon\Carbon::parse($expense->payment_date)->format('d-m-Y')
                                : '-' }}
                        </p>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

@endsection
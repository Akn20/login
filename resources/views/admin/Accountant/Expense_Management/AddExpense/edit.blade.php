@extends('layouts.admin')

@section('page-title', 'Edit Expense | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Edit Expense</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Accounts</li>
                <li class="breadcrumb-item">Expense Management</li>
                <li class="breadcrumb-item">Edit Expense</li>
            </ul>
        </div>
    </div>

    <div class="main-content">

    @if ($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

        <div class="row">

            <div class="col-lg-12">

                <div class="card stretch stretch-full">

                    <div class="card-body">

                    <form action="{{ route('admin.accountant.expense.add.update', $expense->id) }}"
    method="POST">

    @csrf
    @method('PUT')

                            <div class="row">

                                {{-- Entry Date --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Entry Date
                                    </label>

                                    <input type="date"
                                        name="entry_date"
                                        class="form-control"
                                        value="{{ $expense->entry_date }}">
                                </div>

                                {{-- Category --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Select Category
                                    </label>

                                    <select name="category_id"
                                        class="form-select">

                                        @foreach($categories as $category)

                                            <option value="{{ $category->id }}"
                                                {{ $expense->category_id == $category->id ? 'selected' : '' }}>

                                                {{ $category->category_name }}

                                            </option>

                                        @endforeach

                                    </select>
                                </div>

                                {{-- Vendor --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Select Vendor
                                    </label>

                                    <select name="vendor_id"
                                        class="form-select">

                                        <option value="">
                                            Select Vendor
                                        </option>

                                        @foreach($vendors as $vendor)

                                            <option value="{{ $vendor->id }}"
                                                {{ $expense->vendor_id == $vendor->id ? 'selected' : '' }}>

                                                {{ $vendor->vendor_name }}

                                            </option>

                                        @endforeach

                                    </select>
                                </div>

                                {{-- Expense Type --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Expense Type
                                    </label>

                                    <input type="text"
                                        name="expense_type"
                                        class="form-control"
                                        value="{{ $expense->expense_type }}">
                                </div>

                                {{-- Invoice Date --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Invoice Date
                                    </label>

                                    <input type="date"
                                        name="invoice_date"
                                        class="form-control"
                                        value="{{ $expense->invoice_date }}">
                                </div>

                                {{-- Invoice Number --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Invoice Number
                                    </label>

                                    <input type="text"
                                        name="invoice_number"
                                        class="form-control"
                                        value="{{ $expense->invoice_number }}">
                                </div>

                            </div>

                            <hr>

                            <h5 class="mb-4">
                                Expense Details
                            </h5>

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

                                                <td>
                                                    <input type="text"
                                                        name="expense_heading[]"
                                                        class="form-control"
                                                        value="{{ $item->expense_heading }}">
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        name="unit[]"
                                                        class="form-control"
                                                        value="{{ $item->unit }}">
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        name="unit_price[]"
                                                        class="form-control"
                                                        value="{{ $item->unit_price }}">
                                                </td>

                                                <td>
                                                    <input type="text"
                                                        name="sub_total[]"
                                                        class="form-control"
                                                        value="{{ $item->sub_total }}"
                                                        readonly>
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        name="cgst[]"
                                                        class="form-control"
                                                        value="{{ $item->cgst }}">
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        name="sgst[]"
                                                        class="form-control"
                                                        value="{{ $item->sgst }}">
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        name="igst[]"
                                                        class="form-control"
                                                        value="{{ $item->igst }}">
                                                </td>

                                                <td>
                                                    <input type="text"
                                                        name="total[]"
                                                        class="form-control"
                                                        value="{{ $item->total }}"
                                                        readonly>
                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                            {{-- Grand Total --}}
                            <div class="row mt-4">

                                <div class="col-lg-3">

                                    <label class="form-label">
                                        Grand Total
                                    </label>

                                    <input type="text"
                                        class="form-control"
                                        value="{{ $expense->grand_total }}"
                                        readonly>

                                </div>

                            </div>

                            <hr>

                            <h5 class="mb-4">
                                Payment Details
                            </h5>

                            <div class="row">

                                {{-- Payment Status --}}
                                <div class="col-lg-4 mb-4">

                                    <label class="form-label">
                                        Payment Status
                                    </label>

                                    <select name="payment_status"
                                        class="form-select">

                                        <option value="Unpaid"
                                            {{ $expense->payment_status == 'Unpaid' ? 'selected' : '' }}>
                                            Unpaid
                                        </option>

                                        <option value="Partial"
                                            {{ $expense->payment_status == 'Partial' ? 'selected' : '' }}>
                                            Partial
                                        </option>

                                        <option value="Fully Paid"
                                            {{ $expense->payment_status == 'Fully Paid' ? 'selected' : '' }}>
                                            Fully Paid
                                        </option>

                                    </select>

                                </div>

                                {{-- Payment Mode --}}
                                <div class="col-lg-4 mb-4">

                                    <label class="form-label">
                                        Payment Mode
                                    </label>

                                    <select name="payment_mode"
                                        class="form-select">

                                        <option value="Cash"
                                            {{ $expense->payment_mode == 'Cash' ? 'selected' : '' }}>
                                            Cash
                                        </option>

                                        <option value="Online"
                                            {{ $expense->payment_mode == 'Online' ? 'selected' : '' }}>
                                            Online
                                        </option>

                                        <option value="UPI"
                                            {{ $expense->payment_mode == 'UPI' ? 'selected' : '' }}>
                                            UPI
                                        </option>

                                        <option value="Cheque"
                                            {{ $expense->payment_mode == 'Cheque' ? 'selected' : '' }}>
                                            Cheque
                                        </option>

                                        <option value="DD"
                                            {{ $expense->payment_mode == 'DD' ? 'selected' : '' }}>
                                            DD
                                        </option>

                                    </select>

                                </div>

                                {{-- Payment Date --}}
                                <div class="col-lg-4 mb-4">

                                    <label class="form-label">
                                        Payment Date
                                    </label>

                                    <input type="date"
                                        name="payment_date"
                                        class="form-control"
                                        value="{{ $expense->payment_date }}">

                                </div>

                                {{-- Paid Amount --}}
                                <div class="col-lg-4 mb-4">

                                    <label class="form-label">
                                        Paid Amount
                                    </label>

                                    <input type="number"
                                        name="paid_amount"
                                        class="form-control"
                                        value="{{ $expense->paid_amount }}">

                                </div>

                                {{-- Transaction ID --}}
                                <div class="col-lg-4 mb-4">

                                    <label class="form-label">
                                        Transaction ID
                                    </label>

                                    <input type="text"
                                        name="transaction_id"
                                        class="form-control"
                                        value="{{ $expense->transaction_id }}">

                                </div>

                            </div>

                            <div class="d-flex gap-2 mt-4">

                                <button type="submit"
                                    class="btn btn-primary">
                                    Update
                                </button>

                                <a href="{{ route('admin.accountant.expense.add.index') }}"
                                    class="btn btn-light">

                                    Back

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
@extends('layouts.admin')

@section('page-title', 'Add Expense | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Add Expense</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Accounts</li>
                <li class="breadcrumb-item">Expense Management</li>
                <li class="breadcrumb-item">Add Expense</li>
            </ul>
        </div>
    </div>

   <div class="main-content"> 

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


        <div class="row">

            <div class="col-lg-12">

                <div class="card stretch stretch-full">

                    <div class="card-body">

                        <form action="{{ route('admin.accountant.expense.add.store') }}"
                            method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                {{-- Entry Date --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Entry Date
                                    </label>
<input type="date"
    name="entry_date"
    value="{{ old('entry_date') }}"
    class="form-control @error('entry_date') is-invalid @enderror">

@error('entry_date')
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror
                                </div>

                                {{-- Category --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Select Category
                                    </label>

                                    <select name="category_id" class="form-select">

                                        <option value="">Select Category</option>

                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
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

                                    <select name="vendor_id" class="form-select">

                                        <option value="">Select Vendor</option>

                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">
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
                                        placeholder="Enter expense type">
                                </div>

                                {{-- Invoice Date --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Invoice Date
                                    </label>

                                    <input type="date"
                                        name="invoice_date"
                                        class="form-control">
                                </div>

                                {{-- Invoice Number --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Invoice Number
                                    </label>

                                    <input type="text"
                                        name="invoice_number"
                                        class="form-control"
                                        placeholder="Enter invoice number">
                                </div>

                                {{-- PO Attachment --}}
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">
                                        PO Attachment
                                    </label>

                                    <input type="file"
                                        name="po_attachment"
                                        class="form-control">
                                </div>

                            </div>

                            <hr>

                            {{-- Expense Details --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    Expense Details
                                </h5>

                                <button type="button"
                                    id="addRow"
                                    class="btn btn-sm btn-primary">
                                    Add Row
                                </button>
                            </div>

                            <div class="table-responsive">

                                <table class="table table-bordered align-middle">

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
                                            <th>Attachment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td>
                                                <input type="text"
                                                    name="expense_heading[]"
                                                    class="form-control"
                                                    placeholder="Expense heading">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    name="unit[]"
                                                    class="form-control unit">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    step="0.01"
                                                    name="unit_price[]"
                                                    class="form-control unit_price">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    step="0.01"
                                                    name="sub_total[]"
                                                    class="form-control sub_total"
                                                    readonly>
                                            </td>

                                            <td>
                                                <input type="number"
                                                    step="0.01"
                                                    name="cgst[]"
                                                    class="form-control cgst">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    step="0.01"
                                                    name="sgst[]"
                                                    class="form-control sgst">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    step="0.01"
                                                    name="igst[]"
                                                    class="form-control igst">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    step="0.01"
                                                    name="total[]"
                                                    class="form-control total"
                                                    readonly>
                                            </td>

                                            <td>
                                                <input type="file"
                                                    name="attachment[]"
                                                    class="form-control">
                                            </td>

                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger removeRow">
                                                    Remove
                                                </button>
                                            </td>

                                        </tr>

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
                                        name="grand_total"
                                        class="form-control"
                                        readonly>
                                </div>

                            </div>

                            <hr>

                            {{-- Payment Details --}}
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
class="form-select @error('payment_status') is-invalid @enderror">

    <option value="Unpaid">
        Unpaid
    </option>

    <option value="Partial">
        Partial
    </option>

    <option value="Fully Paid">
        Fully Paid
    </option>

</select>
                                </div>

                                {{-- Payment Mode --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Payment Mode
                                    </label>

                                    <select name="payment_mode" class="form-select">
                                        <option>Cash</option>
                                        <option>Online</option>
                                        <option>UPI</option>
                                        <option>Cheque</option>
                                        <option>DD</option>
                                    </select>
                                </div>

                                {{-- Payment Date --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Payment Date
                                    </label>

                                    <input type="date"
                                        name="payment_date"
                                        class="form-control">
                                </div>

                                {{-- Paid Amount --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Paid Amount
                                    </label>

                                    <input type="number"
                                        name="paid_amount"
                                        class="form-control">
                                </div>

                                {{-- Transaction ID --}}
                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Transaction ID
                                    </label>

                                    <input type="text"
    name="transaction_id"
    value="{{ old('transaction_id') }}"
    class="form-control @error('transaction_id') is-invalid @enderror"
    placeholder="Enter transaction ID">

@error('transaction_id')
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror
                                </div>

                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex gap-2 mt-4">

                                <button type="submit"
                                    class="btn btn-primary">
                                    Save
                                </button>

                                <a href="{{ route('admin.accountant.expense.add.index') }}"
                                    class="btn btn-light">
                                    Cancel
                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function () {

    // Add Row
    $('#addRow').click(function () {

        let row = `
        <tr>

            <td>
                <input type="text"
                    name="expense_heading[]"
                    class="form-control"
                    placeholder="Expense heading">
            </td>

            <td>
                <input type="number"
                    name="unit[]"
                    class="form-control unit">
            </td>

            <td>
                <input type="number"
                    step="0.01"
                    name="unit_price[]"
                    class="form-control unit_price">
            </td>

            <td>
                <input type="number"
                    step="0.01"
                    name="sub_total[]"
                    class="form-control sub_total"
                    readonly>
            </td>

            <td>
                <input type="number"
                    step="0.01"
                    name="cgst[]"
                    class="form-control cgst">
            </td>

            <td>
                <input type="number"
                    step="0.01"
                    name="sgst[]"
                    class="form-control sgst">
            </td>

            <td>
                <input type="number"
                    step="0.01"
                    name="igst[]"
                    class="form-control igst">
            </td>

            <td>
                <input type="number"
                    step="0.01"
                    name="total[]"
                    class="form-control total"
                    readonly>
            </td>

            <td>
                <input type="file"
                    name="attachment[]"
                    class="form-control">
            </td>

            <td>
                <button type="button"
                    class="btn btn-sm btn-danger removeRow">
                    Remove
                </button>
            </td>

        </tr>
        `;

        $('table tbody').append(row);
    });

    // Remove Row
    $(document).on('click', '.removeRow', function () {

        $(this).closest('tr').remove();

        calculateGrandTotal();
    });

    // Auto Calculation
    $(document).on(
        'keyup change',
        '.unit, .unit_price, .cgst, .sgst, .igst',
        function () {

            let row = $(this).closest('tr');

            let unit =
                parseFloat(row.find('.unit').val()) || 0;

            let unitPrice =
                parseFloat(row.find('.unit_price').val()) || 0;

            let cgst =
                parseFloat(row.find('.cgst').val()) || 0;

            let sgst =
                parseFloat(row.find('.sgst').val()) || 0;

            let igst =
                parseFloat(row.find('.igst').val()) || 0;

            let subtotal = unit * unitPrice;

            row.find('.sub_total')
                .val(subtotal.toFixed(2));

            let total =
                subtotal + cgst + sgst + igst;

            row.find('.total')
                .val(total.toFixed(2));

            calculateGrandTotal();
        }
    );

    // Grand Total
    function calculateGrandTotal() {

        let grandTotal = 0;

        $('.total').each(function () {

            grandTotal +=
                parseFloat($(this).val()) || 0;
        });

        $('input[name="grand_total"]')
            .val(grandTotal.toFixed(2));
    }

});

</script>

@endsection
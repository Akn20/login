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

        <div class="row">

            <div class="col-lg-12">

                <div class="card stretch stretch-full">

                    <div class="card-body">

                        {{-- UI only --}}
                        <form>

                            <div class="row">

                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">Entry Date</label>

                                    <input type="date"
                                        class="form-control"
                                        value="2026-05-09">
                                </div>

                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Select Category
                                    </label>

                                    <select class="form-select">
                                        <option selected>Fuel</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Select Vendor
                                    </label>

                                    <select class="form-select">
                                        <option selected>ABC Vendor</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Expense Type
                                    </label>

                                    <input type="text"
                                        class="form-control"
                                        value="Office Expense">
                                </div>

                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Invoice Date
                                    </label>

                                    <input type="date"
                                        class="form-control"
                                        value="2026-05-09">
                                </div>

                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Invoice Number
                                    </label>

                                    <input type="text"
                                        class="form-control"
                                        value="INV001">
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

                                        <tr>

                                            <td>
                                                <input type="text"
                                                    class="form-control"
                                                    value="Petrol">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    class="form-control"
                                                    value="2">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    class="form-control"
                                                    value="1000">
                                            </td>

                                            <td>
                                                <input type="text"
                                                    class="form-control"
                                                    value="2000"
                                                    readonly>
                                            </td>

                                            <td>
                                                <input type="number"
                                                    class="form-control"
                                                    value="9">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    class="form-control"
                                                    value="9">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    class="form-control"
                                                    value="0">
                                            </td>

                                            <td>
                                                <input type="text"
                                                    class="form-control"
                                                    value="2360"
                                                    readonly>
                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                            <div class="row mt-4">

                                <div class="col-lg-3">
                                    <label class="form-label">
                                        Grand Total
                                    </label>

                                    <input type="text"
                                        class="form-control"
                                        value="2360"
                                        readonly>
                                </div>

                            </div>

                            <hr>

                            <h5 class="mb-4">
                                Payment Details
                            </h5>

                            <div class="row">

                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Payment Status
                                    </label>

                                    <select class="form-select">
                                        <option>Unpaid</option>
                                        <option selected>Partial</option>
                                        <option>Paid</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Payment Mode
                                    </label>

                                    <select class="form-select">
                                        <option selected>UPI</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-4">
                                    <label class="form-label">
                                        Payment Date
                                    </label>

                                    <input type="date"
                                        class="form-control"
                                        value="2026-05-09">
                                </div>

                            </div>

                            <div class="d-flex gap-2 mt-4">

                                <button type="submit"
                                    class="btn btn-primary">
                                    Update
                                </button>

                                <a href="#"
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

@endsection
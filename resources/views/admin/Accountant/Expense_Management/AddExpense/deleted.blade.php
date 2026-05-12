@extends('layouts.admin')

@section('page-title', 'Deleted Expenses | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    {{-- Page Header --}}
    <div class="page-header">

        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5>Deleted Expenses</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto">

            <a href="#"
                class="btn btn-light">
                Back
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

                            {{-- Dummy UI Row --}}
                            <tr>

                                <td>1</td>
                                <td>09-05-2026</td>
                                <td>Fuel</td>
                                <td>ABC Vendor</td>
                                <td>₹2500</td>

                                <td>
                                    <span class="badge bg-soft-danger text-danger">
                                        Deleted
                                    </span>
                                </td>

                                <td class="text-end">

                                    <div class="hstack gap-2 justify-content-end">

                                        {{-- Restore --}}
                                        <a href="#"
                                            class="avatar-text avatar-md">
                                            <i class="feather-refresh-ccw"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
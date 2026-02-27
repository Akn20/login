@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Stock Details</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Stock</li>
                <li class="breadcrumb-item">View</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.stock.edit', $batch->id) }}" class="btn btn-neutral">
                Edit Stock
            </a>
            <a href="{{ route('admin.stock.index') }}" class="btn btn-neutral">
                Back
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="row">

            {{-- Stock Info Card --}}
            <div class="col-lg-4">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Batch Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th class="ps-0" style="width:140px;">Medicine</th>
                                <td>{{ $batch->medicine->medicine_name }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Batch</th>
                                <td>{{ $batch->batch_number }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Expiry</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($batch->expiry_date)->format('d-m-Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-0">Quantity</th>
                                <td>
                                    {{ $batch->quantity }}

                                    @if($batch->quantity <= $batch->reorder_level)
                                        <span class="badge bg-soft-danger text-danger ms-2">
                                            Low Stock
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-0">Reorder Level</th>
                                <td>{{ $batch->reorder_level }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Status</th>
                                <td>
                                    @if(\Carbon\Carbon::parse($batch->expiry_date)->isPast())
                                        <span class="badge bg-soft-dark text-dark">Expired</span>
                                    @else
                                        <span class="badge bg-soft-success text-success">Active</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Pricing Card --}}
            <div class="col-lg-8">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Pricing Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th style="width:200px;">Purchase Price</th>
                                <td>&#8377; {{ number_format($batch->purchase_price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>MRP</th>
                                <td>&#8377; {{ number_format($batch->mrp, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total Stock Value</th>
                                <td>
                                    &#8377;
                                    {{ number_format($batch->quantity * $batch->purchase_price, 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Optional Future: Stock Movement History --}}
                {{-- You can later add Stock Movements table here --}}

            </div>

        </div>
    </div>

</div>

@endsection
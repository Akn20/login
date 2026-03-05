@extends('layouts.admin')

@section('page-title', 'Inventory Reports | ' . config('app.name'))
@section('title', 'Inventory Reports')

@push('styles')
    <style>
        .avatar-text {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    </style>
@endpush

@section('content')
    {{-- Page header similar to dashboard --}}
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">
                    <i class="feather-bar-chart-2 me-2"></i>Inventory Reports
                </h5>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Inventory Reports</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="row g-3">

            {{-- Total Items card --}}
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-text avatar-lg bg-primary text-white">
                                <i class="feather-box"></i>
                            </div>
                            <h3 class="fs-13 fw-semibold mb-0">Total Items</h3>
                        </div>
                        <div class="text-center mb-3">
                            <div class="fs-3 fw-bold text-dark">
                                <span class="counter">{{ $totalItems }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Low Stock card --}}
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-text avatar-lg bg-danger text-white">
                                <i class="feather-alert-circle"></i>
                            </div>
                            <h3 class="fs-13 fw-semibold mb-0">Low Stock</h3>
                        </div>
                        <div class="text-center mb-3">
                            <div class="fs-3 fw-bold text-dark">
                                <span class="counter">{{ $lowStockItems }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total PO card --}}
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-text avatar-lg bg-info text-white">
                                <i class="feather-shopping-cart"></i>
                            </div>
                            <h3 class="fs-13 fw-semibold mb-0">Total PO</h3>
                        </div>
                        <div class="text-center mb-3">
                            <div class="fs-3 fw-bold text-dark">
                                <span class="counter">{{ $totalPO }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stock Value card --}}
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-text avatar-lg bg-success text-white">
                                <i class="feather-dollar-sign"></i>
                            </div>
                            <h3 class="fs-13 fw-semibold mb-0">Stock Value</h3>
                        </div>
                        <div class="text-center mb-3">
                            <div class="fs-3 fw-bold text-dark">
                                ₹ {{ number_format($totalStockValue, 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <hr>

        <div class="row g-3">
            {{-- Recent Purchase Orders --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Recent Purchase Orders</div>
                    <div class="card-body">
                        <ul>
                            @foreach($recentPOs as $po)
                                <li>{{ $po->po_number }} - {{ $po->status }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Recent GRNs --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Recent GRNs</div>
                    <div class="card-body">
                        <ul>
                            @foreach($recentGrns as $grn)
                                <li>{{ $grn->grn_number }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
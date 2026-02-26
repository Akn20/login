@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Inventory Reports Dashboard</h5>
    </div>
</div>

<div class="row">

    <!-- Total Items -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h4>{{ $totalItems }}</h4>
                <p>Total Items</p>
            </div>
        </div>
    </div>

    <!-- Low Stock -->
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h4>{{ $lowStockItems }}</h4>
                <p>Low Stock Items</p>
            </div>
        </div>
    </div>

    <!-- Total PO -->
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h4>{{ $totalPO }}</h4>
                <p>Total Purchase Orders</p>
            </div>
        </div>
    </div>

    <!-- Stock Value -->
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h4>₹ {{ number_format($totalStockValue, 2) }}</h4>
                <p>Total Stock Value</p>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">

    <!-- Recent Purchase Orders -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Recent Purchase Orders
            </div>
            <div class="card-body">
                <ul>
                    @foreach($recentPOs as $po)
                        <li>
                            {{ $po->po_number }} - {{ $po->status }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent GRNs -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Recent GRNs
            </div>
            <div class="card-body">
                <ul>
                    @foreach($recentGrns as $grn)
                        <li>
                            {{ $grn->grn_number }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</div>

@endsection
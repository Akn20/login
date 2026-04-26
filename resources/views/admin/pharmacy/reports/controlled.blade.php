@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Controlled Drug Report</h4>
    </div>

    <!-- 🔹 Filters -->
    <form method="GET">
<div class="row g-3 mb-3">

    <!-- Medicine Filter -->
    <div class="col-md-3">
        <label>Drug Name</label>
       <select name="drug_name" class="form-control">
    <option value="">All</option>
    @foreach($allMedicines as $m)
        <option value="{{ $m->drug_name }}"
            {{ request('drug_name') == $m->drug_name ? 'selected' : '' }}>
            {{ $m->drug_name }}
        </option>
    @endforeach
</select>
    </div>

    <!-- Date filters -->
    <div class="col-md-3">
        <label>From Date</label>
        <input type="date" name="from" value="{{ request('from') }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label>To Date</label>
        <input type="date" name="to" value="{{ request('to') }}" class="form-control">
    </div>

    <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary w-100">Filter</button>
    </div>

</div>
</form>

    <!-- 🔹 Summary Cards -->
  <div class="row mb-3">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Dispensed</h6>
                <h4>{{ $totalDispensed }} Units</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Remaining Stock</h6>
                <h4>{{ $remainingStock }} Units</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-danger">
            <div class="card-body">
                <h6>High Risk Drugs</h6>
                <h4>{{ $highRisk }}</h4>
            </div>
        </div>
    </div>

</div>

    <!-- 🔹 Table -->
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Drug Name</th>
                        <th>Patient Name</th>
                        <th>Quantity Dispensed</th>
                        <th>Date</th>
                        <th>Remaining Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>

               <tbody>
@forelse($records as $r)
<tr>
    <td>{{ $r->drug_name }}</td>

    <!-- patient_id only for now -->
    <td>{{ $r->patient_id }}</td>

    <td>{{ $r->quantity_dispensed }}</td>

    <td>{{ \Carbon\Carbon::parse($r->dispense_date)->format('d-m-Y') }}</td>

    <td>{{ $r->stock_quantity }}</td>

    <td>
        @if($r->stock_quantity < 20)
            <span class="badge bg-danger">High Risk</span>
        @elseif($r->stock_quantity < 50)
            <span class="badge bg-warning">Moderate</span>
        @else
            <span class="badge bg-success">Safe</span>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">No data found</td>
</tr>
@endforelse
</tbody>

            </table>
  <div class="mt-3">
                {{ $records->links()}}
            </div>
        </div>
    </div>

</div>

@endsection
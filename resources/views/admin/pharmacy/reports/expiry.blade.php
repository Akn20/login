@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Expiry Report</h4>
    </div>

    <!-- 🔹 Filters -->
<form method="GET">
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">

            <div class="col-md-4">
                <label>Expiry Range</label>
                <select name="range" class="form-control">
                    <option value="">All</option>
                    <option value="30">Next 30 Days</option>
                    <option value="60">Next 60 Days</option>
                    <option value="90">Next 90 Days</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Medicine</label>
                <select name="medicine_id" class="form-control">
                    <option value="">All</option>
                    @foreach($allMedicines as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->medicine_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary w-100 mt-2">Filter</button>
            </div>

        </div>
    </div>
</div>
</form>

    <!-- 🔹 Summary Cards -->
   <div class="row mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm border-warning h-100">
            <div class="card-body">
                <h6>Near Expiry</h6>
                <h4>{{ $nearExpiry }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-danger h-100">
            <div class="card-body">
                <h6>Expired</h6>
                <h4>{{ $expired }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6>Total Affected Stock</h6>
                <h4>{{ $total }}</h4>
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
                        <th>Medicine Name</th>
                        <th>Batch No</th>
                        <th>Expiry Date</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
@forelse($expiry as $item)
<tr>
    <td>{{ $item->medicine_name }}</td>
    <td>{{ $item->batch_number }}</td>
    <td>{{ \Carbon\Carbon::parse($item->expiry_date)->format('d-m-Y') }}</td>
    <td>{{ $item->quantity }}</td>

    <td>
        @if($item->expiry_date < now())
            <span class="badge bg-danger">Expired</span>
        @elseif($item->expiry_date <= now()->addDays(30))
            <span class="badge bg-warning">Near Expiry</span>
        @else
            <span class="badge bg-success">Safe</span>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">No data found</td>
</tr>
@endforelse
</tbody>

            </table>
              <div class="mt-3">
{{ $expiry->links() }}</div>
        </div>
    </div>

</div>

@endsection
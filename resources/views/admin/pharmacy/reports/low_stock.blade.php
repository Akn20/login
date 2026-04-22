@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Low Stock Report</h4>
    </div>

    <!-- 🔹 Filters -->
    <form method="GET">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">

                    <!-- Medicine Filter -->
                    <div class="col-md-4">
                        <label>Medicine</label>
                        <select name="medicine_id" class="form-control">
                            <option value="">All</option>
                            @foreach($allMedicines as $m)
                                <option value="{{ $m->id }}"
                                    {{ request('medicine_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->medicine_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Stock Level Filter -->
                    <div class="col-md-4">
                        <label>Stock Level</label>
                        <select name="level" class="form-control">
                            <option value="">All</option>
                            <option value="critical" {{ request('level') == 'critical' ? 'selected' : '' }}>
                                Critical (&lt; 10)
                            </option>
                            <option value="low" {{ request('level') == 'low' ? 'selected' : '' }}>
                                Low (&lt; Reorder Level)
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- 🔹 Summary Cards -->
    <div class="row mb-3">

        <div class="col-md-4">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <h6>Critical Stock</h6>
                    <h4>{{ $criticalCount }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <h6>Low Stock</h6>
                    <h4>{{ $lowCount }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Low Items</h6>
                    <h4>{{ $medicines->total() }}</h4>
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
                        <th>Current Stock</th>
                        <th>Minimum Level</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($medicines as $med)
                <tr>
                    <td>{{ $med->medicine_name }}</td>
                    <td>{{ $med->total_stock }}</td>
                    <td>{{ $med->reorder_level }}</td>

                    <td>
                        @if($med->total_stock < 10)
                            <span class="badge bg-danger">Critical</span>
                        @elseif($med->total_stock < $med->reorder_level)
                            <span class="badge bg-warning">Low</span>
                        @else
                            <span class="badge bg-success">Normal</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No data found</td>
                </tr>
                @endforelse
                </tbody>

            </table>

            <!-- 🔹 Pagination -->
            <div class="mt-3">
                {{ $medicines->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
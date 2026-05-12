@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Batch-wise Report</h4>
    </div>

    <!-- 🔹 Filters -->
    <form method="GET">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">

                    <!-- Medicine -->
                    <div class="col-md-3">
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

                    <!-- Batch -->
                    <div class="col-md-3">
                        <label>Batch No</label>
                        <input type="text" name="batch"
                               value="{{ request('batch') }}"
                               class="form-control" placeholder="Enter Batch">
                    </div>

                    <!-- Expiry Range -->
                    <div class="col-md-3">
                        <label>Expiry Range</label>
                        <select name="expiry_range" class="form-control">
                            <option value="">All</option>
                            <option value="30" {{ request('expiry_range') == '30' ? 'selected' : '' }}>
                                Next 30 Days
                            </option>
                            <option value="60" {{ request('expiry_range') == '60' ? 'selected' : '' }}>
                                Next 60 Days
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- 🔹 Summary Cards -->
    <div class="row mb-3">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Batches</h6>
                    <h4>{{ $batches->total() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <h6>Near Expiry</h6>
                    <h4>{{ $nearExpiryCount }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <h6>Expired</h6>
                    <h4>{{ $expiredCount }}</h4>
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
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($batches as $batch)
                <tr>
                    <td>{{ $batch->medicine_name }}</td>
                    <td>{{ $batch->batch_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($batch->expiry_date)->format('d-m-Y') }}</td>
                    <td>{{ $batch->quantity }}</td>

                    <td>
                        @if($batch->expiry_date < now())
                            <span class="badge bg-danger">Expired</span>
                        @elseif($batch->expiry_date <= now()->addDays(30))
                            <span class="badge bg-warning">Near Expiry</span>
                        @else
                            <span class="badge bg-success">Active</span>
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

            <!-- 🔹 Pagination -->
            <div class="mt-3">
                {{ $batches->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
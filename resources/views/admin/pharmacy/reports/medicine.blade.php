@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Medicine-wise Sales Report</h4>
    </div>

    <!-- 🔹 Filters -->
<form method="GET">

<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-3">
                <label>From Date</label>
                <input type="date" name="from"
                       value="{{ request('from') }}"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <label>To Date</label>
                <input type="date" name="to"
                       value="{{ request('to') }}"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <label>Medicine</label>
                <select name="medicine_id" class="form-control">
                    <option value="">All</option> <!-- IMPORTANT -->

                    @foreach($allMedicines as $m)
                        <option value="{{ $m->id }}"
                            {{ request('medicine_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->medicine_name }}
                        </option>
                    @endforeach
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
                    <h6>Total Medicines Sold</h6>
                    <h4>{{ $medicines->sum('total_quantity') }} Units</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Revenue</h6>
                  <h4>₹ {{ $medicines->sum('total_revenue') }}</h4>
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
                        <th>Quantity Sold</th>
                        <th>Unit Price</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>

                <tbody>
@forelse($medicines as $item)
<tr>
    <td>{{ $item->medicine_name }}</td>
    <td>{{ $item->total_quantity }}</td>
    <td>₹ {{ number_format($item->unit_price, 2) }}</td>
    <td>₹ {{ number_format($item->total_revenue, 2) }}</td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center">No data found</td>
</tr>
@endforelse
</tbody>

            </table>
            <div class="mt-3">
    {{ $medicines->links() }}
</div>
        </div>
    </div>

</div>

@endsection
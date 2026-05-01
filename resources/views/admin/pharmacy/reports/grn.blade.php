@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- 🔹 Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>GRN Report</h4>
    </div>

    <!-- 🔹 Filters -->
 <form method="GET">
<div class="row g-3 mb-3">

    <div class="col-md-3">
        <label>Vendor</label>
        <input type="text" name="vendor_name"
               value="{{ request('vendor_name') }}"
               class="form-control" placeholder="Enter Vendor">
    </div>

    <div class="col-md-3">
        <label>Medicine</label>
        <input type="text" name="medicine_name"
               value="{{ request('medicine_name') }}"
               class="form-control" placeholder="Enter Medicine">
    </div>

    <div class="col-md-2">
        <label>From</label>
        <input type="date" name="from" value="{{ request('from') }}" class="form-control">
    </div>

    <div class="col-md-2">
        <label>To</label>
        <input type="date" name="to" value="{{ request('to') }}" class="form-control">
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100">Filter</button>
    </div>

</div>
</form>

    <!-- 🔹 Summary Cards -->
   <div class="row mb-3">

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Total GRN</h6>
                <h4>{{ $totalGRN }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Total Quantity</h6>
                <h4>{{ $totalQty }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Total Value</h6>
                <h4>₹ {{ $totalValue }}</h4>
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
                        <th>GRN No</th>
                        <th>Vendor</th>
                        <th>Medicine</th>
                        <th>Batch</th>
                        <th>Quantity</th>
                        <th>Purchase Rate</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>

<tbody>
@forelse($records as $r)
<tr>
    <td>{{ $r->grn_no }}</td>
    <td>{{ $r->vendor_name }}</td>
    <td>{{ $r->medicine_name }}</td>
    <td>{{ $r->batch_no }}</td>
    <td>{{ $r->qty }}</td>
    <td>₹ {{ $r->purchase_rate }}</td>
    <td>₹ {{ $r->amount }}</td>
    <td>{{ \Carbon\Carbon::parse($r->grn_date)->format('d-m-Y') }}</td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">No data found</td>
</tr>
@endforelse
</tbody>

            </table>
         <div class="mt-3">
               {{ $records->links() }}
            </div>
        </div>
    </div>

</div>

@endsection
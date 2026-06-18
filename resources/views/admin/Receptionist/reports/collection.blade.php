@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Collection Report</h4>
    </div>

    <!-- Filters -->
    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">

                <!-- Patient -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Patient Name</label>
                    <input type="text" name="patient"
       value="{{ request('patient') }}"
       class="form-control shadow-sm">
                </div>

                <!-- Payment Mode -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Payment Mode</label>
                  <select name="payment_mode" class="form-control shadow-sm">
    <option value="">All</option>
    <option value="CASH" {{ request('payment_mode') == 'CASH' ? 'selected' : '' }}>Cash</option>
    <option value="UPI" {{ request('payment_mode') == 'UPI' ? 'selected' : '' }}>UPI</option>
    <option value="CARD" {{ request('payment_mode') == 'CARD' ? 'selected' : '' }}>Card</option>
</select>
                </div>

                <!-- Date -->
                <div class="col-md-2">
                    <label class="form-label small text-muted">Date</label>
                    <input type="date" name="date"
       value="{{ request('date') }}"
       class="form-control shadow-sm">
                </div>

                <!-- Search -->
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 shadow-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                <!-- Reset -->
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('admin.receptionist.reports.collection') }}"
   class="btn btn-secondary w-100 shadow-sm">
   <i class="bi bi-arrow-counterclockwise"></i> 
</a>
                </div>

            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead>
                        <tr>
                            <th class="ps-3">Receipt No</th>
                            <th>Patient Name</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                  <tbody>
@forelse($collections as $bill)
<tr>

    <!-- Receipt -->
    <td class="ps-3">{{ $bill->receipt_no }}</td>

    <!-- Patient -->
    <td>
        {{ optional($bill->patient)->first_name }}
        {{ optional($bill->patient)->last_name }}
    </td>

    <!-- Amount -->
    <td class="text-success fw-bold">₹{{ $bill->amount }}</td>

    <!-- Payment Mode -->
    <td>
        <span class="badge 
            @if($bill->payment_mode == 'CASH') bg-success
            @elseif($bill->payment_mode == 'UPI') bg-primary
            @elseif($bill->payment_mode == 'CARD') bg-warning text-dark
            @else bg-secondary
            @endif">
            {{ $bill->payment_mode }}
        </span>
    </td>

    <!-- Date -->
    <td>{{ $bill->created_at->format('d-m-Y') }}</td>

</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted">No records found</td>
</tr>
@endforelse
</tbody>
                </table>
                <div class="p-3">
    {{ $collections->links() }}
</div>
            </div>

        </div>
    </div>

</div>

@endsection
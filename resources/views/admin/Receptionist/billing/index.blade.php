@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Billing Management</h4>
        <a href="{{ route('admin.billing.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle"></i> New Billing
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">

                <!-- Patient -->
                <div class="col-md-4">
                    <label class="form-label small text-muted">Patient Name</label>
                    <input type="text" name="patient"
                        value="{{ request('patient') }}"
                        class="form-control shadow-sm"
                        placeholder="Search Patient">
                </div>

                <!-- Date -->
                <div class="col-md-3">
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
                  <div class="col-md-2 d-flex align-items-end">
    <a href="{{ route('admin.billing.index') }}"
       class="btn btn-primary w-100 shadow-sm">
        <i class="bi bi-arrow-counterclockwise"></i>
    </a>
</div>
            </div>

  
        </div>
    </form>

    <!-- Success -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead >
                        <tr>
                            <th class="ps-3">Receipt No</th>
                            <th>Patient</th>
                            <th>Patient Code</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <th>Date</th>
                            <th class="text-center pe-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                       @foreach($billings as $bill)
<tr>
    <td>{{ $bill->receipt_no }}</td>

    <td>
        {{ $bill->patient->first_name ?? '' }}
        {{ $bill->patient->last_name ?? '' }}
    </td>

    <td>
        <span class="badge bg-light text-dark">
            {{ $bill->patient->patient_code ?? '' }}
        </span>
    </td>

    <td class="text-success fw-bold">₹{{ $bill->amount }}</td>

    <td><span class="badge bg-success">CASH</span></td>

    <td>{{ $bill->created_at->format('d-m-Y') }}</td>
<td class="text-center">
    <div class="d-flex justify-content-center gap-3">

        <!-- View -->
        <a href="{{ route('admin.billing.show', $bill->id) }}"
           class="text-info" title="View">
            <i class="bi bi-eye fs-5"></i>
        </a>

        <!-- Print -->
        <a href="{{ route('admin.billing.receipt', $bill->id) }}"
           class="text-success" title="Print">
            <i class="bi bi-printer fs-5"></i>
        </a>

    </div>
</td>
</tr>
@endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection
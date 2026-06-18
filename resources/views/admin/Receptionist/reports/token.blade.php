@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Token Report</h4>
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
                   <a href="{{ route('admin.receptionist.reports.token') }}"
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
                            <th class="ps-3">Token No</th>
                            <th>Patient Name</th>
                            <th>Doctor</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
@forelse($tokens as $token)
<tr>

    <!-- Token Number -->
    <td class="ps-3">
        <span class="badge bg-primary">
            {{ $token->token_number }}
        </span>
    </td>

    <!-- Patient -->
    <td>
        {{ optional($token->appointment->patient)->first_name }}
        {{ optional($token->appointment->patient)->last_name }}
    </td>

    <!-- Doctor -->
    <td>
        {{ optional($token->appointment->doctor)->name ?? '-' }}
    </td>

    <!-- Status -->
    <td>
        <span class="badge
            @if($token->status == 'COMPLETED') bg-success
            @elseif($token->status == 'WAITING') bg-warning text-dark
            @elseif($token->status == 'SKIPPED') bg-secondary
            @else bg-primary
            @endif">
            {{ $token->status }}
        </span>
    </td>

    <!-- Time -->
    <td>
        {{ $token->created_at->format('h:i A') }}
    </td>

    <!-- Date -->
    <td>
        {{ $token->created_at->format('d-m-Y') }}
    </td>

</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted">No records found</td>
</tr>
@endforelse
</tbody>

                </table>
                <div class="p-3">
    {{ $tokens->links() }}
</div>
            </div>

        </div>
    </div>

</div>

@endsection
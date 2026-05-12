@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Appointment Report</h4>
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

                <!-- Doctor -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Doctor</label>
                    <select name="doctor" class="form-control shadow-sm">
    <option value="">All</option>
    @foreach($doctors as $doctor)
        <option value="{{ $doctor->id }}"
            {{ request('doctor') == $doctor->id ? 'selected' : '' }}>
            {{ $doctor->name }}
        </option>
    @endforeach
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
                    <a href="{{ route('admin.receptionist.reports.appointment') }}"
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
                            <th>Patient Name</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
@forelse($appointments as $appointment)
<tr>

    <td>
        {{ $appointment->patient->first_name ?? '' }}
        {{ $appointment->patient->last_name ?? '' }}
    </td>

    <td>
        {{ $appointment->doctor->name ?? '-' }}
    </td>

    <td>
    {{ optional($appointment->department)->department_name ?? '-' }}
</td>

    <td>
        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
    </td>

    <td>
        <span class="badge 
            @if($appointment->appointment_status == 'Scheduled') bg-primary
            @elseif($appointment->appointment_status == 'Completed') bg-success
            @elseif($appointment->appointment_status == 'Cancelled') bg-danger
            @else bg-warning text-dark
            @endif">
            {{ $appointment->appointment_status }}
        </span>
    </td>

    <!-- Date -->
    <td>
        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y') }}
    </td>

</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted">No records found</td>
</tr>
@endforelse
</tbody>

                </table>
                <div class="p-3">
    {{ $appointments->links() }}
</div>
            </div>

        </div>
    </div>

</div>

@endsection
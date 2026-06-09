@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Registration Report</h4>
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
       class="form-control shadow-sm">
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

                <!-- Reset -->
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('admin.receptionist.reports.registration') }}"
   class="btn btn-secondary w-100 shadow-sm"> <i class="bi bi-arrow-counterclockwise"></i> 
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
                        <th class="ps-3">Patient No</th>
                        <th>Patient Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Mobile</th>
                        <th>Date</th> 
                        <th>Registered Time</th>
                    </tr>
                    </thead>

                   <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td class="ps-3">{{ $patient->patient_code }}</td>

                    <td>
                        {{ $patient->first_name }} {{ $patient->last_name }}
                    </td>

                    <td>
                        <span class="badge bg-{{ $patient->gender == 'Male' ? 'primary' : 'info' }}">
                            {{ $patient->gender }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
                    </td>

                    <td>{{ $patient->mobile }}</td>

                    <!--  Date Column -->
                    <td>{{ $patient->created_at->format('d-m-Y') }}</td>

                    <!-- Registered Time -->
                    <td>{{ $patient->created_at->format('h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No records found</td>
                </tr>
                @endforelse
                </tbody>

                </table>
                <div class="p-3">
    {{ $patients->links() }}
</div>
            </div>

        </div>
    </div>

</div>

@endsection
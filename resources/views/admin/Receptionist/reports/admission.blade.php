@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Admission Report</h4>
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

                <!-- Department -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Department</label>
                   <select name="department" class="form-control shadow-sm">
    <option value="">All</option>
    @foreach($departments as $dept)
        <option value="{{ $dept->id }}"
            {{ request('department') == $dept->id ? 'selected' : '' }}>
            {{ $dept->department_name }}
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
                    <a href="{{ route('admin.receptionist.reports.admission') }}"
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
                            <th class="ps-3">Admission No</th>
                            <th>Patient Name</th>
                            <th>Department</th>
                            <th>Bed</th>
                            <th>Admission Date</th>
                            <th>status</th>
                            <th>Advance Paid</th>
                        </tr>
                    </thead>

                    <tbody>
@forelse($admissions as $admission)
<tr>

    <!-- Admission ID -->
    <td class="ps-3">{{ $admission->admission_id }}</td>

    <!-- Patient -->
    <td>
        {{ optional($admission->patient)->first_name }}
        {{ optional($admission->patient)->last_name }}
    </td>

    <!-- Department -->
    <td>
        {{ optional($admission->department)->department_name ?? '-' }}
    </td>

    <!-- Bed -->
   <td>
    @if($admission->bed)
        {{ $admission->bed->bed_code }} 
        <small class="text-muted">
            ({{ $admission->bed->room_number }})
        </small>
    @else
        -
    @endif
</td>

    <!-- Admission Date -->
    <td>
        {{ \Carbon\Carbon::parse($admission->admission_date)->format('d-m-Y h:i A') }}
    </td>

    <!-- Status -->
    <td>
        <span class="badge
            @if($admission->status == 'active') bg-success
            @elseif($admission->status == 'discharged') bg-secondary
            @else bg-warning text-dark
            @endif">
            {{ ucfirst($admission->status) }}
        </span>
    </td>

    <!-- Advance Paid -->
    <td class="text-success fw-bold">
        ₹{{ $admission->payments->sum('amount') }}
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
    {{ $admissions->links() }}
</div>
            </div>

        </div>
    </div>

</div>

@endsection
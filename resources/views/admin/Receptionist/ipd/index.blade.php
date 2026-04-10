@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>IPD Admissions</h4>
        <a href="{{ route('admin.receptionist.ipd.create') }}" class="btn btn-primary">
            + Add Admission
        </a>
    </div>

    <!-- Filter Section (Optional but good UI) -->
   <form method="GET" action="{{ route('admin.receptionist.ipd.index') }}">
<div class="card mb-3">
    <div class="card-body">
        <div class="row">

            <div class="col-md-3">
                <input type="date" name="date" value="{{ request('date') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="discharged" {{ request('status') == 'discharged' ? 'selected' : '' }}>Discharged</option>
                </select>
            </div>

            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="form-control" placeholder="Search Patient">
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-secondary w-100">Search</button>

                <a href="{{ route('admin.receptionist.ipd.index') }}" 
                   class="btn btn-danger w-100">Reset</a>
            </div>

        </div>
    </div>
</div>
</form>

    <!-- Table -->
    <div class="card">
        <div class="card-header">
            <strong>Admission List</strong>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">
                <thead >
                    <tr>
                        <th>#</th>
                        <th>Admission ID</th>
                        <th>Patient Name</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Ward/Bed</th>
                        <th>Admission Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

<tbody>

@foreach($ipds as $key => $ipd)
<tr>
    <td>{{ $key + 1 }}</td>

    <td>{{ $ipd->admission_id }}</td>

    <td>
        {{ $ipd->patient->first_name ?? '' }} 
        {{ $ipd->patient->last_name ?? '' }}
    </td>

    <td>{{ $ipd->doctor->name ?? '-' }}</td>

    <td>{{ $ipd->department->department_name ?? '-' }}</td>

    <td>
        {{ $ipd->ward->ward_name ?? '-' }} /
        {{ $ipd->bed->bed_code ?? '-' }}
    </td>

    <td>{{ \Carbon\Carbon::parse($ipd->admission_date)->format('d-m-Y') }}</td>

    <td>
        @if($ipd->status == 'active')
            <span class="badge bg-success">Active</span>
        @else
            <span class="badge bg-danger">Discharged</span>
        @endif
    </td>

    <td>

        <!-- View -->
        <a href="{{ route('admin.receptionist.ipd.view', $ipd->id) }}">
            <i class="fas fa-eye"></i>
        </a>

        <!-- Edit -->
       @if($ipd->status == 'discharged')
    <button  disabled>
        <i class="fas fa-edit"></i>
    </button>
@else
    <a href="{{ route('admin.receptionist.ipd.edit', $ipd->id) }}">
        <i class="fas fa-edit"></i>
    </a>
@endif
        <!-- Print -->
        <a href="{{ route('admin.receptionist.ipd.print', $ipd->id) }}">
            <i class="fas fa-print"></i>
        </a>

    </td>
</tr>
@endforeach

</tbody>
            </table>
        <div class="d-flex justify-content-end mt-3">
    {{ $ipds->links() }}
</div>
        </div>
    </div>

</div>

@endsection
{{-- resources/views/admin/pharmacy/prescriptions/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Prescription Management')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Prescription Management</h4>
            <small class="text-muted">Pharmacy → Prescriptions</small>
        </div>

        <div>
            <a href="{{ route('admin.prescriptions.offline.create') }}" class="btn btn-primary">
                <i class="feather-plus"></i> Add Offline Prescription
            </a>
        </div>
    </div>


    <!-- Search Filters -->
    <div class="card mb-3">
        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-3">
                        <label>Prescription Number</label>
                        <input type="text" name="prescription_no" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Patient Name</label>
                        <input type="text" name="patient_name" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Doctor Name</label>
                        <input type="text" name="doctor_name" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">All</option>
                            <option>Pending</option>
                            <option>Verified</option>
                            <option>Dispensed</option>
                        </select>
                    </div>

                </div>

                <div class="mt-3">

                    <button class="btn btn-success">
                        <i class="feather-search"></i> Search
                    </button>

                    <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </form>

        </div>
    </div>



    <!-- Prescription Table -->
    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Prescription No</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th width="180">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($prescriptions as $key => $prescription)

                        <tr>

                            <td>{{ $key+1 }}</td>

                            <td>
                                {{ $prescription->prescription_number }}
                            </td>

                            <td>
                                {{ $prescription->patient->name ?? '-' }}
                            </td>

                            <td>
                                {{ $prescription->doctor->name ?? 'Offline Doctor' }}
                            </td>

                            <td>
                                {{ $prescription->prescription_date }}
                            </td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $prescription->prescription_type }}
                                </span>
                            </td>

                            <td>

                                @if($prescription->status == 'Pending')
                                <span class="badge bg-warning">Pending</span>

                                @elseif($prescription->status == 'Verified')
                                <span class="badge bg-primary">Verified</span>

                                @elseif($prescription->status == 'Dispensed')
                                <span class="badge bg-success">Dispensed</span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.prescriptions.show',$prescription->id) }}"
                                   class="btn btn-sm btn-info">
                                   View
                                </a>

                                <a href="{{ route('admin.prescriptions.dispense',$prescription->id) }}"
                                   class="btn btn-sm btn-success">
                                   Dispense
                                </a>

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
@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">
    <h4>Discharge Summary List</h4>
</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>
<tr>
    <th>#</th>
    <th>Patient Name</th>
    <th>Admission ID</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@forelse($ipds as $key => $ipd)

<tr>
    <td>{{ $ipds->firstItem() + $key }}</td>

    <td>
        {{ $ipd->patient->first_name ?? '-' }} 
        {{ $ipd->patient->last_name ?? '' }}
    </td>

    <td>{{ $ipd->admission_id }}</td>

    <td>
        <span class="badge bg-success">Discharged</span>
    </td>

    <td>
        <a href="{{ route('admin.patient.portal.discharge', $ipd->id) }}"
           class="btn btn-info btn-sm">
           View
        </a>

        <a href="{{ route('admin.patient.portal.doctor.notes', $ipd->id) }}"
                class="btn btn-warning btn-sm">
                Notes
                </a>
    </td>
</tr>

@empty

<tr>
    <td colspan="5" class="text-center">No Discharge Records</td>
</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">
    {{ $ipds->links() }}
</div>

</div>
</div>
</div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Deleted Rate Employee Mappings')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>

        <h5 class="mb-1">
            Deleted Rate Employee Mappings
        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item active">
                Deleted Rate Employee Mappings
            </li>

        </ul>

    </div>

    <a href="{{ route('hr.payroll.rate-employee-mapping.index') }}"
       class="btn btn-light">

        Back

    </a>

</div>



<div class="row">
<div class="col-12">

<div class="card stretch stretch-full">

<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead>

<tr>

<th>Employee</th>
<th>Rate Type</th>
<th>Rate Value</th>
<th class="text-end">Action</th>

</tr>

</thead>


<tbody>

@forelse($rateMappings as $item)

<tr>

<td>

<span class="badge bg-soft-primary text-primary">

{{ $item->employee->name ?? '-' }}

</span>

</td>


<td>

{{ $item->rate_type }}

</td>


<td>

{{ $item->base_rate_value ?? $item->multiplier_value ?? '-' }}

</td>


<td class="text-end">

<div class="d-flex gap-2 justify-content-end">

<!-- RESTORE -->

<form action="{{ route('hr.payroll.rate-employee-mapping.restore', $item->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <button type="submit"
            class="btn btn-success btn-sm">
        RESTORE
    </button>

</form>



<!-- PERMANENT DELETE -->

<form action="{{ route('hr.payroll.rate-employee-mapping.forceDelete', $item->id) }}"
      method="POST"
      onsubmit="return confirm('Delete permanently?')">

@csrf
@method('DELETE')

<button type="submit"
        class="btn btn-danger btn-sm">

DELETE

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td colspan="4"
    class="text-center text-muted">

No Deleted Records Found

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

@endsection
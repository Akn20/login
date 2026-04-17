@extends('layouts.admin') 

@section('page-title', 'Rate Employee Mapping | ' . config('app.name'))

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div class="page-header-left">

        <h5 class="m-b-10 mb-1">
            Rate Employee Mapping Master
        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item active">
                Rate Employee Mapping List
            </li>

        </ul>

    </div>


    <div class="d-flex gap-2 align-items-center">

        <!-- Add Button -->

        <a href="{{ route('hr.payroll.rate-employee-mapping.create') }}"
           class="btn btn-primary">

            <i class="feather-plus me-1"></i>
            Add Rate Mapping

        </a>


        <!-- Deleted -->

        <a href="{{ route('hr.payroll.rate-employee-mapping.deleted') }}"
           class="btn btn-danger">

            Deleted Records

        </a>

    </div>

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
<th class="text-end">Actions</th>

</tr>

</thead>



<tbody>

@forelse($rateMappings ?? [] as $item)

<tr>


<!-- Employee -->

<td>

<span class="badge bg-soft-primary text-primary">

{{ optional($item->employee)->name ?? '-' }}

</span>

</td>



<!-- Rate Type -->

<td>

{{ $item->rate_type ?? '-' }}

</td>



<!-- Rate Value -->

<td>

<span class="badge bg-soft-info text-info">

@if($item->rate_type === 'Flat')

{{ $item->base_rate_value ?? '-' }}

@elseif($item->rate_type === 'Multiplier')

{{ $item->multiplier_value ?? '-' }}

@else

-

@endif

</span>

</td>



<!-- Actions -->

<td class="text-end">

<div class="d-flex gap-2 justify-content-end">


<!-- View -->

<a href="{{ route('hr.payroll.rate-employee-mapping.show', $item->id) }}"
   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
   title="View">

<i class="feather-eye"></i>

</a>



<!-- Edit -->

<a href="{{ route('hr.payroll.rate-employee-mapping.edit', $item->id) }}"
   class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
   title="Edit">

<i class="feather-edit-2"></i>

</a>



<!-- Delete -->

<form action="{{ route('hr.payroll.rate-employee-mapping.destroy', $item->id) }}"
      method="POST"
      onsubmit="return confirm('Are you sure you want to delete this record?');">

@csrf
@method('DELETE')

<button type="submit"
        class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
        title="Delete">

<i class="feather-trash-2"></i>

</button>

</form>


</div>

</td>

</tr>



@empty

<tr>

<td colspan="4"
    class="text-center text-muted">

No records found

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
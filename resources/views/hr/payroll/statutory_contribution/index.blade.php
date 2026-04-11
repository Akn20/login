@extends('layouts.admin') 

@section('page-title', 'Statutory Contribution | ' . config('app.name'))

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div class="page-header-left">

        <h5 class="m-b-10 mb-1">
            Statutory Contribution Master
        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item active">
                Statutory Contribution List
            </li>

        </ul>

    </div>



    <div class="d-flex gap-2 align-items-center">

        <!-- Add Button -->

        <a href="{{ route('hr.payroll.statutory-contribution.create') }}"
           class="btn btn-primary">

            <i class="feather-plus me-1"></i>
            Add Contribution

        </a>



        <!-- Deleted Button -->

        <a href="{{ route('hr.payroll.statutory-contribution.deleted') }}"
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

<th>Contribution Code</th>

<th>Contribution Name</th>

<th>Statutory Category</th>

<th>Status</th>

<th class="text-end">Actions</th>

</tr>

</thead>



<tbody>

@forelse($contributions as $item)

<tr>

<!-- Contribution Code -->

<td>

<span class="badge bg-soft-primary text-primary">

{{ $item->contribution_code }}

</span>

</td>



<!-- Contribution Name -->

<td>

{{ $item->contribution_name }}

</td>



<!-- Category -->

<td>

{{ $item->statutory_category }}

</td>



<!-- Status -->

<td>

@if($item->status == 'Active')

<span class="text-success">

Active

</span>

@else

<span class="text-danger">

Inactive

</span>

@endif

</td>



<!-- Actions -->

<td class="text-end">

<div class="d-flex gap-2 justify-content-end">

    <!-- View -->

    <a href="{{ route('hr.payroll.statutory-contribution.show', $item->id) }}"
       class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
       title="View">

        <i class="feather-eye"></i>

    </a>



    <!-- Edit -->

    <a href="{{ route('hr.payroll.statutory-contribution.edit', $item->id) }}"
       class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
       title="Edit">

        <i class="feather-edit-2"></i>

    </a>



    <!-- Delete -->

    <form action="{{ route('hr.payroll.statutory-contribution.destroy', $item->id) }}"
          method="POST"
          onsubmit="return confirm('Move to trash?')">

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

<td colspan="5"
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
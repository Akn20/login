@extends('layouts.admin')

@section('page-title', 'Deleted Statutory Contributions')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>

        <h5 class="mb-1">
            Deleted Statutory Contributions
        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item active">
                Deleted Contributions
            </li>

        </ul>

    </div>

    <a href="{{ route('hr.payroll.statutory-contribution.index') }}"
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

<th>Contribution Code</th>
<th>Contribution Name</th>
<th>Statutory Category</th>
<th>Status</th>
<th class="text-end">Action</th>

</tr>

</thead>


<tbody>

@forelse($contributions as $item)

<tr>

<td>
<span class="badge bg-soft-primary text-primary">
{{ $item->contribution_code }}
</span>
</td>


<td>
{{ $item->contribution_name }}
</td>


<td>
{{ $item->statutory_category }}
</td>


<td>

@if($item->status == 'Active')

<span class="text-success">Active</span>

@else

<span class="text-danger">Inactive</span>

@endif

</td>


<td class="text-end">

<div class="d-flex gap-2 justify-content-end">

<!-- RESTORE -->

<form action="{{ route('hr.payroll.statutory-contribution.restore', $item->id) }}"
      method="POST">

@csrf

<button type="submit"
        class="btn btn-success btn-sm">

RESTORE

</button>

</form>



<!-- PERMANENT DELETE -->

<form action="{{ route('hr.payroll.statutory-contribution.forceDelete', $item->id) }}"
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

<td colspan="5"
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
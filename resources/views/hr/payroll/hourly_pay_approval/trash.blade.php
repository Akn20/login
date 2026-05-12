@extends('layouts.admin')

@section('title','Trash - Hourly Pay Approval')

@section('content')

{{-- SUCCESS MESSAGE --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>
</div>
@endif


<div class="page-header mb-4 d-flex justify-content-between align-items-center">

<h5>
    Trash - Hourly Pay Approval
</h5>

<a href="{{ route('hr.payroll.hourly-pay-approval.index') }}"
   class="btn btn-secondary btn-sm">

    Back

</a>

</div>


<div class="card">

<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead>

<tr>

<th>#</th>
<th>Employee</th>
<th>Work Type</th>
<th>Date</th>
<th class="text-center">Action</th>

</tr>

</thead>

<tbody>

@forelse($entries as $index => $entry)

<tr>

<td>{{ $index + 1 }}</td>

<td>{{ $entry->staff->name ?? '-' }}</td>

<td>{{ $entry->work_type_code }}</td>

<td>{{ $entry->attendance_date }}</td>

<td class="text-center">

<div class="d-flex justify-content-center gap-2">

{{-- RESTORE --}}
<form method="POST"
      action="{{ route('hr.payroll.hourly-pay-approval.restore',$entry->id) }}">

    @csrf
    @method('PUT')

    <button type="submit"
            class="btn btn-success btn-sm">

        <i class="feather-refresh-cw me-1"></i>
        Restore

    </button>

</form>


{{-- PERMANENT DELETE --}}
<form method="POST"
      action="{{ route('hr.payroll.hourly-pay-approval.force-delete',$entry->id) }}"
      onsubmit="return confirm('Delete permanently? This cannot be undone.')">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-danger btn-sm">

        <i class="feather-trash-2 me-1"></i>
        Delete

    </button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td colspan="5"
class="text-center text-muted py-4">

No deleted records found

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection
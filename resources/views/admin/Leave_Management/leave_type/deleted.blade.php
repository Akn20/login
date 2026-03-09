@extends('layouts.admin')

@section('page-title', 'Deleted Leave Types | ' . config('app.name'))
@section('title', 'Deleted Leave Types')

@section('content')

<div class="page-header mb-4">
    <h5>
        <i class="feather-trash-2 me-2"></i>Deleted Leave Types
    </h5>
</div>

<div class="card stretch stretch-full">
<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead>
<tr>
    <th>#</th>
    <th>Leave Type</th>
    <th>Deleted At</th>
    <th class="text-end">Actions</th>
</tr>
</thead>

<tbody>

@if(isset($leaveTypes) && $leaveTypes->count())

    @foreach($leaveTypes as $index => $leave)

    <tr>
        <td>{{ $index + 1 }}</td>

        <td>{{ $leave->display_name }}</td>

        <td>{{ $leave->deleted_at }}</td>

        <td class="text-end">

            <div class="d-flex justify-content-end gap-2">

                {{-- RESTORE --}}
                <form action="{{ route('admin.leave-type.restore', $leave->id) }}"
                      method="POST">
                    @csrf

                    <button type="submit"
                        class="btn btn-outline-success btn-icon rounded-circle">
                        <i class="feather-rotate-ccw"></i>
                    </button>
                </form>

                {{-- PERMANENT DELETE --}}
                <form action="{{ route('admin.leave-type.forceDelete', $leave->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete permanently?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="btn btn-outline-danger btn-icon rounded-circle">
                        <i class="feather-trash"></i>
                    </button>
                </form>

            </div>

        </td>
    </tr>

    @endforeach

@else

<tr>
    <td colspan="4" class="text-center py-4">
        No Deleted Leave Types Found
    </td>
</tr>

@endif

</tbody>

</table>

</div>
</div>
</div>

@endsection
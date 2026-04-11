@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h5>Preventive Maintenance</h5>

    <div class="ms-auto d-flex gap-2">

        <!-- SEARCH -->
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Search..."
                value="{{ request('search') }}">
            <button class="btn btn-light ms-2">
                <i class="feather-search"></i>
            </button>
        </form>

        <a href="{{ route('admin.laboratory.preventive.create') }}" class="btn btn-primary">
            New
        </a>

        <a href="{{ route('admin.laboratory.preventive.deleted') }}" class="btn btn-danger">
            Deleted
        </a>

    </div>
</div>

<div class="card">
<div class="card-body p-0">

<table class="table table-hover">

<thead>
<tr>
    <th>#</th>
    <th>Equipment</th>
    <th>Frequency</th>
    <th>Next Date</th>
    <th>Technician</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($records as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->equipment->name }}</td>
    <td>{{ $item->frequency }}</td>
    <td>{{ $item->next_maintenance_date }}</td>
    <td>{{ $item->technician }}</td>

    <td>
        <div class="d-flex gap-2">

            <!-- VIEW -->
            <a href="{{ route('admin.laboratory.preventive.show', $item->id) }}"
                class="btn btn-outline-secondary btn-icon rounded-circle">
                <i class="feather-eye"></i>
            </a>

            <!-- EDIT -->
            <a href="{{ route('admin.laboratory.preventive.edit', $item->id) }}"
                class="btn btn-outline-secondary btn-icon rounded-circle">
                <i class="feather-edit-2"></i>
            </a>

            <!-- DELETE -->
            <form method="POST" action="{{ route('admin.laboratory.preventive.destroy', $item->id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger btn-icon rounded-circle">
                    <i class="feather-trash-2"></i>
                </button>
            </form>

        </div>
    </td>

</tr>
@empty
<tr>
<td colspan="6" class="text-center">No Records</td>
</tr>
@endforelse

</tbody>

</table>

</div>
</div>

@endsection

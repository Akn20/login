@extends('layouts.admin')

@section('page-title','Comp-Off | '.config('app.name'))
@section('title','Comp-Off')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center w-100">

        <div class="page-header-title">
            <h5 class="m-b-10">
                <i class="feather-calendar me-2"></i>Comp-Off
            </h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Leave Management</li>
                <li class="breadcrumb-item">Comp-Off</li>
            </ul>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('hr.compoffs.deleted') }}" class="btn btn-light">
                <i class="feather-trash-2 me-2"></i> Deleted Records
            </a>
            <a href="{{ route('hr.compoffs.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i> Add Comp-Off
            </a>
        </div>

    </div>
</div>

<div class="card stretch stretch-full">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Worked On</th>
                        <th>Comp-Off Credited</th>
                        <th>Expiry Date</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($compoffs as $compoff)
                    <tr>
                        <td>{{ $compoff->employee->name ?? '-' }}</td>
                        <td>{{ $compoff->worked_on }}</td>
                        <td>{{ $compoff->comp_off_credited }}</td>
                        <td>{{ $compoff->expiry_date ?? '-' }}</td>

                        <td>
                            {{-- Edit & Delete side by side --}}
                            <div class="d-flex align-items-center gap-2">

                                <a href="{{ route('hr.compoffs.edit', $compoff->id) }}"
                                   class="btn btn-sm btn-light"
                                   title="Edit">
                                    <i class="feather-edit"></i>
                                </a>

                                <form action="{{ route('hr.compoffs.delete', $compoff->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-light"
                                            title="Delete"
                                            onclick="return confirm('Delete this record?')">
                                        <i class="feather-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No records found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
@extends('layouts.admin')

@section('page-title','Comp-Off Deleted Records | '.config('app.name'))
@section('title','Comp-Off Deleted Records')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center w-100">

        <div class="page-header-title">
            <h5 class="m-b-10">
                <i class="feather-trash-2 me-2"></i>Comp-Off — Deleted Records
            </h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Leave Management</li>
                <li class="breadcrumb-item">
                    <a href="{{ route('hr.compoffs.index') }}">Comp-Off</a>
                </li>
                <li class="breadcrumb-item">Deleted Records</li>
            </ul>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('hr.compoffs.index') }}" class="btn btn-light">
                <i class="feather-arrow-left me-2"></i> Back to List
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
                        <th>Deleted At</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($compoffs as $compoff)
                    <tr>
                        <td>{{ $compoff->employee->name ?? '-' }}</td>
                        <td>{{ $compoff->worked_on }}</td>
                        <td>{{ $compoff->comp_off_credited }}</td>
                        <td>{{ $compoff->expiry_date ?? '-' }}</td>
                        <td>{{ $compoff->deleted_at->format('d M Y') }}</td>

                        <td>
                            <div class="d-flex align-items-center gap-2">

                                {{-- Restore --}}
                                <form action="{{ route('hr.compoffs.restore', $compoff->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm btn-light"
                                            title="Restore"
                                            onclick="return confirm('Restore this record?')">
                                        <i class="feather-rotate-ccw"></i>
                                    </button>
                                </form>

                                {{-- Force Delete --}}
                                <form action="{{ route('hr.compoffs.forceDelete', $compoff->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-light"
                                            title="Delete Permanently"
                                            onclick="return confirm('Permanently delete this record? This cannot be undone.')">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No deleted records found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
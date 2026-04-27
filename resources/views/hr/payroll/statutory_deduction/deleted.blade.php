@extends('layouts.admin')

@section('page-title', 'Deleted Statutory Deductions')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h5 class="mb-1">Deleted Statutory Deductions</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Deleted Records</li>
        </ul>
    </div>

    <a href="{{ route('hr.payroll.statutory-deduction.index') }}"
       class="btn btn-light">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $row)
                        <tr>

                            <td>{{ $row->statutory_code }}</td>

                            <td>{{ $row->statutory_name }}</td>

                            <td>
                                <span class="badge bg-soft-primary text-primary">
                                    {{ $row->statutory_category }}
                                </span>
                            </td>

                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">

                                    <!-- Restore -->
                                    <form action="{{ route('hr.payroll.statutory-deduction.restore', $row->id) }}"
                                          method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-outline-success btn-icon rounded-circle btn-sm"
                                                title="Restore">
                                            <i class="feather-refresh-ccw"></i>
                                        </button>
                                    </form>

                                    <!-- Permanent Delete -->
                                    <form action="{{ route('hr.payroll.statutory-deduction.forceDelete', $row->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Permanently delete this record?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                                                title="Delete Permanently">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No Deleted Records Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="p-3">
                {{ $records->links() }}
            </div>

        </div>

    </div>
</div>

@endsection
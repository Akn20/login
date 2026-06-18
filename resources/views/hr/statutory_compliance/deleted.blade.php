@extends('layouts.admin')

@section(
    'page-title',
    'Deleted Statutory Compliance | ' . config('app.name')
)

@section('content')

<div class="nxl-content">

    {{-- Page Header --}}
    <div class="page-header mb-4 d-flex justify-content-between align-items-center">

        <div>

            <h5 class="mb-1">
                Deleted Statutory Compliance Records
            </h5>

        </div>

        <a
            href="{{ route('hr.statutory-compliance.index') }}"
            class="btn btn-light"
        >
            Back
        </a>

    </div>

    {{-- Card --}}
    <div class="card">

        <div class="card-body">

            {{-- Success Message --}}
            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Employee ID</th>

                            <th>Employee Name</th>

                            <th>Department</th>

                            <th>Status</th>

                            <th
                                class="text-end"
                                width="180"
                            >
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($records as $key => $record)

                            <tr>

                                <td>
                                    {{ $records->firstItem() + $key }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $record->employee_id }}
                                </td>

                                <td>
                                    {{ $record->employee_name }}
                                </td>

                                <td>
                                    {{ $record->department }}
                                </td>

                                <td>

                                    <span class="badge bg-soft-danger text-danger">
                                        Deleted
                                    </span>

                                </td>

                                {{-- Actions --}}
                                <td class="text-end">

                                    <div class="hstack gap-2 justify-content-end">

                                        {{-- Restore --}}
                                        <form
                                            action="{{ route('hr.statutory-compliance.restore', $record->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Restore this record?');"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="avatar-text avatar-md action-icon"
                                                title="Restore"
                                            >
                                                <i class="feather-rotate-ccw"></i>
                                            </button>

                                        </form>

                                        {{-- Permanent Delete --}}
                                        <form
                                            action="{{ route('hr.statutory-compliance.forceDelete', $record->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Permanently delete this record?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="avatar-text avatar-md action-icon action-delete"
                                                title="Permanent Delete"
                                            >
                                                <i class="feather-trash-2"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-4"
                                >
                                    No Deleted Records Found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            <div class="mt-3">

                {{ $records->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
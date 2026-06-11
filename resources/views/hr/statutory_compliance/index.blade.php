@extends('layouts.admin')

@section(
    'page-title',
    'Statutory Compliance | ' . config('app.name')
)

@section('content')

<div class="nxl-content">

    <div class="page-header mb-4 d-flex justify-content-between align-items-center">

        <div>

            <h5 class="mb-1">
                Statutory Compliance
            </h5>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('hr.statutory-compliance.deleted') }}"
                class="btn btn-light"
            >
                Deleted Records
            </a>

            <a
                href="{{ route('hr.statutory-compliance.create') }}"
                class="btn btn-primary"
            >
                Add Record
            </a>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

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

                            <th>Contract Status</th>

                            <th>License Status</th>

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

                                {{-- Contract Status --}}
                                <td>

                                    @if($record->contract_status)

                                        <span class="badge bg-soft-info text-info">
                                            {{ $record->contract_status }}
                                        </span>

                                    @else

                                        -

                                    @endif

                                </td>

                                {{-- License Status --}}
                                <td>

                                    @if($record->license_status)

                                        <span class="badge bg-soft-warning text-warning">
                                            {{ $record->license_status }}
                                        </span>

                                    @else

                                        -

                                    @endif

                                </td>

                                {{-- Main Status --}}
                                <td>

                                    @if($record->status == 'Active')

                                        <span class="badge bg-soft-success text-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-soft-danger text-danger">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                {{-- Actions --}}
                                <td class="text-end">

                                    <div class="hstack gap-2 justify-content-end">

                                        {{-- View --}}
                                        <a
                                            href="{{ route('hr.statutory-compliance.show', $record->id) }}"
                                            class="avatar-text avatar-md action-icon"
                                            title="View"
                                        >
                                            <i class="feather-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('hr.statutory-compliance.edit', $record->id) }}"
                                            class="avatar-text avatar-md action-icon action-edit"
                                            title="Edit"
                                        >
                                            <i class="feather-edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('hr.statutory-compliance.delete', $record->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this record?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="avatar-text avatar-md action-icon action-delete"
                                                title="Delete"
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
                                    colspan="8"
                                    class="text-center py-4"
                                >
                                    No Records Found
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
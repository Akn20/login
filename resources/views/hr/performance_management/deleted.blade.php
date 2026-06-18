@extends('layouts.admin')

@section(
    'page-title',
    'Deleted Performance Reviews | ' . config('app.name')
)

@section('content')

<div class="nxl-content">

    <div class="page-header d-flex align-items-center justify-content-between">

        <div class="page-header-left">

            <h5 class="mb-0">
                Deleted Performance Reviews
            </h5>

        </div>

        <div class="page-header-right d-flex gap-2">

            <a
                href="{{ route('hr.performance-management.index') }}"
                class="btn btn-neutral"
            >
                Back
            </a>

        </div>

    </div>

    <div class="main-content">

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

        <div class="card">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                            <tr>

                                <th>S.No</th>

                                <th>Employee ID</th>

                                <th>Employee Name</th>

                                <th>Department</th>

                                <th>Reviewer</th>

                                <th>Rating</th>

                                <th>Status</th>

                                <th>Deleted At</th>

                                <th class="text-end">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($records as $i => $row)

                                <tr>

                                    <td>
                                        {{ $records->firstItem() + $i }}
                                    </td>

                                    <td>
                                        {{ $row->employee_id }}
                                    </td>

                                    <td>
                                        {{ $row->employee_name }}
                                    </td>

                                    <td>
                                        {{ $row->department }}
                                    </td>

                                    <td>
                                        {{ $row->reviewer_name }}
                                    </td>

                                    <td>
                                        {{ $row->rating }}
                                    </td>

                                    <td>

                                        @if($row->review_status == 'Pending')

                                            <span class="badge bg-soft-warning text-warning">
                                                Pending
                                            </span>

                                        @elseif($row->review_status == 'Reviewed')

                                            <span class="badge bg-soft-info text-info">
                                                Reviewed
                                            </span>

                                        @elseif($row->review_status == 'Approved')

                                            <span class="badge bg-soft-success text-success">
                                                Approved
                                            </span>

                                        @endif

                                    </td>

                                    <td>
                                        {{ optional($row->deleted_at)->format('d-m-Y H:i') }}
                                    </td>

                                    <td class="text-end">

                                        <div class="hstack gap-2 justify-content-end">

                                            {{-- Restore --}}
                                            <form
                                                action="{{ route('hr.performance-management.restore', $row->id) }}"
                                                method="POST"
                                                class="m-0 p-0"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="avatar-text avatar-md action-icon action-restore"
                                                    title="Restore"
                                                >

                                                    <i class="feather-rotate-ccw"></i>

                                                </button>

                                            </form>

                                            {{-- Permanent Delete --}}
                                            <form
                                                action="{{ route('hr.performance-management.forceDelete', $row->id) }}"
                                                method="POST"
                                                class="m-0 p-0"
                                                onsubmit="return confirm('This will permanently delete the record. Continue?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="avatar-text avatar-md action-icon action-delete"
                                                    title="Delete Permanently"
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
                                        colspan="9"
                                        class="text-center py-4"
                                    >
                                        No deleted records found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                <div class="p-3">

                    {{ $records->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
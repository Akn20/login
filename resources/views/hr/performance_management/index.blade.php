@extends('layouts.admin')

@section(
    'page-title',
    'Performance Management | ' . config('app.name')
)

@section('content')

<div class="nxl-content">

    <div class="page-header">

        <div class="page-header d-flex align-items-center">

            <div class="page-header-title">

                <h5 class="m-b-10">
                    Performance Management
                </h5>

            </div>

            <ul class="breadcrumb">

                <li class="breadcrumb-item">
                    HR
                </li>

                <li class="breadcrumb-item">
                    Performance Management
                </li>

            </ul>

        </div>

        <div class="page-header-right ms-auto d-flex gap-2">

            <a
                href="{{ route('hr.performance-management.create') }}"
                class="btn btn-neutral"
            >
                Add Review
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

        <div class="row">

            <div class="col-lg-12">

                <div class="card stretch stretch-full">

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

                                            <td class="text-end">

                                                <div class="hstack gap-2 justify-content-end">

                                                    <a
                                                        href="#"
                                                        class="avatar-text avatar-md action-icon"
                                                    >
                                                        <i class="feather-eye"></i>
                                                    </a>

                                                    <a
                                                        href="#"
                                                        class="avatar-text avatar-md action-icon action-edit"
                                                    >
                                                        <i class="feather-edit"></i>
                                                    </a>

                                                    <a
                                                        href="#"
                                                        class="avatar-text avatar-md action-icon action-delete"
                                                    >
                                                        <i class="feather-trash-2"></i>
                                                    </a>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="8"
                                                class="text-center py-4"
                                            >
                                                No records found.
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        <div class="mt-3 px-3 pb-3">

                            {{ $records->links() }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
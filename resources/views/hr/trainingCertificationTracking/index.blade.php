@extends('layouts.admin')

@section('page-title', 'Training & Certification Tracking | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">

        <div class="page-header d-flex align-items-center">

            <div class="page-header-title">

                <h5 class="m-b-10">
                    Training & Certification Tracking
                </h5>

            </div>

            <ul class="breadcrumb">

                <li class="breadcrumb-item">
                    HR
                </li>

                <li class="breadcrumb-item">
                    Training & Certification Tracking
                </li>

            </ul>

        </div>

        <div class="page-header-right ms-auto d-flex gap-2">

            <a
                href="{{ route('hr.training-certification-tracking.create') }}"
                class="btn btn-neutral"
            >
                Add Record
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

                                        <th>Training Code</th>

                                        <th>Training Name</th>

                                        <th>Certification</th>

                                        <th>Expiry Date</th>

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

                                            <td class="fw-semibold">
                                                {{ $row->employee_id }}
                                            </td>

                                            <td>
                                                {{ $row->employee_name }}
                                            </td>

                                            <td>
                                                {{ $row->training_code }}
                                            </td>

                                            <td>
                                                {{ $row->training_name }}
                                            </td>

                                            <td>
                                                {{ $row->certification_name }}
                                            </td>

                                            <td>
                                                {{ $row->expiry_date }}
                                            </td>

                                            <td>

                                                @if($row->status == 'Active')

                                                    <span class="badge bg-soft-success text-success">
                                                        Active
                                                    </span>

                                                @elseif($row->status == 'Expired')

                                                    <span class="badge bg-soft-danger text-danger">
                                                        Expired
                                                    </span>

                                                @else

                                                    <span class="badge bg-soft-warning text-warning">
                                                        {{ $row->status }}
                                                    </span>

                                                @endif

                                            </td>

                                            <td class="text-end">

                                                <div class="hstack gap-2 justify-content-end">

                                                    {{-- View --}}
                                                    <a
                                                        href="#"
                                                        class="avatar-text avatar-md action-icon"
                                                        title="View"
                                                    >
                                                        <i class="feather-eye"></i>
                                                    </a>

                                                    {{-- Edit --}}
                                                    <a
                                                        href="#"
                                                        class="avatar-text avatar-md action-icon action-edit"
                                                        title="Edit"
                                                    >
                                                        <i class="feather-edit"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <form
                                                        action="#"
                                                        method="POST"
                                                        class="d-inline"
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
                                                colspan="9"
                                                class="text-center py-4"
                                            >
                                                No records found.
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

        </div>

    </div>

</div>

@endsection
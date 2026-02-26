@extends('layouts.admin')

@section('page-title', 'Pharmacy | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Vendor Management</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Pharmacy</li>
                    <li class="breadcrumb-item">Vendors</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.vendors.trash') }}" class="btn btn-neutral">
                    Deleted Records
                </a>

                <a href="{{ route('admin.vendors.create') }}" class="btn btn-neutral">
                    Add Vendor
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Vendor Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($vendors as $index => $vendor)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $vendor->vendor_name }}</td>
                                                <td>{{ $vendor->phone_number ?? '-' }}</td>
                                                <td>{{ $vendor->email ?? '-' }}</td>
                                                <td>{{ $vendor->address ?? '-' }}</td>

                                                <td>
                                                    @if($vendor->status == 'Active')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">

                                                        {{-- View --}}
                                                        <a href="{{ route('admin.vendors.show', $vendor->id) }}"
                                                            class="avatar-text avatar-md action-icon">
                                                            <i class="feather-eye"></i>
                                                        </a>

                                                        {{-- Edit --}}
                                                        <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        {{-- Delete --}}
                                                        <form action="{{ route('admin.vendors.delete', $vendor->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this vendor?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete">
                                                                <i class="feather-trash-2"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
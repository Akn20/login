@extends('layouts.admin')

@section('page-title', 'Return Management | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Return Management</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Returns</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.returns.trash') }}" class="btn btn-neutral">
                Deleted Records
            </a>

            <a href="{{ route('admin.returns.create') }}" class="btn btn-neutral">
                Add Return
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
                                        <th>Medicine Name</th>
                                        <th>Return Date</th>
                                        <th>Quantity</th>
                                        <th>Reason</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($returns as $index => $return)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $return->medicine_name }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($return->return_date)->format('d-m-Y') }}
                                            </td>
                                            <td>{{ $return->quantity }}</td>
                                            <td>{{ $return->reason ?? '-' }}</td>

                                            <td class="text-end">
                                                <div class="hstack gap-2 justify-content-end">

                                                    {{-- View --}}
                                                    <a href="{{ route('admin.returns.show', $return->id) }}"
                                                        class="avatar-text avatar-md action-icon">
                                                        <i class="feather-eye"></i>
                                                    </a>

                                                    {{-- Edit --}}
                                                    <a href="{{ route('admin.returns.edit', $return->id) }}"
                                                        class="avatar-text avatar-md action-icon action-edit">
                                                        <i class="feather-edit"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <form action="{{ route('admin.returns.delete', $return->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this return record?')">
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
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">
                                                No return records found.
                                            </td>
                                        </tr>
                                    @endforelse
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
@extends('layouts.admin')

@section('page-title', 'Deleted Returns | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5>Deleted Return Records</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.returns.index') }}" class="btn btn-neutral">
                Back
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card">
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

                                            {{-- Restore --}}
                                            <a href="{{ route('admin.returns.restore', $return->id) }}"
                                                class="avatar-text avatar-md action-icon action-restore">
                                                <i class="feather-refresh-ccw"></i>
                                            </a>

                                            {{-- Force Delete --}}
                                            <a href="{{ route('admin.returns.forceDelete', $return->id) }}"
                                                class="avatar-text avatar-md action-icon action-delete"
                                                onclick="return confirm('This will permanently delete the return record. Continue?')">
                                                <i class="feather-trash"></i>
                                            </a>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        No deleted return records found.
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

@endsection
@extends('layouts.admin')

@section('page-title', 'Deleted Hourly Pay')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div class="page-header-left">
        <h5 class="m-b-10 mb-1">Deleted Work Types</h5>

        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('hr.payroll.hourly-pay.index') }}">
                    Hourly Pay
                </a>
            </li>

            <li class="breadcrumb-item active">
                Deleted Records
            </li>
        </ul>
    </div>

    <a href="{{ route('hr.payroll.hourly-pay.index') }}"
       class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>

</div>

<div class="row">
    <div class="col-12">

        <div class="card stretch stretch-full">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Work Type</th>
                                <th>Category</th>
                                <th>Earnings</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($deleted as $item)

                                <tr>

                                    <!-- Work Type -->
                                    <td>
                                        <span class="badge bg-soft-primary text-primary">
                                            {{ $item->name }}
                                        </span>
                                    </td>

                                    <!-- Category -->
                                    <td>
                                        {{ $item->category }}
                                    </td>

                                    <!-- Earnings -->
                                    <td>
                                        <span class="badge bg-soft-info text-info">
                                            {{ ucfirst($item->earning_type) }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        @if($item->status == 'active')
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end">

                                        <div class="d-flex gap-2 justify-content-end">

                                            <!-- Restore -->
                                            <form action="{{ route('hr.payroll.hourly-pay.restore', $item->id) }}"
                                                  method="POST">

                                                @csrf

                                                <button type="submit"
                                                        class="btn btn-outline-success btn-icon rounded-circle btn-sm"
                                                        title="Restore">

                                                    <i class="feather-rotate-ccw"></i>

                                                </button>

                                            </form>

                                            <!-- Permanent Delete -->
                                            <form action="{{ route('hr.payroll.hourly-pay.force-delete', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Permanently delete?')">

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
                                    <td colspan="5" class="text-center text-muted">
                                        No deleted records
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
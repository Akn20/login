@extends('layouts.admin') 

@section('page-title', 'Hourly Pay | ' . config('app.name'))

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1">Hourly Pay Master</h5>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Hourly Pay List</li>
        </ul>
    </div>

    <div class="d-flex gap-2 align-items-center">
        <!-- ✅ Add Button -->
        <a href="{{ route('hr.payroll.hourly-pay.create') }}" class="btn btn-primary">
            <i class="feather-plus me-1"></i> Add Work Type
        </a>

        <!-- Optional Deleted -->
        <a href="{{ route('hr.payroll.hourly-pay.deleted') }}" class="btn btn-danger">
            Deleted Records
        </a>
    </div>
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
                            @forelse($workTypes as $item)
                                <tr>

                                    <!-- Work Type -->
                                    <td>
                                        <span class="badge bg-soft-primary text-primary">
                                            {{ $item->name }}
                                        </span>
                                    </td>

                                    <!-- Category -->
                                    <td>{{ $item->category }}</td>

                                    <!-- Earnings -->
                                    <td>
                                        <span class="badge bg-soft-info text-info">
                                            {{ ucfirst($item->earning_type) }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <span class="text-success">Active</span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <!-- View -->
                                            <a href="{{ route('hr.payroll.hourly-pay.show', $item->id) }}"
                                               class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
                                               title="View">
                                                <i class="feather-eye"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('hr.payroll.hourly-pay.edit', $item->id) }}"
                                               class="btn btn-outline-secondary btn-icon rounded-circle btn-sm"
                                               title="Edit">
                                                <i class="feather-edit-2"></i>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('hr.payroll.hourly-pay.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Move to trash?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                                                        title="Delete">
                                                    <i class="feather-trash-2"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No records found
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
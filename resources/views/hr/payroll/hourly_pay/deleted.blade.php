@extends('layouts.admin')

@section('page-title', 'Deleted Hourly Pay')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5 class="mb-1">Deleted Work Types</h5>

    <a href="{{ route('hr.payroll.hourly-pay.index') }}" class="btn btn-light">
        <i class="feather-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>Work Type</th>
                        <th>Category</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($deleted as $item)
                        <tr>

                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>

                            <td class="text-end">

                                <div class="d-flex gap-2 justify-content-end">

                                    <!-- Restore -->
                                    <form action="{{ route('hr.payroll.hourly-pay.restore', $item->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <button class="btn btn-outline-success btn-icon rounded-circle btn-sm"
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

                                        <button class="btn btn-outline-danger btn-icon rounded-circle btn-sm"
                                                title="Delete Permanently">
                                            <i class="feather-trash-2"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                No deleted records
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
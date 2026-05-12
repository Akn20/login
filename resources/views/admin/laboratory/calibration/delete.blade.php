@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10 text-danger">Deleted Calibration</h5>
    </div>

    <div class="page-header-right ms-auto">
        <a href="{{ route('admin.laboratory.calibration.index') }}" class="btn btn-light-brand btn-sm">
            <i class="feather-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="main-content">
    <div class="card stretch stretch-full">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Equipment</th>
                            <th>Type</th>
                            <th>Result</th>
                            <th>Deleted At</th>
                            <th class="text-center" style="width:120px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($calibrations as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $item->equipment->name ?? '-' }}
                                </td>

                                <td>{{ $item->calibration_type }}</td>

                                <td>
                                    <span class="badge bg-{{ $item->result == 'Pass' ? 'success' : 'danger' }}">
                                        {{ $item->result }}
                                    </span>
                                </td>

                                <td>
                                    {{ $item->deleted_at ? $item->deleted_at->format('d M Y H:i') : '-' }}
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- RESTORE -->
                                        <form action="{{ route('admin.laboratory.calibration.restore', $item->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit"
                                                class="btn btn-outline-success btn-icon rounded-circle"
                                                title="Restore">
                                                <i class="feather-rotate-ccw"></i>
                                            </button>
                                        </form>

                                        <!-- PERMANENT DELETE -->
                                        <form action="{{ route('admin.laboratory.calibration.forceDelete', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Permanently delete this record?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-outline-danger btn-icon rounded-circle"
                                                title="Delete Permanently">
                                                <i class="feather-trash-2"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No Deleted Calibration Records Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            {{ $calibrations->links() }}
        </div>

    </div>
</div>

@endsection
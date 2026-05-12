@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10 text-danger">Deleted Equipment</h5>
    </div>

    <div class="page-header-right ms-auto">
        <a href="{{ route('admin.laboratory.equipment.index') }}" class="btn btn-light-brand btn-sm">
            <i class="feather-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="main-content">
    <div class="card">
        <div class="card-body p-0">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Deleted At</th>
                        <th class="text-center" style="width:120px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($equipment as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->equipment_code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->deleted_at->format('d M Y H:i') }}</td>

                           <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    <!-- Restore -->
                                    <form action="{{ route('admin.laboratory.equipment.restore', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="btn btn-outline-success btn-icon rounded-circle"
                                            title="Restore">
                                            <i class="feather-rotate-ccw"></i>
                                        </button>
                                    </form>

                                    <!-- Permanent Delete -->
                                    <form action="{{ route('admin.laboratory.equipment.forceDelete', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Permanently delete this equipment?')">
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
                            <td colspan="5" class="text-center">
                                No Deleted Equipment Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>

@endsection
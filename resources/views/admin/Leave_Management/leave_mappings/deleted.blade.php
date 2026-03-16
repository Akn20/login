@extends('layouts.admin')

@section('content')
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1"><i class="feather-trash-2 me-2"></i>Deleted Mappings</h5>
    </div>
    <div class="page-header-right">
        <a href="{{ route('hr.leave-mappings.index') }}" class="btn btn-light btn-sm px-3">
            <i class="feather-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Deleted Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mappings as $map)
                        <tr>
                            <td>{{ $map->leaveType->display_name }}</td>
                            <td>{{ $map->deleted_at->format('d-m-Y H:i') }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Restore Button --}}
                                    <form action="{{ route('hr.leave-mappings.restore', $map->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-icon rounded-circle btn-sm" title="Restore">
                                            <i class="feather-rotate-ccw"></i>
                                        </button>
                                    </form>

                                    {{-- Permanent Delete --}}
                                    <form action="{{ route('hr.leave-mappings.forceDelete', $map->id) }}" method="POST" 
                                          onsubmit="return confirm('Delete permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-icon rounded-circle btn-sm">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4">No deleted mappings found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
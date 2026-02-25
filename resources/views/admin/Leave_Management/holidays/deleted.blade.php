@extends('layouts.admin')

@section('content')
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1"><i class="feather-trash-2 me-2"></i>Deleted Holidays</h5>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.holidays.index') }}" class="btn btn-light btn-sm px-3">
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
                        <th>Holiday Name</th>
                        <th>Deleted Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($holidays as $holiday)
                        <tr>
                            <td>{{ $holiday->name }}</td>
                            <td>{{ $holiday->deleted_at->format('d-m-Y H:i') }}</td>
                            <td class="text-end">
    <div class="d-flex justify-content-end gap-2">
        {{-- Restore Button --}}
        <form action="{{ route('admin.holidays.restore', $holiday->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-success btn-icon rounded-circle btn-sm" title="Restore">
                <i class="feather-rotate-ccw"></i>
            </button>
        </form>

        {{-- Permanent Delete Button --}}
        <form action="{{ route('admin.holidays.forceDelete', $holiday->id) }}" 
              method="POST" 
              onsubmit="return confirm('This action cannot be undone. Delete permanently?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-icon rounded-circle btn-sm" title="Delete Permanently">
                <i class="feather-trash-2"></i>
            </button>
        </form>
    </div>
</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4">No deleted holidays found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
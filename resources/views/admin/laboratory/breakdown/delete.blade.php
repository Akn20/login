@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="text-danger m-b-10">Deleted Breakdown</h5>
    </div>

    <div class="page-header-right ms-auto">
        <a href="{{ route('admin.laboratory.breakdown.index') }}" 
           class="btn btn-light-brand btn-sm">
            <i class="feather-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Equipment</th>
                    <th>Date</th>
                    <th>Deleted At</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($breakdowns as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->equipment->name ?? '-' }}</td>
                        <td>{{ $item->breakdown_date }}</td>
                        <td>{{ $item->deleted_at->format('d M Y H:i') }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <!-- RESTORE -->
                                <form method="POST" action="{{ route('admin.laboratory.breakdown.restore', $item->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-outline-success btn-icon rounded-circle">
                                        <i class="feather-rotate-ccw"></i>
                                    </button>
                                </form>

                                <!-- DELETE -->
                                <form method="POST" action="{{ route('admin.laboratory.breakdown.forceDelete', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon rounded-circle">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No Deleted Records</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
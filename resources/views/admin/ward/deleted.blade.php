@extends('layouts.admin')

@section('page-title', 'Deleted Wards | ' . config('app.name'))

@section('content')

    <div class="page-header">
        <div class="page-header-left">
            <h5 class="m-b-10 text-danger">Deleted Wards</h5>
        </div>

        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.ward.index') }}" class="btn btn-light-brand btn-sm">
                <i class="feather-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="card stretch stretch-full">

            <div class="card-body custom-card-action p-0">

                <div class="table-responsive">
                    <table class="table table-hover mb-0">

                        <thead>
                            <tr class="border-b">
                                <th>Sl.No</th>
                                <th>Ward Name</th>
                                <th>Type</th>
                                <th>Deleted At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($wards as $ward)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ward->ward_name }}</td>
                                    <td>{{ $ward->ward_type }}</td>

                                    <td>
                                        {{ optional($ward->deleted_at)->format('d M Y H:i') }}
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('admin.ward.restore', $ward->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                    class="avatar-text avatar-md border-0 bg-transparent text-success">
                                                    <i class="feather feather-rotate-ccw"></i>
                                                </button>
                                            </form>

                                            {{-- Permanent Delete --}}
                                            <form action="{{ route('admin.ward.forceDelete', $ward->id) }}" method="POST"
                                                onsubmit="return confirm('Permanently delete this ward?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md border-0 bg-transparent text-danger">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No Deleted Wards Found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

            <div class="card-footer">
                {{ $wards->links() }}
            </div>

        </div>
    </div>

@endsection
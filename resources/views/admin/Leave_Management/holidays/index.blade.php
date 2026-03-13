@extends('layouts.admin')

@section('page-title', 'Holidays | ' . config('app.name'))

@section('content')
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-left">
            <h5 class="m-b-10 mb-1">Holiday Management</h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Holiday List</li>
            </ul>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <form method="GET" action="{{ route('hr.holidays.index') }}" class="d-flex gap-2">
                <select name="status" class="form-control form-control-sm" style="width: 120px;">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..."
                    style="width: 150px;">
                <button class="btn btn-light btn-sm border"><i class="feather-search"></i></button>
            </form>

            <a href="{{ route('hr.holidays.create') }}" class="btn btn-primary">
                <i class="feather-plus me-1"></i> Add Holiday
            </a>

            <a href="{{ route('hr.holidays.deleted') }}" class="btn btn-danger">
                Deleted Holidays
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
                                    <th>#</th>
                                    <th>Holiday Name</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($holidays as $index => $holiday)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $holiday->name }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($holiday->start_date)->format('d M Y') }}</td>
                                        <td>
                                            @if ($holiday->status === 'active')
                                                <span class="badge bg-soft-success text-success">Active</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                {{-- View Button --}}
                                                <a href="{{ route('hr.holidays.show', $holiday->id) }}"
                                                    class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                                    <i class="feather-eye"></i>
                                                </a>

                                                {{-- Edit Button --}}
                                                <a href="{{ route('hr.holidays.edit', $holiday->id) }}"
                                                    class="btn btn-outline-secondary btn-icon rounded-circle btn-sm">
                                                    <i class="feather-edit-2"></i>
                                                </a>

                                                {{-- Delete Button --}}
                                                <form action="{{ route('hr.holidays.delete', $holiday->id) }}" method="POST"
                                                    onsubmit="return confirm('Move to trash?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-outline-danger btn-icon rounded-circle btn-sm">
                                                        <i class="feather feather-trash-2"></i>
                                                    </button>
                                                </form>
                                                {{-- Update the status check to use strings --}}
                                                <form action="{{ route('hr.holidays.toggleStatus', $holiday->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="status-toggle {{ $holiday->status === 'active' ? 'active' : 'inactive' }}">
                                                        <span>
                                                            {{ $holiday->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                        </span>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Updated selector to include holidays
            const toggles = document.querySelectorAll('.status-toggle-input[data-url*="holidays"]');

            toggles.forEach(toggle => {
                toggle.addEventListener('change', function () {
                    const url = this.getAttribute('data-url');
                    const checked = this.checked;

                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.success) {
                                alert('Failed to update status.');
                                this.checked = !checked;
                            }
                        })
                        .catch(() => {
                            alert('An error occurred.');
                            this.checked = !checked;
                        });
                });
            });
        });
    </script>
@endpush
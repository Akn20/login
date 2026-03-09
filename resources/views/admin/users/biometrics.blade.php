@extends('layouts.admin')

@section('page-title', 'User Biometrics | ' . config('app.name'))

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex align-items-center w-100">
            <div class="page-header-title">
                <h5 class="m-b-10 mb-1">
                    <i class="feather-users me-2"></i>Users
                </h5>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">User Biometric Enrollment</li>
                </ul>
            </div>
            <div class="ms-auto">
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                        placeholder="Search name / code">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option value="not_enrolled" {{ request('status') === 'not_enrolled' ? 'selected' : '' }}>Not enrolled
                        </option>
                        <option value="partial" {{ request('status') === 'partial' ? 'selected' : '' }}>1-2 images</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button class="btn btn-sm btn-primary" type="submit">Filter</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Biometric Enrollment</h5>
            <small class="text-muted">Sorted by not enrolled first</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                @if ($errors->has('biometrics'))
                    <div class="alert alert-danger mb-2">
                        {{ $errors->first('biometrics') }}
                    </div>
                @endif
                <table class="table table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Emp Code</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th class="text-center">Biometric Images (3)</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            @php
                                $count = $user->biometric_images_count ?? $user->biometricImages->count();
                            @endphp
                            <tr class="{{ $count === 0 ? 'table-warning' : '' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            @if ($user->avatar_url)
                                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle"
                                                    width="32" height="32">
                                            @else
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                    style="width:32px;height:32px;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div>{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->employee_code }}</td>
                                <td>{{ $user->department->name ?? '-' }}</td>
                                <td>
                                    @php
                                        $badgeClass = 'bg-secondary';
                                        $label = $count . '/3';
                                        if ($count === 0) {
                                            $badgeClass = 'bg-danger';
                                            $label = 'Not enrolled (0/3)';
                                        } elseif ($count < 3) {
                                            $badgeClass = 'bg-warning text-dark';
                                            $label = 'In progress (' . $count . '/3)';
                                        } else {
                                            $badgeClass = 'bg-success';
                                            $label = 'Completed (3/3)';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.users.biometrics.upload', $user->id) }}" method="POST"
                                        enctype="multipart/form-data" class="d-flex justify-content-center gap-2 flex-wrap">
                                        @csrf

                                        @for ($i = 1; $i <= 3; $i++)
                                            @php
                                                $image = $user->biometricImages->firstWhere('slot', $i);
                                            @endphp
                                            <div class="text-center me-2">
                                                @if ($image)
                                                    <img src="{{ $image->url }}" class="rounded mb-1" width="64" height="64"
                                                        alt="Slot {{ $i }}">
                                                    <small class="d-block text-success">Saved</small>
                                                    <label class="btn btn-xs btn-outline-secondary w-100 mb-1 mt-1">
                                                        Change
                                                        <input type="file" name="slot_{{ $i }}" accept="image/*" class="d-none">
                                                    </label>
                                                @else
                                                    <div class="border rounded mb-1 d-flex justify-content-center align-items-center"
                                                        style="width:64px;height:64px;">
                                                        <small class="text-muted">Empty</small>
                                                    </div>
                                                    <label class="btn btn-xs btn-outline-primary w-100 mb-1">
                                                        Upload
                                                        <input type="file" name="slot_{{ $i }}" accept="image/*" class="d-none">
                                                    </label>
                                                @endif
                                            </div>
                                        @endfor

                                        <button type="submit" class="btn btn-xs btn-success align-self-center">
                                            Save
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ optional($user->biometric_updated_at)->format('d-m-Y H:i') ?? '—' }}
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($users, 'links'))
                <div class="p-3">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function removeBiometricImage(id) {
            if (!confirm('Remove this biometric image?')) return;

            fetch("{{ route('admin.users.biometrics.delete', ':id') }}".replace(':id', id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: new URLSearchParams({ _method: 'DELETE' })
            }).then(() => {
                window.location.reload();
            });
        }
    </script>
@endpush
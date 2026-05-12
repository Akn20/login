@extends('layouts.admin')

@section('page-title', 'Emergency Records | ' . config('app.name'))

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10">Emergency Records</h5>
        <small class="text-muted">Quick access to critical patient information</small>
    </div>

    <div class="page-header-right ms-auto">
        <div class="input-group" style="width: 280px;">
            <span class="input-group-text bg-light border-0">
                <i class="feather-search"></i>
            </span>
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search patient...">
        </div>
    </div>
</div>

<div class="main-content">
    <div class="card stretch stretch-full">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="emergencyTable">
                    <thead class="table-light">
                        <tr>
                            <th>UHID</th>
                            <th>Patient</th>
                            <th>Blood</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $item)
                            <tr>
                                <td class="fw-semibold text-primary">
                                    {{ $item['patient_code'] ?? 'Direct Entry' }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-text avatar-md rounded-circle {{ $item['source'] === 'case' ? 'bg-danger text-white' : 'bg-warning text-dark' }} d-flex align-items-center justify-content-center me-2">
                                            {{ strtoupper(substr($item['patient_name'] ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">
                                                {{ $item['patient_name'] ?? 'Unknown' }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $item['source'] === 'case' ? 'Emergency Case' : 'Surgery Case' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-danger">{{ $item['blood_group'] ?? 'N/A' }}</span>
                                </td>
                                <td>{{ $item['mobile'] ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $item['type'] }}</span>
                                </td>
                                <td>
                                    @if($item['source'] === 'case')
                                        <span class="badge bg-danger">Emergency</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Surgery Emergency</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($item['patient_id'])
                                        <a href="{{ route('admin.patients.emergency.view', $item['patient_id']) }}" class="btn btn-sm btn-danger rounded-pill px-3">
                                            View
                                        </a>
                                    @else
                                        <span class="badge bg-secondary">No Link</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No emergency records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#emergencyTable tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>

@endsection
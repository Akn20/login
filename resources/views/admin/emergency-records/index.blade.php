@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- 🚨 HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-danger">🚑 Emergency Records</h3>
            <small class="text-muted">Quick access to critical patient information</small>
        </div>

        {{-- Search --}}
        <input type="text" id="searchInput" class="form-control w-25" 
               placeholder="🔍 Search patient...">
    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle table-hover" id="emergencyTable">

    <thead class="bg-light">
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

    @foreach($records as $item)
    <tr class="{{ $item['source'] === 'case' ? 'row-emergency' : 'row-surgery' }}">

        {{-- UHID --}}
        <td class="fw-semibold text-primary">
            {{ $item['patient_code'] ?? 'Direct Entry' }}
        </td>

        {{-- Patient --}}
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar {{ $item['source'] === 'case' ? 'bg-danger' : 'bg-warning text-dark' }} text-white rounded-circle me-2">
                    {{ strtoupper(substr($item['patient_name'] ?? 'U',0,1)) }}
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

        {{-- Blood --}}
        <td>
            <span class="badge bg-danger fs-6 px-3 py-2">
                {{ $item['blood_group'] ?? 'N/A' }}
            </span>
        </td>

        {{-- Mobile --}}
        <td>{{ $item['mobile'] ?? 'N/A' }}</td>

        {{-- Type --}}
        <td>
            <span class="badge bg-light text-dark">
                {{ $item['type'] }}
            </span>
        </td>

        {{-- Status --}}
        <td>
            @if($item['source'] === 'case')
                <span class="badge bg-danger text-white px-3 py-2">
                    🚑 Emergency
                </span>
            @else
                <span class="badge bg-warning text-dark px-3 py-2">
                    🟠 Surgery Emergency
                </span>
            @endif
        </td>

        {{-- Action --}}
        <td class="text-end">
            @if($item['patient_id'])
                <a href="{{ route('admin.patients.emergency.view', $item['patient_id']) }}"
                   class="btn btn-sm btn-danger rounded-pill px-3">
                   View
                </a>
            @else
                <span class="badge bg-secondary">No Link</span>
            @endif
        </td>

    </tr>
    @endforeach

    </tbody>

</table>

            </div>

        </div>
    </div>

</div>

{{-- 🔍 SEARCH SCRIPT --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('#emergencyTable tbody tr');

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>

{{-- 🎨 STYLES --}}
<style>
.avatar {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* Hover effect */
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    transition: 0.2s;
}

/* Card styling */
.card {
    transition: all 0.25s ease-in-out;
}

.card:hover {
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}

/* Badge styling */
.badge {
    border-radius: 10px;
}

tr {
    transition: 0.2s;
}

tr:hover {
    background-color: #fff5f5;
}
/* Emergency row highlight */
.row-emergency {
    background: rgba(255, 0, 0, 0.05);
    border-left: 4px solid red;
}

/* Surgery highlight */
.row-surgery {
    background: rgba(255, 165, 0, 0.05);
    border-left: 4px solid orange;
}

/* Avatar */
.avatar {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* Hover effect */
.table-hover tbody tr:hover {
    transform: scale(1.01);
    transition: 0.2s;
}

/* Card styling */
.card:hover {
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}

/* Badge */
.badge {
    border-radius: 10px;
}
</style>
@endsection
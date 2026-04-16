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
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($patients as $patient)
                        <tr>

                            {{-- Patient Code --}}
                            <td class="fw-semibold text-primary">
                                {{ $patient->patient_code }}
                            </td>

                            {{-- Name --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle me-2">
                                        {{ strtoupper(substr($patient->first_name,0,1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">
                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                        </div>
                                        <small class="text-muted">{{ $patient->gender }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- Blood --}}
                            <td>
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    {{ $patient->blood_group ?? 'N/A' }}
                                </span>
                            </td>

                            {{-- Mobile --}}
                            <td>
                                <span class="text-dark fw-semibold">
                                    {{ $patient->mobile }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="badge bg-success-subtle text-success">
                                    Stable
                                </span>
                            </td>

                            {{-- Action --}}
                            <td class="text-end">
                                <a href="{{ route('admin.patients.emergency.view', $patient->id) }}"
                                   class="btn btn-danger btn-sm rounded-pill px-3">
                                   🚑 View
                                </a>
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
</style>
@endsection
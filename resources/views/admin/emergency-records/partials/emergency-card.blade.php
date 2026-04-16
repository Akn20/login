<div class="container-fluid">

    {{-- 🚨 EMERGENCY HEADER --}}
    <div class="alert alert-danger d-flex justify-content-between align-items-center shadow-sm mb-4">
        <div>
            <h4 class="mb-0 fw-bold">🚨 Emergency Patient Snapshot</h4>
            <small class="text-light">Critical information for immediate care</small>
        </div>
        <span class="badge bg-dark px-3 py-2 fs-6">HIGH PRIORITY</span>
    </div>

    <div class="row g-4">

        {{-- 🧍 PATIENT INFO --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg h-100 rounded-4">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="feather-user fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">
                                {{ $patient->first_name }} {{ $patient->last_name }}
                            </h5>
                            <small class="text-muted">Patient Details</small>
                        </div>
                    </div>

                    <hr>

                    <p class="mb-2">
                        <strong>🩸 Blood Group:</strong>
                        <span class="badge bg-danger fs-6 px-3 py-2">
                            {{ $patient->blood_group ?? 'N/A' }}
                        </span>
                    </p>

                    <p class="mb-0">
                        <strong>📞 Emergency Contact:</strong><br>
                        <span class="text-dark fw-semibold">
                            {{ $patient->emergency_contact ?? 'Not Available' }}
                        </span>
                    </p>

                </div>
            </div>
        </div>

        {{-- ⚠️ ALLERGIES --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg h-100 rounded-4">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger text-white rounded-circle p-3 me-3">
                            <i class="feather-alert-triangle fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-danger">Allergies</h5>
                            <small class="text-muted">Critical Alerts</small>
                        </div>
                    </div>

                    <hr>

                    @forelse($allergies as $item)
                        <div class="badge bg-danger bg-opacity-75 text-white mb-2 p-2 w-100 text-start">
                            ⚠️ {{ $item->title }}
                        </div>
                    @empty
                        <div class="text-success fw-semibold">
                            ✔ No Known Allergies
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        {{-- 🧬 CHRONIC CONDITIONS --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg h-100 rounded-4">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning text-dark rounded-circle p-3 me-3">
                            <i class="feather-activity fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-warning">Chronic Conditions</h5>
                            <small class="text-muted">Long-term Health</small>
                        </div>
                    </div>

                    <hr>

                    @forelse($chronic as $item)
                        <div class="badge bg-warning text-dark mb-2 p-2 w-100 text-start">
                            🧬 {{ $item->title }}
                        </div>
                    @empty
                        <div class="text-success fw-semibold">
                            ✔ No Chronic Conditions
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>

</div>
<style>
    .card {
    transition: all 0.25s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

.alert-danger {
    border-radius: 12px;
}

.badge {
    font-size: 0.9rem;
    border-radius: 8px;
}
</style>
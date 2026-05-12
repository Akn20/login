<div class="row gy-4">

    <div class="col-lg-4">
        <div class="card stretch stretch-full">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-text avatar-md bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="feather-user"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Patient Details</h6>
                        <small class="text-muted">Emergency summary</small>
                    </div>
                </div>

                <p class="mb-2"><strong>Name:</strong> {{ $patient->first_name }} {{ $patient->last_name }}</p>
                <p class="mb-2"><strong>Blood Group:</strong> {{ $patient->blood_group ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Emergency Contact:</strong> {{ $patient->emergency_contact ?? 'Not Available' }}</p>
                <p class="mb-0"><strong>Age:</strong> {{ $patient->age ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card stretch stretch-full">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-text avatar-md bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="feather-alert-triangle"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Allergies</h6>
                        <small class="text-muted">Critical alerts</small>
                    </div>
                </div>

                @forelse($allergies as $item)
                    @php
                        $title = is_object($item) ? $item->title : $item;
                        $severity = is_object($item) ? $item->severity : null;
                        $source = is_object($item) ? 'Flag' : 'Surgery';
                    @endphp

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $title }}</strong>
                                @if($severity)
                                    <div><small class="text-muted">Severity: {{ strtoupper($severity) }}</small></div>
                                @endif
                            </div>
                            <span class="badge bg-secondary">{{ $source }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-muted">No known allergies reported.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card stretch stretch-full">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-text avatar-md bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="feather-activity"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Chronic Conditions</h6>
                        <small class="text-muted">Long-term health status</small>
                    </div>
                </div>

                @forelse($chronic as $item)
                    <div class="badge bg-soft-warning text-warning mb-2 py-2 w-100 text-start">
                        {{ $item->title }}
                    </div>
                @empty
                    <div class="text-muted">No chronic conditions recorded.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
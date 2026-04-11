@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <h4 class="fw-bold mb-4 text-primary">View Insurance</h4>

    <div class="card shadow-sm p-4">

        <!-- 🔷 PATIENT DETAILS -->
        <h5 class="text-primary mb-3">Patient Details</h5>

        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">UHID</small><br>
                    <strong>{{ $insurance->patient->patient_code ?? '-' }}</strong>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">Patient Name</small><br>
                    <strong>
                        {{ $insurance->patient->first_name ?? '' }}
                        {{ $insurance->patient->last_name ?? '' }}
                    </strong>
                </div>
            </div>

        </div>

        <hr>

        <!-- 🔷 INSURANCE DETAILS -->
        <h5 class="text-primary mb-3">Insurance Details</h5>

        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">Provider</small><br>
                    <strong>{{ $insurance->provider_name }}</strong>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">Policy Number</small><br>
                    <strong>{{ $insurance->policy_number }}</strong>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">Policy Holder</small><br>
                    <strong>{{ $insurance->policy_holder_name }}</strong>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">Validity</small><br>
                    <strong>
                        {{ \Carbon\Carbon::parse($insurance->valid_from)->format('d M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($insurance->valid_to)->format('d M Y') }}
                    </strong>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">Sum Insured</small><br>
                    <strong>₹ {{ number_format($insurance->sum_insured) }}</strong>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">TPA</small><br>
                    <strong>{{ $insurance->tpa_name ?? '-' }}</strong>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">Status</small><br>

                    @if($insurance->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>

                    @elseif($insurance->status == 'verified')
                        <span class="badge bg-success">Claimed</span>

                    @elseif($insurance->status == 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @endif

                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted">Remarks</small><br>
                    <strong>{{ $insurance->remarks ?? '-' }}</strong>
                </div>
            </div>

        </div>

        <hr>

        <!-- 🔷 DOCUMENTS -->
        <h5 class="text-primary mb-3">Documents</h5>

        @php
            $docs = $insurance->documents->keyBy('document_type');
        @endphp

        <div class="row">

            <div class="col-md-4 mb-3">
                @if(isset($docs['Insurance Card']))
                    <a href="{{ asset('storage/' . $docs['Insurance Card']->file_path) }}"
                    target="_blank"
                    class="btn btn-info btn-sm w-100">
                        📄 Insurance Card
                    </a>
                @else
                    <span class="text-muted">No Insurance Card</span>
                @endif
            </div>

            <div class="col-md-4 mb-3">
                @if(isset($docs['ID Proof']))
                    <a href="{{ asset('storage/' . $docs['ID Proof']->file_path) }}"
                    target="_blank"
                    class="btn btn-info btn-sm w-100">
                        🪪 ID Proof
                    </a>
                @else
                    <span class="text-muted">No ID Proof</span>
                @endif
            </div>

            <div class="col-md-4 mb-3">
                @if(isset($docs['Authorization Letter']))
                    <a href="{{ asset('storage/' . $docs['Authorization Letter']->file_path) }}"
                    target="_blank"
                    class="btn btn-info btn-sm w-100">
                        📑 Authorization Letter
                    </a>
                @else
                    <span class="text-muted">No Authorization Letter</span>
                @endif
            </div>

        </div>

        <hr>

        <!-- 🔷 META -->
        <div class="row">
            <div class="col-md-4">
                <small class="text-muted">Created At</small><br>
                <strong>{{ $insurance->created_at->format('d M Y h:i A') }}</strong>
            </div>

            <div class="col-md-4">
                <small class="text-muted">Updated At</small><br>
                <strong>{{ $insurance->updated_at->format('d M Y h:i A') }}</strong>
            </div>
        </div>

        <hr>

        <a href="{{ route('admin.insurance.index') }}" class="btn btn-secondary">
            ⬅ Back
        </a>

    </div>

</div>

@endsection
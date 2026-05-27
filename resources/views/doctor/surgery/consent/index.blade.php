@extends('layouts.admin')

@section('title', 'Surgery Consent List')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Surgery Consent List</h4>
        <a href="{{ route('consent.create') }}" class="btn btn-neutral">
            <i class="feather-plus-circle me-1"></i>
            Add Consent
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Surgery</th>
                        <th>Status</th>
                        <th>Consent Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($consents as $consent)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $consent->patient->first_name ?? '' }}
                                {{ $consent->patient->last_name ?? '' }}
                            </td>

                            <td>
                                {{ $consent->surgery->surgery_type ?? '-' }}
                            </td>

                            <td>
                                @if($consent->consent_status == 'Granted')
                                    <span class="badge bg-success">Granted</span>
                                @elseif($consent->consent_status == 'Refused')
                                    <span class="badge bg-danger">Refused</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($consent->consent_taken_at)->format('d M Y h:i A') }}
                            </td>

                            <td>
                                <div class="hstack gap-2 justify-content-center">
                                    <a href="{{ route('consent.show', $consent->id) }}"
                                       class="avatar-text avatar-md" data-bs-toggle="tooltip" title="View">
                                        <i class="feather feather-eye"></i>
                                    </a>

                                    <a href="{{ route('consent.history', $consent->patient_id) }}"
                                       class="avatar-text avatar-md" data-bs-toggle="tooltip" title="History">
                                        <i class="feather feather-clock"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center">
                                No consent records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

            <div class="mt-3">
                {{ $consents->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
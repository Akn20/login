@extends('layouts.admin')

@section('title', 'Data Usage Consent')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="mb-0">

            Data Usage Consent List

        </h4>

        <a href="{{ route('admin.data-consent.create') }}"
           class="btn btn-primary">

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

                        <th>Purpose</th>

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

                                {{ $consent->patient->patient_code ?? '' }}
                                -
                                {{ $consent->patient->first_name ?? '' }}
                                {{ $consent->patient->last_name ?? '' }}

                            </td>

                            <td>

                                {{ $consent->purpose }}

                            </td>

                            <td>

                                @if($consent->consent_status == 'Granted')

                                    <span class="badge bg-success">

                                        Granted

                                    </span>

                                @elseif($consent->consent_status == 'Refused')

                                    <span class="badge bg-danger">

                                        Refused

                                    </span>

                                @else

                                    <span class="badge bg-warning">

                                        Pending

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($consent->consent_taken_at)->format('d M Y h:i A') }}

                            </td>

                            <td>

                                <a href="{{ route('admin.data-consent.show', $consent->id) }}"
                                   class="btn btn-outline-info btn-icon rounded-circle"
                                   title="View">

                                    <i class="feather-eye"></i>

                                </a>

                                <a href="{{ route('admin.data-consent.history', $consent->patient_id) }}"
                                   class="btn btn-outline-secondary btn-icon rounded-circle"
                                   title="History">

                                    <i class="feather-clock"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center">

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
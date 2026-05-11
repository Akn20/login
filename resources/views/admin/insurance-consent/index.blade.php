@extends('layouts.admin')

@section('title', 'Insurance Consent')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="mb-0">

            Insurance Consent List

        </h4>

        <a href="{{ route('admin.insurance-consent.create') }}"
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

                        <th>Insurance</th>

                        <th>Status</th>

                        <th>Consent Date</th>

                        <th width="220">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($consents as $consent)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $consent->patient->first_name ?? '' }}
                                {{ $consent->patient->last_name ?? '' }}

                            </td>

                            <td>

                                {{ $consent->insurance->provider_name ?? '' }}
                                <br>

                                <small>

                                    {{ $consent->insurance->policy_number ?? '' }}

                                </small>

                            </td>

                            <td>

                                @if($consent->consent_status == 'Approved')

                                    <span class="badge bg-success">

                                        Approved

                                    </span>

                                @elseif($consent->consent_status == 'Rejected')

                                    <span class="badge bg-danger">

                                        Rejected

                                    </span>

                                @else

                                    <span class="badge bg-warning">

                                        Pending

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ optional($consent->consent_given_at)->format('d M Y h:i A') }}

                            </td>

                            <td class="text-end">

                                <div class="hstack gap-2 justify-content-end">

                                    {{-- View --}}
                                    <a href="{{ route('admin.insurance-consent.show', $consent->id) }}"
                                       class="avatar-text avatar-md action-icon"
                                       data-bs-toggle="tooltip" title="View">

                                        <i class="feather-eye"></i>

                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.insurance-consent.edit', $consent->id) }}"
                                       class="avatar-text avatar-md action-icon action-edit"
                                       data-bs-toggle="tooltip" title="Edit">

                                        <i class="feather-edit"></i>

                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.insurance-consent.delete', $consent->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this consent?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="avatar-text avatar-md action-icon action-delete d-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" title="Delete">

                                            <i class="feather-trash-2"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center">

                                No insurance consent found.

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
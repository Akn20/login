@extends('layouts.admin')

@section('title', 'Usage Monitoring')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">

                Usage Monitoring

            </h4>

            <p class="text-muted mb-0">

                Monitor organization resource usage

            </p>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Organization</th>

                            <th>Plan</th>

                            <th>Users</th>

                            <th>Patients</th>

                            <th>Hospitals</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($usageData as $data)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                {{-- ORGANIZATION --}}
                                <td>

                                    <div class="fw-semibold">

                                        {{ $data['organization'] }}

                                    </div>

                                </td>

                                {{-- PLAN --}}
                                <td>

                                    <span class="badge bg-primary">

                                        {{ $data['plan'] }}

                                    </span>

                                </td>

                                {{-- USERS --}}
                                <td>

                                    @if($data['users_limit'] == -1)

                                        <span class="text-success">

                                            {{ $data['users_used'] }}
                                            / Unlimited

                                        </span>

                                    @else

                                        <span>

                                            {{ $data['users_used'] }}
                                            /
                                            {{ $data['users_limit'] }}

                                        </span>

                                    @endif

                                </td>

                                {{-- PATIENTS --}}
                                <td>

                                    @if($data['patients_limit'] == -1)

                                        <span class="text-success">

                                            {{ $data['patients_used'] }}
                                            / Unlimited

                                        </span>

                                    @else

                                        <span>

                                            {{ $data['patients_used'] }}
                                            /
                                            {{ $data['patients_limit'] }}

                                        </span>

                                    @endif

                                </td>

                                {{-- HOSPITALS --}}
                                <td>

                                    @if($data['hospitals_limit'] == -1)

                                        <span class="text-success">

                                            {{ $data['hospitals_used'] }}
                                            / Unlimited

                                        </span>

                                    @else

                                        <span>

                                            {{ $data['hospitals_used'] }}
                                            /
                                            {{ $data['hospitals_limit'] }}

                                        </span>

                                    @endif

                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @if($data['subscription_status'] == 'active')

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                    @elseif($data['subscription_status'] == 'trial')

                                        <span class="badge bg-info">

                                            Trial

                                        </span>

                                    @elseif($data['subscription_status'] == 'grace')

                                        <span class="badge bg-warning">

                                            Grace

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Suspended

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        No usage data available

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
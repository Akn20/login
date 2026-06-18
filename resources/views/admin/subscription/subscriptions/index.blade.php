@extends('layouts.admin')

@section('title', 'Organization Subscriptions')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">

                Organization Subscriptions

            </h4>

            <p class="text-muted mb-0">

                Manage organization subscription assignments

            </p>

        </div>

        <a href="{{ route('admin.subscriptions.create') }}"
           class="btn btn-primary">

            <i class="feather-plus"></i>

            Assign Subscription

        </a>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    {{-- ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

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

                            <th>Start Date</th>

                            <th>Expiry Date</th>

                            <th>Status</th>

                            <th>Auto Renew</th>

                            <th width="180">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($subscriptions as $subscription)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                {{-- ORGANIZATION --}}
                                <td>

                                    <div class="fw-semibold">

                                        {{ $subscription->organization->name ?? '-' }}

                                    </div>

                                </td>

                                {{-- PLAN --}}
                                <td>

                                    <span class="badge bg-primary">

                                        {{ $subscription->plan->name ?? '-' }}

                                    </span>

                                </td>

                                {{-- START DATE --}}
                                <td>

                                    {{ \Carbon\Carbon::parse($subscription->start_date)->format('d M Y') }}

                                </td>

                                {{-- EXPIRY DATE --}}
                                <td>

                                    {{ \Carbon\Carbon::parse($subscription->expiry_date)->format('d M Y') }}

                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @switch($subscription->status)

                                        @case('active')

                                            <span class="badge bg-success">

                                                Active

                                            </span>

                                            @break

                                        @case('trial')

                                            <span class="badge bg-info">

                                                Trial

                                            </span>

                                            @break

                                        @case('grace')

                                            <span class="badge bg-warning">

                                                Grace

                                            </span>

                                            @break

                                        @case('suspended')

                                            <span class="badge bg-danger">

                                                Suspended

                                            </span>

                                            @break

                                        @default

                                            <span class="badge bg-secondary">

                                                Expired

                                            </span>

                                    @endswitch

                                </td>

                                {{-- AUTO RENEW --}}
                                <td>

                                    @if($subscription->auto_renew)

                                        <span class="badge bg-success">

                                            Enabled

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            Disabled

                                        </span>

                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                <td>

                                    <div class="d-flex gap-2">

                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}"
                                           class="btn btn-sm btn-warning">

                                            <i class="feather-edit"></i>

                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('admin.subscriptions.delete', $subscription->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this subscription?')">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">

                                                <i class="feather-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        No subscriptions found

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-3">

        {{ $subscriptions->links() }}

    </div>

</div>

@endsection
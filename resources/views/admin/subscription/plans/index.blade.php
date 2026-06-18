@extends('layouts.admin')

@section('title', 'Subscription Plans')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">Subscription Plans</h4>
            <p class="text-muted mb-0">
                Manage SaaS subscription plans
            </p>
        </div>

        <div>
            <a href="{{ route('admin.plans.create') }}"
               class="btn btn-primary">

                <i class="feather-plus"></i>

                Create Plan
            </a>
        </div>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    {{-- PLAN TABLE --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Plan Name</th>

                            <th>Monthly Price</th>

                            <th>Yearly Price</th>

                            <th>Users Limit</th>

                            <th>Patients Limit</th>

                            <th>Hospitals Limit</th>

                            <th>Status</th>

                            <th width="180">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($plans as $plan)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $plan->name }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $plan->slug }}

                                    </small>

                                </td>

                                <td>

                                    ₹ {{ number_format($plan->monthly_price, 2) }}

                                </td>

                                <td>

                                    ₹ {{ number_format($plan->yearly_price, 2) }}

                                </td>

                                <td>

                                    {{ $plan->limits->max_users ?? 'Unlimited' }}

                                </td>

                                <td>

                                    {{ $plan->limits->max_patients ?? 'Unlimited' }}

                                </td>

                                <td>

                                    {{ $plan->limits->max_hospitals ?? 'Unlimited' }}

                                </td>

                                <td>

                                    @if($plan->status)

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.plans.edit', $plan->id) }}"
                                           class="btn btn-sm btn-warning">

                                            <i class="feather-edit"></i>

                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('admin.plans.delete', $plan->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this plan?')">

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

                                <td colspan="9"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        No subscription plans found

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

        {{ $plans->links() }}

    </div>

</div>

@endsection
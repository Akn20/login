@extends('layouts.admin')

@section('title', 'Edit Subscription')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">

                Edit Subscription

            </h4>

            <p class="text-muted mb-0">

                Update organization subscription details

            </p>

        </div>

        <a href="{{ route('admin.subscriptions.index') }}"
           class="btn btn-light">

            <i class="feather-arrow-left"></i>

            Back

        </a>

    </div>

    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- FORM --}}
    <form action="{{ route('admin.subscriptions.update', $subscription->id) }}"
          method="POST">

        @csrf

        @method('PUT')

        <div class="row">

            <div class="col-lg-8">

                {{-- MAIN CARD --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Subscription Details

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- ORGANIZATION --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Organization

                                </label>

                                <select name="organization_id"
                                        class="form-select"
                                        required>

                                    @foreach($organizations as $organization)

                                        <option value="{{ $organization->id }}"

                                            {{ $subscription->organization_id == $organization->id ? 'selected' : '' }}>

                                            {{ $organization->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- PLAN --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Subscription Plan

                                </label>

                                <select name="plan_id"
                                        class="form-select"
                                        required>

                                    @foreach($plans as $plan)

                                        <option value="{{ $plan->id }}"

                                            {{ $subscription->plan_id == $plan->id ? 'selected' : '' }}>

                                            {{ $plan->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- START DATE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Start Date

                                </label>

                                <input type="date"
                                       name="start_date"
                                       class="form-control"
                                       value="{{ $subscription->start_date }}"
                                       required>

                            </div>

                            {{-- EXPIRY DATE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Expiry Date

                                </label>

                                <input type="date"
                                       name="expiry_date"
                                       class="form-control"
                                       value="{{ $subscription->expiry_date }}"
                                       required>

                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Status

                                </label>

                                <select name="status"
                                        class="form-select"
                                        required>

                                    <option value="trial"

                                        {{ $subscription->status == 'trial' ? 'selected' : '' }}>

                                        Trial

                                    </option>

                                    <option value="active"

                                        {{ $subscription->status == 'active' ? 'selected' : '' }}>

                                        Active

                                    </option>

                                    <option value="grace"

                                        {{ $subscription->status == 'grace' ? 'selected' : '' }}>

                                        Grace

                                    </option>

                                    <option value="suspended"

                                        {{ $subscription->status == 'suspended' ? 'selected' : '' }}>

                                        Suspended

                                    </option>

                                    <option value="expired"

                                        {{ $subscription->status == 'expired' ? 'selected' : '' }}>

                                        Expired

                                    </option>

                                </select>

                            </div>

                            {{-- AUTO RENEW --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label d-block">

                                    Auto Renew

                                </label>

                                <div class="form-check form-switch mt-2">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="auto_renew"
                                           value="1"

                                           {{ $subscription->auto_renew ? 'checked' : '' }}>

                                    <label class="form-check-label">

                                        Enable Auto Renewal

                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-4">

                {{-- CURRENT INFO --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Current Subscription

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <small class="text-muted">

                                Current Plan

                            </small>

                            <div class="fw-semibold">

                                {{ $subscription->plan->name ?? '-' }}

                            </div>

                        </div>

                        <div class="mb-3">

                            <small class="text-muted">

                                Current Status

                            </small>

                            <div>

                                <span class="badge bg-primary">

                                    {{ ucfirst($subscription->status) }}

                                </span>

                            </div>

                        </div>

                        <div>

                            <small class="text-muted">

                                Expiry Date

                            </small>

                            <div class="fw-semibold">

                                {{ \Carbon\Carbon::parse($subscription->expiry_date)->format('d M Y') }}

                            </div>

                        </div>

                    </div>

                </div>

                {{-- SUBMIT --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            <i class="feather-save"></i>

                            Update Subscription

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
@extends('layouts.admin')

@section('title', 'Assign Subscription')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">

                Assign Subscription

            </h4>

            <p class="text-muted mb-0">

                Assign subscription plans to organizations

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
    <form action="{{ route('admin.subscriptions.store') }}"
          method="POST">

        @csrf

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

                                    <option value="">

                                        Select Organization

                                    </option>

                                    @foreach($organizations as $organization)

                                        <option value="{{ $organization->id }}"

                                            {{ old('organization_id') == $organization->id ? 'selected' : '' }}>

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

                                    <option value="">

                                        Select Plan

                                    </option>

                                    @foreach($plans as $plan)

                                        <option value="{{ $plan->id }}"

                                            {{ old('plan_id') == $plan->id ? 'selected' : '' }}>

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
                                       value="{{ old('start_date') }}"
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
                                       value="{{ old('expiry_date') }}"
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

                                    <option value="trial">

                                        Trial

                                    </option>

                                    <option value="active">

                                        Active

                                    </option>

                                    <option value="grace">

                                        Grace

                                    </option>

                                    <option value="suspended">

                                        Suspended

                                    </option>

                                    <option value="expired">

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
                                           value="1">

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

                {{-- INFO CARD --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <strong>Status Types:</strong>

                        </div>

                        <ul class="small text-muted ps-3">

                            <li>
                                Trial → Free trial access
                            </li>

                            <li>
                                Active → Paid active subscription
                            </li>

                            <li>
                                Grace → Payment overdue
                            </li>

                            <li>
                                Suspended → Access restricted
                            </li>

                            <li>
                                Expired → Subscription ended
                            </li>

                        </ul>

                    </div>

                </div>

                {{-- SUBMIT --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            <i class="feather-save"></i>

                            Assign Subscription

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
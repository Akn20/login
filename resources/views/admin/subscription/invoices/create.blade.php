@extends('layouts.admin')

@section('title', 'Create Invoice')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Create Subscription Invoice
            </h4>

            <p class="text-muted mb-0">
                Generate new billing invoice
            </p>

        </div>

        <a href="{{ route('admin.subscription.invoices.index') }}"
           class="btn btn-secondary">

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

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form action="{{ route('admin.subscription.invoices.store') }}"
                  method="POST">

                @csrf

                {{-- SUBSCRIPTION --}}
                <div class="mb-3">

                    <label class="form-label">
                        Select Subscription
                    </label>

                    <select name="subscription_id"
                            class="form-control"
                            required>

                        <option value="">
                            Choose Subscription
                        </option>

                        @foreach($subscriptions as $subscription)

                            <option value="{{ $subscription->id }}">

                                {{ $subscription->organization->name ?? '-' }}
                                -
                                {{ $subscription->plan->name ?? '-' }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                        class="btn btn-primary">

                    <i class="feather-save"></i>

                    Create Invoice

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
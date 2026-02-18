@extends('layouts.auth')

@section('title', 'Set MPIN')

@section('content')

    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('assets/images/logo-abbr.png') }}" class="img-fluid">
                    </div>

                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">
                            {{ session('reset') ? 'Reset MPIN' : 'Set MPIN' }}
                        </h2>

                        <h4 class="fs-13 fw-bold mb-2">
                            {{ session('reset') ? 'Create a new MPIN' : 'Secure your account' }}
                        </h4>

                        <p class="fs-12 fw-medium text-muted">
                            MPIN must be 4 or 6 digits.
                        </p>

                        {{-- SUCCESS MESSAGE --}}
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- ERROR MESSAGE --}}
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('mpin.store') }}" class="w-100 mt-4 pt-2">
                            @csrf

                            <!-- MPIN -->
                            <div class="mb-4">
                                <input type="password"
                                       name="mpin"
                                       class="form-control text-center"
                                       placeholder="Enter MPIN"
                                       maxlength="6"
                                       required>
                            </div>

                            <!-- CONFIRM MPIN -->
                            <div class="mb-4">
                                <input type="password"
                                       name="mpin_confirmation"
                                       class="form-control text-center"
                                       placeholder="Confirm MPIN"
                                       maxlength="6"
                                       required>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-lg btn-primary w-100">
                                    Save MPIN
                                </button>
                            </div>
                        </form>

                        <div class="mt-4 text-muted text-center">
                            <a href="{{ route('login') }}" class="fw-bold">
                                Back to Login
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
@extends('layouts.auth')

@section('title', 'Forgot MPIN')

@section('content')

    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('assets/images/logo-abbr.png') }}" class="img-fluid">
                    </div>

                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">Forgot MPIN</h2>
                        <h4 class="fs-13 fw-bold mb-2">Reset your MPIN</h4>
                        <p class="fs-12 fw-medium text-muted">
                            Enter your registered mobile number to receive OTP.
                        </p>


                        <form method="POST" action="{{ route('forgot.mpin.submit') }}">
                         @csrf



                            <!-- MOBILE NUMBER -->
                            <div class="mb-4">
                                <input type="text"
                                       name="mobile"
                                       class="form-control"
                                       placeholder="Registered Mobile Number"
                                       required>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-lg btn-primary w-100">
                                    Send OTP
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

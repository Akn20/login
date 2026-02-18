@extends('layouts.auth')

@section('title', 'OTP Verification')

@section('content')


    <script>
        console.log('Session data:', @json(session()->all()));
    </script>

    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div
                        class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('assets/images/logo-abbr.png') }}" class="img-fluid">
                    </div>

                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">OTP Verification</h2>
                        <h4 class="fs-13 fw-bold mb-2">Verify your mobile number</h4>
                        <p class="fs-12 fw-medium text-muted">
                            Enter the OTP sent to your registered mobile number.
                        </p>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                                {{ session('otp') ? ' (For testing: OTP is ' . session('otp') . ')' : '' }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('otp.verify') }}" class="w-100 mt-4 pt-2">
                            @csrf
                            <input type="hidden" name="mobile" value="{{ session('mobile') }}">

                            <!-- OTP INPUT -->
                            <div class="mb-4">
                                <input type="text" name="otp" class="form-control text-center fs-18" placeholder="Enter OTP"
                                    maxlength="6" required>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-lg btn-primary w-100">
                                    Verify OTP
                                </button>
                            </div>
                        </form>

                        <div class="mt-4 text-muted text-center">
                            <span>Didn’t receive OTP?</span>
                            <form method="POST"  action="{{ route('otp.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-center">
                                    Resend OTP
                                </button>
                            </form>

                        </div>


                        <div class="mt-3 text-center">
                            <a href="{{ route('login') }}" class="fs-12">
                                Back to Login
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div
                        class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('assets/images/logo-abbr.png') }}" class="img-fluid">
                    </div>

                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">Login</h2>
                        <h4 class="fs-13 fw-bold mb-2">Login to your account</h4>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @error('mobile')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @error('mpin')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        <form method="POST" action="{{ route('login.submit') }}" class="w-100 mt-4 pt-2">
                            @csrf

                            <!-- MOBILE NUMBER -->
                            <div class="mb-4">
                                <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" required>
                            </div>

                            <!-- MPIN -->
                            <div class="mb-3">
                                <input type="password" name="mpin" class="form-control" placeholder="MPIN" required>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <div></div>
                                <div>
                                    <a href="{{ route('forgot.mpin') }}" class="fs-11 text-primary">
                                        Forgot MPIN?
                                    </a>
                                </div>
                            </div>

                            <div class="mt-5">
                                <button type="submit" class="btn btn-lg btn-primary w-100">
                                    Login
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
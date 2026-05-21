@extends('layouts.admin')

@section('page-title', 'Add Training & Certification | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center justify-content-between">

            <div>

                <div class="page-header-title">
                    <h5 class="mb-0">
                        Add Training & Certification
                    </h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        HR
                    </li>

                    <li class="breadcrumb-item">
                        Training & Certification Tracking
                    </li>
                </ul>

            </div>

        </div>
    </div>

    <div class="main-content">

        <div class="row justify-content-center mt-4">

            <div class="col-12 col-lg-10">

                <div class="card stretch stretch-full">

                    <div class="card-body">

                        @if(session('error'))

                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>

                        @endif

                        <form
                            method="POST"
                            action="{{ route('hr.training-certification-tracking.store') }}"
                            enctype="multipart/form-data"
                        >

                            @csrf

                            @include(
                                'hr.trainingCertificationTracking.form'
                            )

                            <div class="d-flex gap-2 mt-3">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Save
                                </button>

                                <a
                                    href="{{ route('hr.training-certification-tracking.index') }}"
                                    class="btn btn-light"
                                >
                                    Cancel
                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
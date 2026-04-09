@extends('layouts.admin')

@section('page-title', 'Apply Leave')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-left">
        <h5 class="m-b-10 mb-1">Apply Leave</h5>

        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('hr.leave-application.index') }}">
                    Leave Application
                </a>
            </li>

            <li class="breadcrumb-item active">
                Apply Leave
            </li>
        </ul>

    </div>
</div>

<div class="row">

<div class="col-lg-12">

    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Apply Leave Form --}}
    <div class="card">

        <div class="card-body">

            @include('admin.Leave_Management.leave_application.form')

        </div>

    </div>

</div>

</div>

@endsection
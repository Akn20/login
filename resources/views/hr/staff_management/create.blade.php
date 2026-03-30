@extends('layouts.admin')

@section('page-title', 'Add Staff | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center justify-content-between">
                <div>
                    <div class="page-header-title">
                        <h5 class="mb-0">Add Staff</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">HR</li>
                        <li class="breadcrumb-item">Staff Management</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="row justify-content-center mt-4">
                <div class="col-12 col-lg-10"> {{-- change width here --}}
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <!-- @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif -->

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('hr.staff-management.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                @include('hr.staff_management.form')

                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                    <a href="{{ route('hr.staff-management.index') }}" class="btn btn-light">
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
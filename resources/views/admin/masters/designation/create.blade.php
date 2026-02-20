@extends('layouts.admin')

@section('page-title', 'Add Designation | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Add Designation</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item">Designation</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">

                    <div class="card stretch stretch-full">
                        <div class="card-body">

                            <form action="{{ route('admin.designation.store') }}" method="POST">
                                @csrf

                                @include('admin.masters.designation.form')

                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">Save</button>

                                    <a href="{{ route('admin.designation.index') }}" class="btn btn-light">
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
@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Add New Medicine</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Stock</li>
                <li class="breadcrumb-item">Create</li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card stretch stretch-full">
                    <div class="card-body">

                        <!-- Success / Error -->
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.stock.store') }}" method="POST">
                            @csrf

                            @include('admin.pharmacy.stock.form')

                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Save Medicine
                                </button>

                                <a href="{{ route('admin.stock.index') }}" class="btn btn-light">
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
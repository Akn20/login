@extends('layouts.admin')

@section('page-title', 'Add Inventory Vendor | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Add Inventory Vendor</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item">Vendors</li>
                    <li class="breadcrumb-item">Add</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">

                    <div class="card stretch stretch-full">
                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.inventory-vendors.store') }}" method="POST">
                                @csrf

                                @include('admin.inventory_vendor.form')

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>

                                    <a href="{{ route('admin.inventory-vendors.index') }}" class="btn btn-light">
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

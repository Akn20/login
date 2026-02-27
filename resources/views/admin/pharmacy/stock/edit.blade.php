@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Edit Stock</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Stock</li>
                <li class="breadcrumb-item">Edit</li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card stretch stretch-full">
                    <div class="card-body">

                        <form action="{{ route('admin.stock.update', $batch->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @include('admin.pharmacy.stock.form')

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
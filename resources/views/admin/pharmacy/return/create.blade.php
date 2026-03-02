@extends('layouts.admin')

@section('page-title', 'Add Return | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Add Return</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Pharmacy</li>
                <li class="breadcrumb-item">Returns</li>
                <li class="breadcrumb-item">Add</li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card stretch stretch-full">
                    <div class="card-body">

                        <form action="{{ route('admin.returns.store') }}" method="POST">
                            @csrf

                            @include('admin.pharmacy.return.form')

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('admin.returns.index') }}" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
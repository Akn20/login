@extends('layouts.admin')

@section('page-title', 'Edit Return | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-title">
            <h5 class="m-b-10">Edit Return</h5>
        </div>
    </div>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card stretch stretch-full">
                    <div class="card-body">

                        <form action="{{ route('admin.returns.update', $return->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @include('admin.pharmacy.return.form')

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update</button>
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
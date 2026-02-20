@extends('layouts.admin')

@section('page-title', 'Add Blood Group | ' . config('app.name'))

@section('content')
<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center justify-content-between">
            <div>
                <div class="page-header-title">
                    <h5 class="mb-0">Add Blood Group</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item">Blood Groups</li>
                </ul>
            </div>

        </div>
    </div> 

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                            <form method="POST" action="{{ route('admin.blood-groups.store') }}">
                            @csrf

                            @include('masters.blood-groups.form')

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{ route('admin.blood-groups.index') }}" class="btn btn-light">
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

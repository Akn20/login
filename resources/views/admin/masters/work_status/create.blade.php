@extends('layouts.admin')

@section('content')

<<<<<<< HEAD
    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Add Work Status</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item">Work Status</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">

                    <div class="card stretch stretch-full">
                        <div class="card-body">

                            <form action="{{ route('admin.work-status.store') }}" method="POST">
                                @csrf

                                @include('masters.work_status.form')


                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>

                                    <a href="{{ route('admin.work-status.index') }}" class="btn btn-light">
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
=======
<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Add Work Status</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item">Work Status</li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card stretch stretch-full">
                    <div class="card-body">

<form action="{{ route('admin.work-status.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
    <label class="form-label">
        Work Status Code <span class="text-danger">*</span>
    </label>
    <input type="text" name="work_status_code" class="form-control"
        placeholder="Enter work status code">
</div>

<div class="mb-4">
    <label class="form-label">Work Status Name</label>
    <input type="text" name="work_status_name" class="form-control"
        placeholder="Enter work status name">
</div>

<div class="mb-4">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control"
        placeholder="Enter description"></textarea>
</div>


                            <div class="mb-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>

                                <a href="{{ route('admin.work-status.index') }}" class="btn btn-light">
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
>>>>>>> 5f0bf02b24999c4ebcafa7ae518a1d664ac37388

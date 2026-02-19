@extends('layouts.admin')

@section('content')

    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Add Religion</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item">Religion</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">


                    <div class="card stretch stretch-full">
                        <div class="card-body">

                            <form action="{{ route('admin.religion.store') }}" method="POST">
                                @csrf

<<<<<<< HEAD
                                @include('admin.masters.religion.form')

=======
                                <div class="mb-4">
                                    <label class="form-label">
                                        Religion Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="religion_name" class="form-control"
                                        placeholder="Enter religion name">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
>>>>>>> 5f0bf02b24999c4ebcafa7ae518a1d664ac37388

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>

                                    <a href="{{ route('admin.religion.index') }}" class="btn btn-light">
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
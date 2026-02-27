@extends('layouts.admin')

@section('content') 
<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Add Job Type</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item">Job Type</li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card stretch stretch-full">
                    <div class="card-body">

                        <form action="{{ route('admin.job-type.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
    <label class="form-label">
        Job Type Code <span class="text-danger">*</span>
    </label>
    <input type="text" name="job_type_code" class="form-control"
        placeholder="Enter job type code">
</div>

<div class="mb-4">
    <label class="form-label">Job Type Name</label>
    <input type="text" name="job_type_name" class="form-control"
        placeholder="Enter job type name">
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

                                <a href="{{ route('admin.job-type.index') }}" class="btn btn-light">
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

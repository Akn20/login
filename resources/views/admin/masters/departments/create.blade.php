@extends('layouts.admin')

@section('page-title', 'Add Department | ' . config('app.name'))

@section('content')
    <div class="nxl-content">
        <div class="page-header d-flex align-items-center justify-content-between mb-5">
            <h5 class="mb-0">Add Department</h5>
            <div class="page-header-right">
                <a href="{{ route('admin.departments.index') }}" class="btn btn-light">Back</a>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.departments.store') }}">
                            @csrf

                           @include('admin.masters.departments.form')
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary">Save</button>
                                <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
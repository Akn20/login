@extends('layouts.admin')

@section('content')
<div class="nxl-content">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Edit Nursing Note</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Nurse</li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.nursing-notes.index') }}">Nursing Notes</a>
                </li>
                <li class="breadcrumb-item">Edit</li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">

                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h6 class="mb-0">Update Nursing Note</h6>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.nursing-notes.update', $note->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @include('admin.nurse.nursing_notes.form')

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('admin.nursing-notes.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
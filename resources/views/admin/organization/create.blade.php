@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Organization</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.organization.index') }}">Organization</a>
            </li>
            <li class="breadcrumb-item">Create</li>
        </ul>
    </div>

    <div class="page-header-right ms-auto">
        <button type="submit" form="orgForm" class="btn btn-primary">
            <i class="feather-save me-2"></i> Save Organization
        </button>
    </div>
</div>

<div class="main-content">
    <form id="orgForm" method="POST" action="{{ route('admin.organization.store') }}">
        @csrf

        @include('admin.organization.form')

    </form>
</div>

@endsection

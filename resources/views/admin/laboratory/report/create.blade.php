@extends('layouts.admin')

@section('page-title', 'Upload Report | ' . config('app.name'))

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">Report Upload</h5>
    </div>

    <div class="page-header-right ms-auto">
        <button type="submit" form="reportForm" class="btn btn-primary">
            Upload
        </button>
    </div>
</div>

<div class="main-content">
    <form id="reportForm" method="POST" action="{{ route('admin.laboratory.report.store') }}" enctype="multipart/form-data">
        @include('admin.laboratory.report.form')
    </form>
</div>

@endsection
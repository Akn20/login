@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Holiday</h2>
    <div class="col-lg-9">
     <div class="page-header-right">
        <div class="mt-4 d-flex justify-content-end gap-2">
        <a href="{{ route('admin.holidays.index') }}" class="btn btn-light px-4">
            <i class="feather-arrow-left me-1"></i> Back to List
        </a>
    </div></div>

    <form action="{{ route('admin.holidays.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.Leave_Management.holidays.form')
        
        

    </form>
</div>
@endsection
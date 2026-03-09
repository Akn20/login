@extends('layouts.admin')

@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-title">
        <h5 class="m-b-10 mb-1"><i class="feather-plus me-2"></i>Create Leave Adjustment</h5>
    </div>
    <div>
        <a href="{{ route('admin.leave-adjustments.index') }}" class="btn btn-light btn-sm px-3">
            <i class="feather-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.leave-adjustments.store') }}" method="POST">
            @csrf

            @include('admin.Leave_Management.leave_adjustments.form')

        </form>

    </div>
</div>

@endsection
@extends('layouts.admin')

@section('content')
<div class="page-header mb-4 d-flex align-items-center justify-content-between">
    <div class="page-header-title">
        <h5 class="m-b-10 mb-1"><i class="feather-edit me-2"></i>Edit Holiday</h5>
    </div>
    <div>
        {{-- Reduced width back button --}}
        <a href="{{ route('admin.holidays.index') }}" class="btn btn-light btn-sm px-3">
            <i class="feather-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        {{-- Ensure the action points to your update route and has enctype for files --}}
        <form action="{{ route('admin.holidays.update', $holiday->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- This is critical for updates to work --}}

            @include('admin.Leave_Management.holidays.form')
        </form>
    </div>
</div>
@endsection
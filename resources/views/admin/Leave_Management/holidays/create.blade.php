@extends('layouts.admin')

@section('content')
    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1"><i class="feather-edit me-2"></i>Create Holiday</h5>
        </div>
        <div>
            {{-- Reduced width back button --}}
            <a href="{{ route('hr.holidays.index') }}" class="btn btn-light btn-sm px-3">
                <i class="feather-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('hr.holidays.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.Leave_Management.holidays.form')



            </form>
        </div>
    </div>
@endsection
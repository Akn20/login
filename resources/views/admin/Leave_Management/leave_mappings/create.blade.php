@extends('layouts.admin')

@section('content')

   <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1"><i class="feather-map me-2"></i>Create Leave Mapping</h5>
        </div>
        <div>
            <a href="{{ route('hr.leave-mappings.index') }}" class="btn btn-light btn-sm px-3">
                <i class="feather-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('hr.leave-mappings.store') }}" method="POST">
                @csrf
                @include('admin.Leave_Management.leave_mappings.form')
      @if(session('error_message'))
    <div class="alert alert-danger" style="color: white; background-color: #f44336; padding: 10px; margin-bottom: 15px;">
        {{ session('error_message') }}
    </div>
@endif
            </form>
        </div>
    </div>
@endsection
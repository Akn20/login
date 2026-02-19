@extends('layouts.admin')

@section('page-title', 'Edit Blood Group | ' . config('app.name'))

@section('content')
<div class="nxl-content">

    <div class="page-header d-flex align-items-center justify-content-between mb-5">
        <div class="page-header-title">   
            <h5 class="mb-0">Edit Blood Group</h5>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-12 col-md-10 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.blood-groups.update', $bloodGroup->id) }}">
                        @csrf
                        @method('PUT')
                        
                        @include('masters.blood-groups.form')
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.blood-groups.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Edit Institution</h5>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.institutions.update', $institution->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('admin.institutions.form')

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="feather-save me-2"></i> Update Institution
        </button>
    </div>
</form>

@endsection

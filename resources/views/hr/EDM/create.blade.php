@extends('layouts.admin')

@section('page-title', 'Employee Document Upload')

@section('content')

<div class="page-header mb-4">
    <div class="page-header-left">
        <h5>Upload Employee Document</h5>
    </div>
</div>

<form action="{{ route('hr.edm.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    @include('hr.EDM.form')

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">
            Save
        </button>

        <button type="submit" name="save_add_another" class="btn btn-success">
            Save & Add Another
        </button>
    </div>

</form>

@endsection
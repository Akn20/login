@extends('layouts.admin')

@section('page-title', 'Add Equipment | ' . config('app.name'))

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">Equipment</h5>
    </div>

    <div class="page-header-right ms-auto">
        <button type="submit" form="equipmentForm" class="btn btn-primary">
            Save Equipment
        </button>
    </div>
</div>

<div class="main-content">
    <form id="equipmentForm" method="POST" action="{{ route('admin.laboratory.equipment.store') }}">
        @include('admin.laboratory.equipment.form')
    </form>
</div>

@endsection
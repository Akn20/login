@extends('layouts.admin')

@section('page-title', 'Add Preventive Maintenance')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Preventive Maintenance</h5>
    </div>

    <div class="page-header-right ms-auto">
        <button type="submit" form="form" class="btn btn-primary">Save</button>
    </div>
</div>

<div class="main-content">
    <form id="form" method="POST" action="{{ route('admin.laboratory.preventive.store') }}">
        @include('admin.laboratory.preventive.form')
    </form>
</div>

@endsection
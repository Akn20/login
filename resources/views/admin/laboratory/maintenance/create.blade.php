@extends('layouts.admin')

@section('page-title', 'Add Maintenance | ' . config('app.name'))

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5>Maintenance</h5>
    </div>

    <div class="page-header-right ms-auto">
        <button type="submit" form="maintenanceForm" class="btn btn-primary">
            Save
        </button>
    </div>
</div>

<div class="main-content">
    <form id="maintenanceForm" method="POST" action="{{ route('admin.laboratory.maintenance.store') }}">
        @include('admin.laboratory.maintenance.form')
    </form>
</div>

@endsection
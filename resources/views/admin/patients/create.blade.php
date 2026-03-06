@extends('layouts.admin')

@section('page-title', 'Add Patient | ' . config('app.name'))

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">Patient</h5>
    </div>

    <div class="page-header-right ms-auto">
        <button type="submit" form="patientForm" class="btn btn-primary">
            Save Patient
        </button>
    </div>
</div>

<div class="main-content">
    <form id="patientForm" method="POST" action="{{ route('admin.patients.store') }}">
        @include('admin.patients.form')
    </form>
</div>

@endsection
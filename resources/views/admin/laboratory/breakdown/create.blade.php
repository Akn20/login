@extends('layouts.admin')

@section('page-title', 'Add Breakdown | ' . config('app.name'))

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h5 class="m-b-10">Breakdown</h5>
    </div>

    <div class="page-header-right ms-auto">
        <button type="submit" form="breakdownForm" class="btn btn-primary">
            Save
        </button>
    </div>
</div>

<div class="main-content">
    <form id="breakdownForm" method="POST" action="{{ route('admin.laboratory.breakdown.store') }}">
        @include('admin.laboratory.breakdown.form')
    </form>
</div>

@endsection
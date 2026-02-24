@extends('layouts.admin')
@section('page-title', 'Create Weekend Configuration | ' . config('app.name'))
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h5 class="m-b-10">Create Weekend Configuration</h5>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.weekends.store') }}" method="POST">
            @csrf

            @include('admin.Leave_Management.Weekend.form')

        </form>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h5 class="m-b-10">Edit Module</h5>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('modules.update', $module->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('modules.form')

        </form>
    </div>
</div>

@endsection
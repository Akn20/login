@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h5 class="m-b-10">Edit Weekend Configuration</h5>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.weekends.update', $weekend->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.Leave_Management.Weekend.form')

        </form>
    </div>
</div>
@endsection

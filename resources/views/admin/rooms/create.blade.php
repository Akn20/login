@extends('layouts.admin')

@section('page-title', 'Add Room | ' . config('app.name'))

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Add New Room</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf

                @include('admin.rooms.form')

            </form>
        </div>
    </div>
</div>

@endsection



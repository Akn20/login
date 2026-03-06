@extends('layouts.admin')

@section('page-title', 'Edit Room | ' . config('app.name'))

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Edit Room</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.rooms.form')

            </form>
        </div>
    </div>
</div>

@endsection
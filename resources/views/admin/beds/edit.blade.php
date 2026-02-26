@extends('layouts.admin')

@section('page-title', 'Edit Bed | ' . config('app.name'))

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Edit Bed</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.beds.update', $bed->id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.beds.form')

               
            </form>
        </div>
    </div>
</div>

@endsection
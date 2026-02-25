@extends('layouts.admin')

@section('page-title', 'Edit Ward | ' . config('app.name'))

@section('content')

    <form action="{{ route('admin.ward.update', $ward->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.ward.form')

        <div class="mt-3">
            <button class="btn btn-primary">Update Ward</button>
        </div>

    </form>

@endsection
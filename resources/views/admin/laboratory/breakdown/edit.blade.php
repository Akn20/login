@extends('layouts.admin')

@section('page-title', 'Edit Breakdown | ' . config('app.name'))

@section('content')

<div class="main-content">
    <form method="POST" action="{{ route('admin.laboratory.breakdown.update', $breakdown->id) }}">
        @csrf
        @method('PUT')

        @include('admin.laboratory.breakdown.form')

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection
@extends('layouts.admin')

@section('content')

<div class="main-content">
    <form method="POST" action="{{ route('admin.laboratory.preventive.update', $record->id) }}">
        @csrf
        @method('PUT')

        @include('admin.laboratory.preventive.form')

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection
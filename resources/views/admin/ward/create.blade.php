@extends('layouts.admin')

@section('content')

    <form action="{{ route('admin.ward.store') }}" method="POST">
        @csrf

        @include('admin.ward.form')

        <div class="mt-3">
            <button class="btn btn-primary">Save Ward</button>
        </div>

    </form>

@endsection
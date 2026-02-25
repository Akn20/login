@extends('layouts.app')

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

                @include('beds.form')

               
            </form>
        </div>
    </div>
</div>

@endsection
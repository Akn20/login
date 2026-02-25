@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Add New Bed</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.beds.store') }}" method="POST">
                @csrf

                @include('admin.beds.form')

               
            </form>
        </div>
    </div>
</div>

@endsection
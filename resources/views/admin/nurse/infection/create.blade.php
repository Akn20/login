@extends('layouts.admin')

@section('page-title', 'Add Infection Log')

@section('content')

    <div class="nxl-content">

        <h5>Add Infection Log</h5>

        <form action="{{ route('admin.infection.store') }}" method="POST">
            @csrf

            @include('admin.nurse.infection.form')

            <div class="d-flex gap-2">

                <button class="btn btn-primary">

                    Save

                </button>


                <a href="{{ route('admin.infection.index') }}" class="btn btn-light">

                    Cancel

                </a>

            </div>
        </form>

    </div>

@endsection
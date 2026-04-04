@extends('layouts.admin')

@section('page-title', 'Edit Infection Log')

@section('content')

    <div class="nxl-content">

        <h5>Edit Infection Log</h5>

        <form action="{{ route('admin.infection.update', $log->id) }}" method="POST">
            @csrf

            @include('admin.nurse.infection.form')

            <div class="d-flex gap-2">

                <button class="btn btn-primary">

                    Update

                </button>


                <a href="{{ route('admin.controlledDrug.index') }}" class="btn btn-light">

                    Cancel

                </a>

            </div>
        </form>

    </div>

@endsection
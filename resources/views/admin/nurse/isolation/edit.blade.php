@extends('layouts.admin')

@section('page-title', 'Edit Isolation Record')

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <h5>Edit Isolation Record</h5>
        </div>

        <div class="main-content">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.isolation.update', $record->id) }}" method="POST">
                        @csrf

                        @include('admin.nurse.isolation.form')

                        <div class="d-flex gap-2">

                            <button class="btn btn-primary">

                                Update

                            </button>


                            <a href="{{ route('admin.isolation.index') }}" class="btn btn-light">

                                Cancel

                            </a>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Add Isolation Record')

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <h5>Add Isolation Record</h5>
        </div>

        <div class="main-content">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.isolation.store') }}" method="POST">
                        @csrf

                        @include('admin.nurse.isolation.form')

                        <div class="d-flex gap-2">

                            <button class="btn btn-primary">

                                Save

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
@extends('layouts.admin')

@section('page-title', 'Edit PPE Record')

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <h5>Edit PPE Compliance Record</h5>
        </div>

        <div class="main-content">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.ppe.update', $log->id) }}" method="POST">
                        @csrf

                        @include('admin.nurse.ppe.form')

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
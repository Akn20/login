@extends('layouts.admin')

@section('page-title', 'Add Patient Vitals | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5>Add Patient Vitals</h5>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">

                    <div class="card stretch stretch-full">
                        <div class="card-body">

                            <form action="{{ route('admin.patientMonitoring.store') }}" method="POST">
                                @csrf

                                @include('admin.nurse.patientMonitoring.form')

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Save</button>

                                    <a href="{{ route('admin.patientMonitoring.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
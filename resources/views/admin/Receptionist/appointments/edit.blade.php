@extends('layouts.admin')

@section('page-title', 'Edit Appointment | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">
                    <h5 class="m-b-10">Edit Appointment</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Receptionist</li>
                    <li class="breadcrumb-item">Appointments</li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>

            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card stretch stretch-full">

                        <div class="card-body">

                            <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">

                                @csrf
                                @method('PUT')

                                @include('admin.receptionist.appointments.form')

                                <div class="d-flex gap-2 mt-3">

                                    <button type="submit" class="btn btn-primary">
                                        Update Appointment
                                    </button>

                                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
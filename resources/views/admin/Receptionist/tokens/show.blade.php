@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Token Details</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Receptionist</li>
                <li class="breadcrumb-item">Token & Queue Management</li>
                <li class="breadcrumb-item">View</li>
            </ul>
        </div>

        <div class="page-header-right ms-auto d-flex gap-2">
            <a href="{{ route('admin.tokens.edit', $token->id) }}" class="btn btn-neutral">
                Reassign Token
            </a>

            <a href="{{ route('admin.tokens.index') }}" class="btn btn-neutral">
                Back
            </a>
        </div>
    </div>


    <div class="main-content">
        <div class="row">

            {{-- Token Information --}}
            <div class="col-lg-4">

                <div class="card stretch stretch-full">

                    <div class="card-header">
                        <h5 class="card-title">Token Information</h5>
                    </div>

                    <div class="card-body">

                        <table class="table table-borderless mb-0">

                            <tr>
                                <th class="ps-0" style="width:150px;">Token Number</th>
                                <td>{{ $token->token_number }}</td>
                            </tr>

                            <tr>
                                <th class="ps-0">Status</th>
                                <td>

                                    @if($token->status == 'WAITING')
                                        <span class="badge bg-soft-warning text-warning">
                                            Waiting
                                        </span>

                                    @elseif($token->status == 'SKIPPED')
                                        <span class="badge bg-soft-danger text-danger">
                                            Skipped
                                        </span>

                                    @elseif($token->status == 'COMPLETED')
                                        <span class="badge bg-soft-success text-success">
                                            Completed
                                        </span>
                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <th class="ps-0">Generated At</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($token->created_at)->format('d-m-Y H:i') }}
                                </td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>



            {{-- Appointment Details --}}
            <div class="col-lg-8">

                <div class="card stretch stretch-full">

                    <div class="card-header">
                        <h5 class="card-title">Appointment Details</h5>
                    </div>

                    <div class="card-body">

                        <table class="table table-borderless mb-0">

                            <tr>
                                <th style="width:200px;">Appointment ID</th>
                                <td>{{ $token->appointment->id }}</td>
                            </tr>

                            <tr>
                                <th>Patient</th>
                                <td>
                                    {{ $token->appointment->patient->first_name }}
                                    {{ $token->appointment->patient->last_name }}
                                </td>
                            </tr>

                            <tr>
                                <th>Patient Code</th>
                                <td>
                                    {{ $token->appointment->patient->patient_code }}
                                </td>
                            </tr>

                            <tr>
                                <th>Doctor</th>
                                <td>
                                    {{ $token->appointment->doctor->first_name }}
                                    {{ $token->appointment->doctor->last_name }}
                                </td>
                            </tr>

                            <tr>
                                <th>Department</th>
                                <td>
                                    {{ $token->appointment->department->department_name }}
                                </td>
                            </tr>

                            <tr>
                                <th>Appointment Date</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($token->appointment->appointment_date)->format('d-m-Y') }}
                                </td>
                            </tr>

                            <tr>
                                <th>Appointment Time</th>
                                <td>
                                    {{ $token->appointment->appointment_time }}
                                </td>
                            </tr>

                        </table>

                    </div>

                </div>

                {{-- Future Feature --}}
                {{-- Queue History / Token Movement can be added here later --}}

            </div>

        </div>
    </div>

</div>

@endsection
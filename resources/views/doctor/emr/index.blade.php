@extends('layouts.admin')

@section('page-title', 'EMR ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">

        <div class="page-header-left d-flex align-items-center">

            <div class="page-header-title">
                <h5 class="m-b-10">Electronic Medical Records</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Doctor</li>
                <li class="breadcrumb-item">EMR</li>
            </ul>
        </div>
    </div>

    <div class="main-content">

        <div class="card">

            <div class="card-header">
                <strong>Patient Records</strong>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>Patient Code</th>
                                <th>Patient Name</th>
                                <th>Gender</th>
                                <th>Mobile</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse($patients as $patient)

                            <tr>

                                <td>{{ $patient->patient_code }}</td>

                                <td>{{ $patient->first_name }}{{ $patient->last_name }}
                                </td>

                                <td>
                                    {{ $patient->gender }}
                                </td>

                                <td>
                                    {{ $patient->mobile }}
                                </td>

                                <td>

                                    <a href="{{ route('doctor.emr.show',$patient->id) }}"
                                       class="btn btn-sm btn-primary">

                                        View EMR

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">

                                    No Records Found

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
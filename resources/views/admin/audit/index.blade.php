@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h4>
                Doctor Audit Logs
            </h4>

        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row mb-3">

                    <div class="col-md-2">

    <select
        name="doctor_id"
        class="form-control">

        <option value="">
            All Doctors
        </option>

        @foreach($doctors as $doctor)

            <option value="{{ $doctor->id }}">

                {{ $doctor->name }}

            </option>

        @endforeach

    </select>

</div>

                    <div class="col-md-2">

                        <select
                            name="patient_id"
                            class="form-control">

                            <option value="">
                                All Patients
                            </option>

                            @foreach($patients as $patient)

                                <option
                                    value="{{ $patient->id }}">

                                    {{ $patient->first_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select
                            name="action_type"
                            class="form-control">

                            <option value="">
                                All Actions
                            </option>

                            <option value="CREATE">
                                CREATE
                            </option>

                            <option value="UPDATE">
                                UPDATE
                            </option>

                            <option value="DELETE">
                                DELETE
                            </option>

                            <option value="VIEW">
                                VIEW
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <input
                            type="date"
                            name="from_date"
                            class="form-control">

                    </div>

                    <div class="col-md-2">

                        <input
                            type="date"
                            name="to_date"
                            class="form-control">

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary w-100">

                            Filter

                        </button>

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Date</th>

                            <th>Doctor</th>

                            <th>Patient</th>

                            <th>Module</th>

                            <th>Action</th>

                            <th>View</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($logs as $log)

                        <tr>

                            <td>
                                {{ $log->created_at }}
                            </td>

                            <td>
                                {{ optional($log->doctor)->name }}
                            </td>

                            <td>
                                {{ optional($log->patient)->first_name }}
                            </td>

                            <td>
                                {{ $log->module_name }}
                            </td>

                            <td>

                                <span class="badge bg-info">

                                    {{ $log->action_type }}

                                </span>

                            </td>

                            <td>

                                <a
                                    href="{{ route('admin.doctor-audit.show', $log->id) }}"
                                    class="btn btn-sm btn-primary">

                                    View

                                </a>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{ $logs->links() }}

        </div>

    </div>

</div>

@endsection
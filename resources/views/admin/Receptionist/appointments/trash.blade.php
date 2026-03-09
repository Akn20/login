@extends('layouts.admin')

@section('page-title', 'Deleted Appointments')

@section('content')

    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-title">
                <h5>Deleted Appointments</h5>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <table class="table">

                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($appointments as $appointment)

                            <tr>

                                <td>{{ $appointment->patient->first_name ?? '' }}</td>
                                <td>{{ $appointment->doctor->name ?? '' }}</td>
                                <td>{{ $appointment->appointment_date }}</td>

                                <td>

                                    <a href="{{ route('admin.appointments.restore', $appointment->id) }}"
                                        class="btn btn-success btn-sm">
                                        Restore
                                    </a>

                                    <form action="{{ route('admin.appointments.forceDelete', $appointment->id) }}" method="POST"
                                        style="display:inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            Delete Permanently
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>

    </div>

@endsection